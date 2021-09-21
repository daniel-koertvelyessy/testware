<?php

namespace App\Http\Controllers\Api\V1;

use App\Contact;
use App\Firma;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\contacts\Contact as ContactResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        if ($request->input('per_page')) {
            return ContactResource::collection(Contact::all()->paginate($request->input('per_page')));
        }
        return ContactResource::collection(Contact::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     *
     * @return ContactResource|JsonResponse
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
            $countSkipped = 0;
            foreach ($jsondata as $data) {
                if ($this->checkContactExists($data['name'], $data['last_name'], $data['company'])) {
                    $skippedObjectIdList[] = $data['name'] . ' - ' . $data['last_name'] . ' - ' . $data['company'];
                    $countSkipped++;
                    continue;
                }
                $id = (new Contact)->addFromAPI($data);
                if ($id > 0) {
                    $idList[] = new ContactResource(Contact::find($id));
                    $countNew++;
                } else {
                    $countSkipped++;
//                    Log::warning('API could not create new contact! => ' . $data['label']);
                }
            }

            return response()->json([
                'skipped_objects' => [
                    'total'   => $countSkipped,
                    'id_list' => $skippedObjectIdList
                ],
                'new_objects'     => [
                    'total'     => $countNew,
                    'id' => $idList
                ],
            ],200);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return ContactResource|JsonResponse
     */
    public function store(Request $request)
    {
        if ($this->checkContactExists($request->name, $request->vorname, $request->company)) return response()->json([
            'Error'   => 'Am contact with the provided name already exists',
            'contact' => 'oijoi'
        ], 422);

        $address_id = (new Contact)->addFromAPI($request->toArray());
        return ($address_id > 0) ? new ContactResource(Contact::find($address_id)) : response()->json([
            'Error' => 'An error occurred during the storing of the contact.'
        ], 422);
    }

    protected function checkContactExists($name, $firstname, $company)
    : bool
    {
        $firma = Firma::where('fa_name',trim($company))->first();

        if ($firma) {
            return Contact::where([
                    [
                        'con_name',
                        $name
                    ],
                    [
                        'con_vorname',
                        $firstname
                    ],
                    [
                        'firma_id',
                        $firma->id
                    ],
                ])->count() > 0;
        } else {
            return Contact::where([
                    [
                        'con_name',
                        $name
                    ],
                    [
                        'con_vorname',
                        $firstname
                    ]
                ])->count() > 0;
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return ContactResource|Jsonresponse
     */
    public function show(int $id)
    {
        $contact = Contact::find($id);
        if ($contact) {
            return new ContactResource($contact->id);
        } else {
            return response()->json([
                'Error' => 'The requested contact cannot be found on this server.'
            ], 404);
        }
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
    public function destroy($id)
    {
        $msg = Contact::destroy([$id]) ? [
            'Success' => 'The contact was deleted'
        ] : [
            'Error' => 'An error occurred during the deletion of the contact.'
        ];
        return response()->json($msg);
    }
}
