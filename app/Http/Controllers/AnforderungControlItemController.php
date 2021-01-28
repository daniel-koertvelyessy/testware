<?php

namespace App\Http\Controllers;

use App\AnforderungControlItem;
use Exception;
use http\Client\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class AnforderungControlItemController extends Controller
{

    use SoftDeletes;

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
        if (AnforderungControlItem::all()->count() > 10) {
            return view('admin.verordnung.anforderungitem.index', [
                'aciitems' => AnforderungControlItem::sortable()->paginate(10)
            ]);
        } else {
            return view('admin.verordnung.anforderungitem.index', [
                'aciitems' => AnforderungControlItem::sortable()->get()
            ]);
        }
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
        return view('admin.verordnung.anforderungitem.create',['rid'=> $request->input('rid')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->firma_id = ($request->aci_exinternal === 'internal') ? 1 : $request->firma_id;

        AnforderungControlItem::create($this->validateNewAnforderungControlItem());

        $request->session()->flash('status', 'Der Vorgang <strong>' . request('aci_label') . '</strong> wurde angelegt!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  AnforderungControlItem $anforderungcontrolitem
     * @return Application|Factory|Response|View
     */
    public function show(AnforderungControlItem $anforderungcontrolitem)
    {
        return view('admin.verordnung.anforderungitem.show', ['anforderungcontrolitem' => $anforderungcontrolitem]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Request                $request
     * @param  AnforderungControlItem $anforderungcontrolitem
     * @return RedirectResponse
     */
    public function update(Request $request, AnforderungControlItem $anforderungcontrolitem)
    {

        //        dd(request()->has('aci_control_equipment_required') );
        //        $data = AnforderungControlItem::find($request->id);
        $anforderungcontrolitem->aci_control_equipment_required = request()->has('aci_control_equipment_required') ? 1 : 0;
        //        $data->update($this->validateAnforderungControlItem());

        //        dd($request->aci_control_equipment_required );
        $anforderungcontrolitem->update($this->validateAnforderungControlItem());
        $request->session()->flash('status', 'Der Vorgang <strong>' . request('aci_name') . '</strong> wurde aktualisiert!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AnforderungControlItem $anforderungcontrolitem
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(AnforderungControlItem $anforderungcontrolitem)
    {
        $anforderungcontrolitem->delete();
        \request()->session()->flash('status', 'Der Vorgang wurde gelöscht!');
        return back();
    }



    public function getAnforderungControlItemData(Request $request)
    {
        return AnforderungControlItem::findorFail($request->id);
    }

    /**
     * @return array
     */
    public function validateNewAnforderungControlItem(): array
    {
        return request()->validate([
            'aci_label' => 'bail|alpha_dash|unique:anforderung_control_items,aci_label|required|max:20',
            'aci_name' => 'required',
            'aci_task' => '',
            'aci_value_si' => 'max:10',
            'aci_vaule_soll' => '',
            'aci_value_target_mode' => '',
            'aci_value_tol' => '',
            'aci_value_tol_mod' => '',
            'aci_execution' => '',
            'aci_control_equipment_required' => '',
            'firma_id' => '',
            'aci_contact_id' => 'required',
            'anforderung_id' => 'required',
        ]);
    }

    /**
     * @return array
     */
    public function validateAnforderungControlItem(): array
    {
        return request()->validate([
            'aci_label' => 'bail|alpha_dash|required|max:20',
            'aci_name' => 'max:150',
            'aci_task' => '',
            'aci_value_si' => 'max:10',
            'aci_vaule_soll' => '',
            'aci_value_target_mode' => '',
            'aci_value_tol' => '',
            'aci_value_tol_mod' => '',
            'aci_control_equipment_required' => '',
            'id' => '',
            'aci_execution' => '',
            'firma_id' => '',
            'aci_contact_id' => 'required',
            'anforderung_id' => 'required',
        ]);
    }
}
