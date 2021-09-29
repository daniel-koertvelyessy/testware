<?php

namespace App\Http\Controllers\Api\V1;

use App\Adresse;
use App\Firma;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\companies\Company as CompanyResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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
            return CompanyResource::collection(Firma::with('Adresse')->paginate($request->input('per_page')));
        }
        return CompanyResource::collection(Firma::with('Adresse')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     *
     * @return CompanyResource|JsonResponse
     */
    public function storeMany(Request $request)
    {
        $jsondata = (object)$request->json()->all();
        if (isset($jsondata->label)) {
            return $this->store($request);
        } else {
            $idList = [];
            $skippedObjectIdList = [];
            $countNew = 0;
            $countUpdate = 0;
            $countSkipped = 0;
            foreach ($jsondata as $data) {
                if ($this->checkCompanyExists($data['name'])) {
                    $countSkipped++;
                    $skippedObjectIdList[] = new CompanyResource(Firma::where('fa_name', $data['name'])->first());
                    continue;
                }

                $id = (new Firma)->addFromAPI($data);
                if($id>0){
                    $idList[] =  $id;
                    $countNew++;
                } else {
                    $countSkipped++;
//                    Log::warning('API could not create new product! => '. $data['name']);
                }
            }

            return response()->json([
                'updated_objects' => $countUpdate,
                'skipped_objects' => [
                    'total'   => $countSkipped,
                    'id_list' => $skippedObjectIdList
                ],
                'new_objects'     => [
                    'total'      => $countNew,
                    'product_id' => $idList
                ],
            ]);
        }

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

        if ($this->checkCompanyExists($request->name)) return response()->json([
            'Error'   => 'A company with the provided name already exists',
            'company' => new CompanyResource(Firma::where('fa_name', $request->name)->first())
        ], 422);

        $company = new Firma();
        $company->fa_label = $request->label;
        $company->fa_name = $request->name;
        $company->fa_description = $request->description;
        $company->fa_kreditor_nr = $request->vendor_id;
        $company->fa_debitor_nr = $request->custmer_id;
        $company->fa_vat = $request->vat;

        if (isset($request->address) && isset($request->address['label'])){
            $company->adresse_id =(new Adresse)->addFromAPI($request->address, false);
        } else {
            $company->adresse_id = $request->adresse_id ?? 1;
        }

        return ($company->save()) ? new CompanyResource($company) : response()->json([
            'Error' => 'An error occurred during the storing of the company.'
        ], 422);
    }

    protected function checkCompanyExists($name)
    {
        return Firma::where('fa_name', $name)->count() > 0;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return CompanyResource|JsonResponse
     */
    public function show(int $id)
    {
        $company = Firma::find($id);
        return ($company) ? new CompanyResource($company) : response()->json([
            'Error' => 'The requested company was not found on this server.'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id)
    : JsonResponse
    {
        $msg = Firma::destroy([$id]) ? [
            'Deleted' => 'The address was deleted'
        ] : [
            'Error' => 'An error occurred during the deletion of the address.'
        ];
        return response()->json($msg);
    }
}
