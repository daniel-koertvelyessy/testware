<?php

namespace App\Http\Controllers;

use App\AciDataSet;
use App\Anforderung;
use App\AnforderungControlItem;
use App\ControlEventItem;
use App\Http\Services\Regulation\RequirementControlItemService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AnforderungControlItemController extends Controller
{

    private int $keepChars = 5;

    public function __construct(
    )
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(
    )
    {

        return view('admin.verordnung.anforderungitem.index',
            [
                'aciitems' => AnforderungControlItem::sortable()->paginate(10)
            ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     *
     * @return Application|Factory|View
     */
    public function create(
        Request $request
    ) {
        $service = new RequirementControlItemService();

        return view('admin.verordnung.anforderungitem.create',
            ['rid' => $request->input('rid')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function store(
        Anforderung $anforderung,
        Request $request
    ): RedirectResponse {

        //dd($request->sort != null && isset($request->placeafteritem));
        $this->validateAnforderungControlItem();

        $testStep = (new AnforderungControlItem)->add($request);

        if ($testStep) {

            $service = new RequirementControlItemService();
            if ($request->sort != null && isset($request->placeafteritem)) {
                $service->resortItems($request->sort,
                    $request->placeafteritem,
                    Anforderung::findOrFail($request->anforderung_id));
            }

            $request->session()->flash('status',
                __('Der Prüfschritt <strong>:label</strong> wurde angelegt!',
                    ['label' => request('aci_label')]));
            return redirect()->route('anforderungcontrolitem.show',
                $testStep);

        } else {
            Log::error('Error during creation of test step '.request('aci_label'));
            $request->session()->flash('status',
                __('Der Prüfschritt <strong>:label</strong> konnte nicht angelegt werden!',
                    ['label' => request('aci_label')]));
            return redirect()->route('anforderungcontrolitem.index');
        }
    }

    public function copy(AnforderungControlItem $anforderungcontrolitem, Request $request)
    {

        $copy = $this->findCopies($anforderungcontrolitem->aci_label);

        $copy_aci = $anforderungcontrolitem->replicate()->fill([
            'aci_label' => substr($anforderungcontrolitem->aci_label,0,$this->keepChars).'_copy_' . $copy+1,
            'aci_sort' => $anforderungcontrolitem->aci_sort + 5
                                                               ]);

        $msg = ($copy_aci->save())
            ? __('Der Prüfschritt <strong>:label</strong> wurde kopiert',
                 ['label' => request('aci_label')])
            : __('Fehler beim Kopieren von Prüfschritt <strong>:label</strong>!',
                 ['label' => request('aci_label')]);
        $request->session()->flash('status', $msg);
        return back();
    }

    private function findCopies(String $label):Int{
        return AnforderungControlItem::withTrashed()->where('aci_label','ILIKE',substr($label,0,$this->keepChars).'%' )->count();
    }

    public function fixbroken(
        AnforderungControlItem $aci, Request $request
    ) {
        if ($request->anforderung_id === 0){
            $request->session()->flash('status', 'Bitte eine Anforderung auswählen');
            return back();
        }
        $aci->anforderung_id = $request->anforderung_id;
        $msg = $aci->save()
            ? 'Prüfschritt korrigiert'
            : 'Fehler beim Speichern';
        $request->session()->flash('status', $msg);
        return back();
    }

     /**
     * Copy an existing resource in storage.
     *
     * @param  AnforderungControlItem  $anforderungcontrolitem
     * @param  Request  $request
     *
     * @return RedirectResponse
     */

     /*

    public function copy(
        AnforderungControlItem $anforderungcontrolitem,
        Request $request
    ) {
        $newAciLabel = 'aci_'.substr(md5($anforderungcontrolitem->aci_label),
                0,
                14);
        $newAci = $anforderungcontrolitem->replicate()->fill(['aci_label' => $newAciLabel]);
        $newAci->save();
        $request->session()->flash('status',
            __('Der Prüfschritt <strong>:label</strong> wurde kopiert!',
                ['label' => request('aci_label')]));
        return redirect()->route('anforderungcontrolitem.show',
            ['anforderungcontrolitem' => $newAci]);
    }
    */

    /**
     * Display the specified resource.
     *
     * @param  AnforderungControlItem  $anforderungcontrolitem
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function show(
        AnforderungControlItem $anforderungcontrolitem
    ) {
        return view('admin.verordnung.anforderungitem.show',
            [
                'anforderungcontrolitem' => $anforderungcontrolitem,
                'testEventFromItem' => ControlEventItem::withTrashed()
                                                       ->with('ControlEvent')
                                                       ->where('control_item_aci', $anforderungcontrolitem->id)
                                                       ->get(),
                'dataSetItems' => AciDataSet::all()
                                            ->sortBy('data_point_sort')
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  AnforderungControlItem  $anforderungcontrolitem
     *
     * @return RedirectResponse
     */
    public function update(
        Request $request,
        AnforderungControlItem $anforderungcontrolitem
    ) {
        $anforderungcontrolitem->update($this->validateAnforderungControlItem());
        $request->session()->flash('status',
            __('Der Prüfschritt <strong>:name</strong> wurde aktualisiert!',
                ['name' => request('aci_name')]));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AnforderungControlItem  $anforderungcontrolitem
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(
        AnforderungControlItem $anforderungcontrolitem
    ) {

       $msg =( $this->renameLabelPriorSoftDelete($anforderungcontrolitem) && $anforderungcontrolitem->delete() )
           ?  __('Der Prüfschritt <strong>:name</strong> wurde gelöscht!',['name' => $anforderungcontrolitem->aci_name])
           :  __('Der Prüfschritt <strong>:name</strong> konnte nicht gelöscht werden!',['name' => $anforderungcontrolitem->aci_name]);
        request()->session()->flash('status', $msg);
        return back();
    }

    private function renameLabelPriorSoftDelete(AnforderungControlItem $aci):bool{
        $aci->aci_label = substr(Str::uuid(), 0,19);
        return $aci->save();
    }

    public function applySort(
        Request $request
    ) {
        $res = [];
        foreach ($request['aci_id'] as $key => $id) {

            $aci = AnforderungControlItem::find($id);
            $aci->aci_sort = $request['aci_sort'][$key];
            $res[$id] = $aci->save();

        }

        $request->session()->flash('status',
            array_search(false,
                $res) ? __('Fehler ... sorry') : __('Sortierung erfolgreich angewendet'));
        return back();
    }

    public function getAnforderungControlItemData(
        Request $request
    ) {
        return AnforderungControlItem::findorFail($request->id);
    }

    public function getAciList(
        Request $request
    ) {

        $html = '';
        $pos = 5;

        foreach (\App\Anforderung::find($request->id)->AnforderungControlItem as $aci) {
            $pos = $aci->aci_sort ?? $pos;
            $html .= '
                <label for="acilistitem'.$aci->id.'" class="acilistitem border border-primary px-2 py-1 rounded w-100 btn-outline-primary d-flex justify-content-between align-items-center">
                    <span>
                        <input type="radio"
                           name="acilistitem[]"
                           id="acilistitem'.$aci->id.'"
                           value="'.$aci->id.'|'.$pos.'"
                    >
                    <span class="ml-3">'.$aci->aci_label.'</span>
                    </span>
                    <span>'.$pos.'</span>
                </label>
                ';
            $pos = $pos + 5;
        }

        return $html;
    }

    /**
     * @return array
     */
    public function validateAnforderungControlItem(
    ): array
    {
        return request()->validate([
            'aci_label' => [
                'bail',
                'alpha_dash',
                'required',
                'max:20',
                Rule::unique('anforderung_control_items')->ignore(\request('id'))
            ],
            'aci_name' => 'required',
            'aci_task' => '',
            'aci_value_si' => 'max:10',
            'aci_vaule_soll' => '',
            'aci_value_target_mode' => '',
            'aci_value_tol' => '',
            'aci_value_tol_mod' => '',
            'aci_execution' => 'bool',
            'aci_control_equipment_required' => '',
            'firma_id' => 'nullable',
            'aci_contact_id' => 'nullable',
            'anforderung_id' => 'required',
            'aci_sort' => 'int',
        ]);
    }
}
