<?php

namespace App\Http\Controllers;

use App\ProduktParam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ProductParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    : RedirectResponse
    {
        ProduktParam::create($this->validateProduktParam());
        $request->session()->flash('status', 'Das Datenfeld  <strong>' . request('pp_name') . '</strong> wurde angelegt!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int     $id
     *
     * @return Response
     */
    public function update(Request $request, ProduktParam $produktparam)
    {
        $produktparam->update($this->validateProduktParam());

        $request->session()->flash('status', __('Das Datenfeld <strong>:name</strong> wurde aktualisiert!',['name'=>request('pp_name')]));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Fetch the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getParamData(Request $request)
    {
        return ProduktParam::find($request->id);
    }

    /**
     * @return array
     */
    public function validateProduktParam()
    : array
    {
        return request()->validate([
            'pp_label'   => [
                'bail',
                'required',
                'max:20',
                Rule::unique('produkt_params')->ignore(\request('id')),
            ],
            'pp_value'   => 'bail|max:150',
            'pp_name'    => 'bail|string|max:150',
            'produkt_id' => 'required'
        ]);
    }
}
