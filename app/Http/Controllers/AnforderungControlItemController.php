<?php

    namespace App\Http\Controllers;

    use App\Anforderung;
    use App\AnforderungControlItem;
    use App\ControlEventItem;
    use Exception;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Validation\Rule;
    use Illuminate\View\View;

    class AnforderungControlItemController extends Controller
    {

        public function __construct()
        {
            $this->middleware('auth');
        }

        /**
         * Display a listing of the resource.
         *
         * @return Application|Factory|View
         */
        public function index()
        {

            return view('admin.verordnung.anforderungitem.index', [
                'aciitems' => AnforderungControlItem::sortable()->paginate(10)
            ]);

        }

        /**
         * Show the form for creating a new resource.
         *
         * @param Request $request
         *
         * @return Application|Factory|View
         */
        public function create(Request $request)
        {
            return view('admin.verordnung.anforderungitem.create', ['rid' => $request->input('rid')]);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param Request $request
         *
         * @return RedirectResponse
         */
        public function store(Request $request): RedirectResponse
        {

            $this->validateAnforderungControlItem();

            $testStep = (new AnforderungControlItem)->add($request);

            if ($testStep) {
                $request->session()->flash('status', __('Der Prüfschritt <strong>:label</strong> wurde angelegt!', ['label' => request('aci_label')]));
                return redirect()->route('anforderungcontrolitem.show', $testStep);
            } else {
                Log::error('Error during creation of test step ' . request('aci_label'));
                $request->session()->flash('status', __('Der Prüfschritt <strong>:label</strong> konnte nicht angelegt werden!', ['label' => request('aci_label')]));
                return redirect()->route('anforderungcontrolitem.index');
            }
        }


        /**
         * Copy an existing resource in storage.
         *
         * @param AnforderungControlItem $anforderungcontrolitem
         * @param Request $request
         *
         * @return RedirectResponse
         */
        public function copy(AnforderungControlItem $anforderungcontrolitem, Request $request)
        {
            $newAciLabel = 'aci_' . substr(md5($anforderungcontrolitem->aci_label), 0, 14);
            $newAci = $anforderungcontrolitem->replicate()->fill(['aci_label' => $newAciLabel]);
            $newAci->save();
            $request->session()->flash('status', __('Der Prüfschritt <strong>:label</strong> wurde kopiert!', ['label' => request('aci_label')]));
            return redirect()->route('anforderungcontrolitem.show', ['anforderungcontrolitem' => $newAci]);
        }

        /**
         * Display the specified resource.
         *
         * @param AnforderungControlItem $anforderungcontrolitem
         *
         * @return Application|Factory|\Illuminate\Contracts\View\View
         */
        public function show(AnforderungControlItem $anforderungcontrolitem)
        {
            return view('admin.verordnung.anforderungitem.show', [
                'anforderungcontrolitem' => $anforderungcontrolitem,
                'testEventFromItem'      => ControlEventItem::withTrashed()->with('ControlEvent')->where('control_item_aci', $anforderungcontrolitem->id)->get()
            ]);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param Request $request
         * @param AnforderungControlItem $anforderungcontrolitem
         *
         * @return RedirectResponse
         */
        public function update(Request $request, AnforderungControlItem $anforderungcontrolitem)
        {
            $anforderungcontrolitem->update($this->validateAnforderungControlItem());
            $request->session()->flash('status', __('Der Prüfschritt <strong>:name</strong> wurde aktualisiert!', ['name' => request('aci_name')]));
            return back();
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param AnforderungControlItem $anforderungcontrolitem
         *
         * @return RedirectResponse
         * @throws Exception
         */
        public function destroy(AnforderungControlItem $anforderungcontrolitem)
        {
            request()->session()->flash('status', __('Der Prüfschritt <strong>:name</strong> wurde gelöscht!', ['name' => $anforderungcontrolitem->aci_name]));
            $anforderungcontrolitem->delete();
            return redirect()->route('anforderungcontrolitem.index');
        }

        public function applySort(Request $request)
        {
            $res = [];
            foreach($request['aci_id'] as $key => $id){

                $aci = AnforderungControlItem::find($id);
                $aci->aci_sort = $request['aci_sort'][$key];
                $res[$id] = $aci->save();

            }

            $request->session()->flash('status',array_search(false,$res) ?  __('Fehler ... sorry') : __('Sortierung erfolgreich angewendet'));
            return back();
        }

        public function getAnforderungControlItemData(Request $request)
        {
            return AnforderungControlItem::findorFail($request->id);
        }

        /**
         * @return array
         */
        public function validateAnforderungControlItem(): array
        {
            return request()->validate([
                'aci_label'                      => [
                    'bail',
                    'alpha_dash',
                    'required',
                    'max:20',
                    Rule::unique('anforderung_control_items')->ignore(\request('id'))
                ],
                'aci_name'                       => 'required',
                'aci_task'                       => '',
                'aci_value_si'                   => 'max:10',
                'aci_vaule_soll'                 => '',
                'aci_value_target_mode'          => '',
                'aci_value_tol'                  => '',
                'aci_value_tol_mod'              => '',
                'aci_execution'                  => 'bool',
                'aci_control_equipment_required' => '',
                'firma_id'                       => 'int|nullable',
                'aci_contact_id'                 => 'required',
                'anforderung_id'                 => 'required',
                'aci_sort'                       => 'numeric',
            ]);
        }
    }
