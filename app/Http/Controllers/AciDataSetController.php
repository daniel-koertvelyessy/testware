<?php

namespace App\Http\Controllers;

use App\AciDataSet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AciDataSetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $aciDataSet = AciDataSet::create($this->validateAciDataSet());

        $request->session()->flash('status', __('Datensatz angelegt'));

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param \App\AciDataSet $aciDataSet
     * @return \Illuminate\Http\Response
     */
    public function show(AciDataSet $acidataset)
    {
        return $acidataset;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\AciDataSet $aciDataSet
     * @return \Illuminate\Http\Response
     */
    public function edit(AciDataSet $aciDataSet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\AciDataSet $acidataset
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AciDataSet $acidataset)
    {
      //  dd($request);
       $msg = $acidataset->update($this->validateAciDataSet())
           ? __('Datensatz wurde aktualisiert')
           : __('Fehler beim Aktualisieren');
        session()->flash('status', $msg);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\AciDataSet $acidataset
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AciDataSet $acidataset)
    {
        $msg = $acidataset->delete()
            ? __('Datensatz wurde gelöscht')
            : __('Fehler beim Löschen');
        session()->flash('status', $msg);

        return back();

    }


    public function validateAciDataSet(): array
    {
        return request()->validate([
                                       'data_point_value'            => 'required',
                                       'data_point_tol_target_mode'  => '',
                                       'data_point_tol'              => 'numeric',
                                       'data_point_tol_mod'          => '',
                                       'data_point_sort'             => 'integer',
                                       'anforderung_control_item_id' => 'required',
                                   ]);
    }

}
