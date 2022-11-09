<?php

    namespace App\Http\Services\Equipment;

    use App\ControlEquipment;
    use App\ControlEvent;
    use App\Equipment;
    use App\EquipmentInstruction;
    use App\EquipmentParam;
    use App\EquipmentQualifiedUser;
    use App\ProductInstructedUser;
    use App\ProductQualifiedUser;
    use App\ProduktAnforderung;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Validation\Rule;

    class EquipmentService
    {

        protected function query(string $term)
        {
            return Equipment::whereRaw('LOWER(eq_serien_nr) LIKE (?)', '%' . strtolower($term) . '%')
                ->orWhereRaw('LOWER(eq_inventar_nr) LIKE (?)', '%' . strtolower($term) . '%')
                ->orWhereRaw('LOWER(eq_text) LIKE (?)', '%' . strtolower($term) . '%')
                ->orWhere('eq_uid', 'like', '%' . strtolower($term) . '%')
                ->orWhereRaw('LOWER(eq_name) LIKE (?)', '%' . strtolower($term) . '%')
                ->get();
        }

        public static function getSearchResults(string $term): array
        {

            $data = [];

            foreach ((new EquipmentService)->query($term) as $ret) {
                $data[] = [
                    'link'  => route('equipment.show', $ret),
                    'label' => '[' . __('Gerät') . '] Inv-#: ' . $ret->eq_inventar_nr . ' SN-#: ' . $ret->eq_serien_nr
                ];
            }

            return $data;

        }

        public static function search(string $term)
        {
            return (new EquipmentService)->query($term);
        }

        public function vaidateEquipmnt(Request $request)
        {
            $request->validate([
                'eq_inventar_nr'     => [
                    'bail',
                    'max:100',
                    'required',
                    Rule::unique('equipment')->ignore($request->id)
                ],
                'eq_serien_nr'       => [
                    'bail',
                    'nullable',
                    'max:100',
                    Rule::unique('equipment')->ignore($request->id)
                ],
                'eq_uid'             => [
                    'bail',
                    'required',
                    Rule::unique('equipment')->ignore($request->id)
                ],
                'eq_name'            => '',
                'eq_qrcode'          => '',
                'eq_text'            => '',
                'eq_price'           => 'nullable|numeric',
                'installed_at'       => 'date',
                'purchased_at'       => 'date',
                'produkt_id'         => '',
                'storage_id'         => 'required',
                'equipment_state_id' => 'required'
            ]);
        }

        public function getUpcomingControlItems(Equipment $equipment)
        {
            return ControlEquipment::join('anforderungs', 'control_equipment.anforderung_id', '=', 'anforderungs.id')
                ->where('equipment_id', $equipment->id)
                ->where('is_initial_test', false)
                ->orderBy('qe_control_date_due')
                ->get();
        }

        public function checkUpdatedFields(Request $request, Equipment $oldEquipment): array
        {
            $feld = '';
            $flag = false;
            $feld .= __(':user führte folgende Änderungen durch', ['user' => Auth::user()->username]) . ': <ul>';
            if ($oldEquipment->eq_serien_nr != $request->eq_serien_nr) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('Seriennummer'),
                        'old' => $oldEquipment->eq_serien_nr,
                        'new' => $request->eq_serien_nr,
                    ]) . '</li>';
                $flag = true;
            }

            if ($oldEquipment->eq_qrcode != $request->eq_qrcode) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('QR Code'),
                        'old' => $oldEquipment->eq_qrcode,
                        'new' => $request->eq_qrcode,
                    ]) . '</li>';
                $flag = true;
            }

            if ($oldEquipment->eq_name != $request->eq_name) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('Name'),
                        'old' => $oldEquipment->eq_name,
                        'new' => $request->eq_name,
                    ]) . '</li>';
                $flag = true;
            }

            if ($oldEquipment->purchased_at != $request->purchased_at) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('Kaufdatum'),
                        'old' => $oldEquipment->purchased_at,
                        'new' => $request->purchased_at,
                    ]) . '</li>';
                $flag = true;
            }

            if ($oldEquipment->installed_at != $request->installed_at) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('Inbetriebnahme am'),
                        'old' => $oldEquipment->installed_at,
                        'new' => $request->installed_at,
                    ]) . '</li>';
                $flag = true;
            }
            if ($oldEquipment->eq_text != $request->eq_text) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('Beschreibung'),
                        'old' => $oldEquipment->eq_text,
                        'new' => $request->eq_text,
                    ]) . '</li>';
                $flag = true;
            }
            if ($oldEquipment->equipment_state_id != $request->equipment_state_id) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('Geräte Status'),
                        'old' => $oldEquipment->equipment_state_id,
                        'new' => $request->equipment_state_id,
                    ]) . '</li>';
                $flag = true;
            }
            if ($oldEquipment->storage_id != $request->storage_id) {
                $feld .= '<li>' . __('Feld :fld von [:old] in [:new] geändert', [
                        'fld' => __('Aufstellplatz / Standort'),
                        'old' => $oldEquipment->storage->storage_label ?? __('ohne Zuordnung'),
                        'new' => \App\Storage::find($request->storage_id)->storage_label,
                    ]) . '</li>';
                $flag = true;
            }
            if ($oldEquipment->produkt_id != $request->produkt_id) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('Produkt'),
                        'old' => $oldEquipment->produkt_id,
                        'new' => $request->produkt_id,
                    ]) . '</li>';
                $flag = true;
            }

            if ($oldEquipment->eq_price != $request->eq_price) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('Kaufpreis'),
                        'old' => $oldEquipment->eq_price,
                        'new' => $request->eq_price,
                    ]) . '</li>';
                $flag = true;
            }
            $changedPrameter = [];


            if (isset($request->eqp_id)) {

                foreach ($request->eqp_id as $parameter_id) {
                    $parameter = EquipmentParam::find($parameter_id);
                    $parameter->ep_value = $request->eqp_value[$parameter_id];
                    if ($parameter->save() && $parameter->ep_value !== $request->eqp_value[$parameter_id]) {
                        $changedPrameter[] = [$parameter_id => $request->eqp_value[$parameter_id]];
                        $feld .= __('<li>:num Parameter :name geändert</li>', [
                            'num'  => count($changedPrameter),
                            'name' => $parameter->ep_name
                        ]);
                    }
                }

            }

            $feld .= '</ul>';

            return [
                'changedItems'    => $feld,
                'changedStatus'   => $flag,
                'changedPrameter' => $changedPrameter,
            ];

        }

        public function transferProductQualifiedUser(Request $request, Equipment $equipment): void
        {
            foreach (ProductQualifiedUser::where('produkt_id', $request->produkt_id)->get() as $productQualifiedUser) {
                (new EquipmentQualifiedUser)->addEquipment($productQualifiedUser, $equipment->id);
            }
        }

        public function transferProductInstructedUser(Request $request, Equipment $equipment): void
        {
            foreach (ProductInstructedUser::where('produkt_id', $request->produkt_id)->get() as $productInstructedUser) {
                (new EquipmentInstruction)->addEquipment($productInstructedUser, $equipment->id);
            }
        }

        public function transferProductParameters(Request $request, Equipment $equipment)
        {
            if (isset($request->pp_id) && count($request->pp_id) > 0) {
                for ($i = 0; $i < count($request->pp_id); $i++) (new EquipmentParam)->addEquipment($request->pp_id[$i], $request->ep_value[$i], $equipment->id);
            }
        }

        public function getRequirementList(Equipment $equipment)
        {
            return ProduktAnforderung::where('produkt_id', $equipment->produkt->id)->get();
        }

        public function getInstruectedPersonList(Equipment $equipment)
        {
            return EquipmentInstruction::select('id', 'equipment_instruction_trainee_id')->where('equipment_id', $equipment->id)->get();
        }

        public function getQualifiedPersonList(Equipment $equipment): array
        {
            $userList = [];
            foreach (EquipmentQualifiedUser::select('user_id')->where('equipment_id', $equipment->id)->get() as $user) {
                $userList[] = ['user_id' => $user->user_id];
            }

            foreach (ProductQualifiedUser::select('user_id')->where('produkt_id', $equipment->produkt->id)->get() as $user) {
                $userList[] = ['user_id' => $user->user_id];
            }
            return $userList;
        }


        public function makeCompanyString(Equipment $equipment, string $companyString = ''): string
        {

            foreach ($equipment->produkt->firma as $firma) {
                $companyString .= $firma->fa_name . ' ';
            }

            return $companyString;
        }

        public function checkUserQualified(Equipment $equipment): bool
        {
            return Auth::user()->isQualified($equipment->id);
        }

        public static function isTested(Equipment $equipment): bool
        {
            return ControlEquipment::onlyTrashed()->where('equipment_id', $equipment->id)->count() > 0;
        }

        public function getRecentExecutedControls(Equipment $equipment)
        {
            return ControlEquipment::where('equipment_id',$equipment->id)->take(5)->latest()->onlyTrashed()->get();
        }

    }