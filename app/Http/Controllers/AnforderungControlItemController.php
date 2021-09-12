<?php

namespace App\Http\Controllers;

use App\AnforderungControlItem;
use App\ControlEventItem;
use Exception;
use http\Client\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * @param  Request $request
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
     * @param  Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->firma_id = ($request->aci_exinternal === 'internal') ? 1 : $request->firma_id;

        AnforderungControlItem::create($this->validateAnforderungControlItem());

        $request->session()->flash('status', __('Der Prüfschritt <strong>:label</strong> wurde angelegt!', ['label' => request('aci_label')]));
        return back();
    }

    /**
     * @return array
     */
    public function validateAnforderungControlItem()
    : array
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
            'aci_execution'                  => '',
            'aci_control_equipment_required' => '',
            'firma_id'                       => '',
            'aci_contact_id'                 => 'required',
            'anforderung_id'                 => 'required',
        ]);
    }

    /**
     * Copy an existing resource in storage.
     *
     * @param  AnforderungControlItem $anforderungcontrolitem
     * @param  Request                $request
     *
     * @return RedirectResponse
     */
    public function copy(AnforderungControlItem $anforderungcontrolitem, Request $request)
    {
        $txt = 'aci_' . substr(md5($anforderungcontrolitem->aci_label), 0, 14);

        $newAci = $anforderungcontrolitem->replicate()->fill(['aci_label' => $txt]);

        $newAci->save();
        $request->session()->flash('status', __('Der Prüfschritt <strong>:label</strong> wurde kopiert!', ['label' => request('aci_label')]));
        return redirect()->route('anforderungcontrolitem.show', ['anforderungcontrolitem' => $newAci]);
    }

    /**
     * Display the specified resource.
     *
     * @param  AnforderungControlItem $anforderungcontrolitem
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function show(AnforderungControlItem $anforderungcontrolitem)
    {
        return view('admin.verordnung.anforderungitem.show', [
            'anforderungcontrolitem' => $anforderungcontrolitem,
            'testEventFromItem' => ControlEventItem::with('ControlEvent')->where('control_item_aci',
                $anforderungcontrolitem->id)
                ->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request                $request
     * @param  AnforderungControlItem $anforderungcontrolitem
     *
     * @return RedirectResponse
     */
    public function update(Request $request, AnforderungControlItem $anforderungcontrolitem)
    {


        $this->validateAnforderungControlItem();


        $anforderungcontrolitem->aci_label = $request->aci_label;
        $anforderungcontrolitem->aci_name = $request->aci_name;
        $anforderungcontrolitem->aci_task = $request->aci_task;
        $anforderungcontrolitem->aci_value_si = $request->aci_value_si;
        $anforderungcontrolitem->aci_vaule_soll = $request->aci_vaule_soll;
        $anforderungcontrolitem->aci_value_target_mode = $request->aci_value_target_mode;
        $anforderungcontrolitem->aci_value_tol = $request->aci_value_tol;
        $anforderungcontrolitem->aci_value_tol_mod = $request->aci_value_tol_mod;
        $anforderungcontrolitem->aci_execution = $request->aci_execution;
        $anforderungcontrolitem->aci_control_equipment_required = isset($request->aci_control_equipment_required);
        $anforderungcontrolitem->firma_id = $request->firma_id;
        $anforderungcontrolitem->aci_contact_id = $request->aci_contact_id;
        $anforderungcontrolitem->anforderung_id = $request->anforderung_id;
        $anforderungcontrolitem->save();


        $request->session()->flash('status', __('Der Prüfschritt <strong>:name</strong> wurde aktualisiert!', ['name' => request('aci_name')]));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AnforderungControlItem $anforderungcontrolitem
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(AnforderungControlItem $anforderungcontrolitem)
    {
        $anforderungcontrolitem->delete();
        \request()->session()->flash('status', __('Der Prüfschritt wurde gelöscht!'));
        return back();
    }

    public function getAnforderungControlItemData(Request $request)
    {
        return AnforderungControlItem::findorFail($request->id);
    }
}
