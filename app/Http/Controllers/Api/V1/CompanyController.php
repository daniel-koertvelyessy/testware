<?php

namespace App\Http\Controllers\Api\V1;

use App\Firma;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\companies\Company as CompanyResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        if ($request->input('per_page')) {
            return CompanyResource::collection(Firma::with('address')->paginate($request->input('per_page')));
        }
        return CompanyResource::collection(Firma::with('address')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return CompanyResource|JsonResponse
     */
    public function store(Request $request)
    {

        if ($this->checkCompanyExists($request->name))
            return response()->json([
                'Error'=> 'A company with the provided name already exists',
                'company' => new CompanyResource(Firma::where('fa_name',$request->name)->first())
            ], 422);

        $company = new Firma();
        $company->fa_label = $request->label;
        $company->fa_name = $request->name;
        $company->fa_description = $request->description;
        $company->fa_kreditor_nr = $request->vendor_id;
        $company->fa_debitor_nr = $request->custmer_id;
        $company->fa_vat = $request->vat;
        $company->adresse_id = $request->address_id;
        return ($company->save()) ? new CompanyResource($company) : response()->json([
            'Error'=> 'An error occurred during the storing of the company.'
        ], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int     $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function checkCompanyExists($name){
        return Firma::where('fa_name',$name)->count()>0 ;
    }
}
