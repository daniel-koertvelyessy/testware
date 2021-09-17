<?php

namespace App\Http\Controllers\Api\V1;

use App\Adresse;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\address\Address as AddressResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        if ($request->input('per_page')) {
            return AddressResource::collection(Adresse::all()->paginate($request->input('per_page')));
        }
        return AddressResource::collection(Adresse::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     *
     * @return AddressResource|JsonResponse
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
                if (is_null($data['label']) || is_null($data['city']) || is_null($data['zip'])) {
                    $countSkipped++;
                    $skippedObjectIdList[] = [
                        'empty required values' => [
                            'label'  => $data['label'] ?? '<- required',
                            'zip' => $data['zip'] ?? '<- required',
                            'city'   => $data['city'] ?? '<- required',
                        ]
                    ];
                    continue;
                }
                if ($this->checkAddressExists($data['label'])) {
                    $countSkipped++;
                    $skippedObjectIdList[] = new AddressResource(Adresse::where('ad_label', $data['label'])->first());
                    continue;
                }
                $id = (new Adresse)->addFromAPI($data);
                if ($id > 0) {
                    $idList[] =  $id;
//                    $idList[] = new AddressResource(Adresse::find($id));
                    $countNew++;
                } else {
                    $countSkipped++;
//                    Log::warning('API could not create new address! => '. $data['label']);
                }
            }

            return response()->json([
                'updated_objects' => $countUpdate,
                'skipped_objects' => [
                    'total'   => $countSkipped,
                    'id_list' => $skippedObjectIdList
                ],
                'new_objects'     => [
                    'total'     => $countNew,
                    'adress_id' => $idList
                ],
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return AddressResource|JsonResponse
     */
    public function store(Request $request)
    {
        if ($this->checkAddressExists($request->label)) return response()->json([
            'Error'   => 'Am address with the provided name already exists',
            'company' => new AddressResource(Adresse::where('ad_label', $request->label)->first())
        ], 422);

        $address_id = (new Adresse)->addAddress($request);
        return ($address_id > 0) ? new AddressResource($address_id) : response()->json([
            'Error' => 'An error occurred during the storing of the company.'
        ], 422);
    }

    protected function checkAddressExists($label)
    {
        return Adresse::where('ad_label', $label)->count() > 0;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return AddressResource|JsonResponse
     */
    public function show($id)
    {
        $address = Adresse::find($id);
        return ($address) ? new AddressResource($address) : response()->json([
            'Error' => 'The requested address was not found on this server.'
        ], 404);
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
     * @param  int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $msg = Adresse::destroy([$id]) ? [
            'Deleted' => 'The address was deleted'
        ] : [
            'Error' => 'An error occurred during the deletion of the address.'
        ];
        return response()->json($msg);
    }
}
