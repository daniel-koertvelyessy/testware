<?php

namespace App\Http\Controllers\Api\V1;

use App\AddressType;
use App\Adresse;
use App\Http\Controllers\Controller;
use App\Location;
use App\Profile;
use App\Storage;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use App\Http\Resources\AddressFull;
use App\Http\Resources\locations\Location as LocationResource;
use App\Http\Resources\locations\LocationFull as LocationFullResource;
use App\Http\Resources\locations\LocationShow as LocationShowResource;
use Illuminate\Support\Str;

class LocationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        if ($request->input('per_page')) {
            return LocationResource::collection(Location::with('Profile', 'Adresse', 'Building')->paginate($request->input('per_page')));
        }
        return LocationResource::collection(Location::with('Profile', 'Adresse', 'Building')->get());
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function full(Request $request)
    {
        if ($request->input('per_page')) {
            return LocationFullResource::collection(Location::with('Profile', 'Adresse', 'Building')->paginate($request->input('per_page')));
        }
        return LocationFullResource::collection(Location::with('Adresse', 'Profile')->get());
    }

    public function storemany(Request $request)
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
                /**
                 *    label is a required field. Skipp this dataset
                 */
                if (!isset($data['label'])) {
                    $skippedObjectIdList[] = ['error' => 'no required items found in given dataset (missing item [label])'];
                    $countSkipped++;
                    continue;
                }

                /**
                 *  Check given address data and
                 *  assign to $location->adresse_id
                 */
                if (isset($data['address']['label'])) {
                    if (Adresse::where('ad_label', $data['address']['label'])->count() === 0) {
                        $address_id = (new Adresse)->addAddressArray($data['address']);

                    } else {
                        $adresse = Adresse::where('ad_label', $data['address']['label'])->first();
                        $address_id = $adresse->id;
                    }
                    $address_id_list[] = ['address_id' => $address_id];
                } elseif (isset($data['address_id'])) {
                    if (Adresse::find($data['address_id'])) {
                        $address_id = $data['address_id'];
                        $address_id_list[] = ['address_id' => $address_id];
                    } else {
                        $skippedObjectIdList[] = ['error' => 'skipp ' . $data['name'] . ' dataset (invalid item [address_id])'];
                        $countSkipped++;
                        continue;
                    }
                } else {
                    $skippedObjectIdList[] = ['error' => 'skipp ' . $data['name'] . ' dataset (missing item [address])'];
                    $countSkipped++;
                    continue;
                }

                /**
                 *   check given manager data and
                 *   assign to $location->profile_id
                 *             "first_name": "Swetlana",
                 */
                if (isset($data['manager']['name'])) {
                    if (Profile::where('ma_name', $data['manager']['name'])->count() > 0) {
                        $profile = Profile::where('ma_name', $data['manager']['name'])->first();
                        $profile_id = $profile->id;
                    } else {
                        $profile_id = (new Profile)->addProfileData($data['manager']);
                    }
                } elseif (isset($data['profile_id'])) {
                    if (Profile::find($data['profile_id'])) {
                        $profile = Profile::find($data['profile_id']);
                        $profile_id = $profile->id;
                    } else {
                        $skippedObjectIdList[] = ['error' => 'skipp ' . $data['name'] . ' dataset (invalid item [profile_id])'];
                        $countSkipped++;
                        continue;
                    }
                } else {
                    $skippedObjectIdList[] = ['error' => 'skipp ' . $data['name'] . ' dataset (missing item [manager/profile_id])'];
                    $countSkipped++;
                    continue;
                }

                /**
                 *  Check if given location exists in database and decide to
                 *  update or create new one
                 */
                if (Location::where('l_label', $data['label'])->count() > 0) {
                    $location = Location::where('l_label', $data['label'])->first();
                    $updateDataset = true;
                    $countUpdate++;
                } elseif (isset($data['id']) && Location::find($data['id'])) {
                    $location = Location::find($data['id']);
                    $updateDataset = true;
                    $countUpdate++;
                } else {
                    $location = new Location();
                    $updateDataset = false;
                }

                if ($updateDataset) {
                    $location->l_label = (isset($data['label'])) ? $data['label'] : $location->l_label;
                    $location->l_name = (isset($data['name'])) ? $data['name'] : $location->l_name;
                    $location->l_beschreibung = (isset($data['description'])) ? $data['description'] : $location->l_beschreibung;
                    $location->storage_id = ((new Storage)->checkUidExists($data['uid']) && $data['uid'] !== $location->storage_id) ? $data['uid'] : $location->storage_id;
                } else {
                    $location->l_label = $data['label'];
                    $location->l_name = $data['name'];
                    $location->l_beschreibung = $data['description'];
                    $location->storage_id = Str::uuid();
                }

                $location->adresse_id = $address_id;
                $location->profile_id = $profile_id;

                $location->save();

                $idList[] = [
                    'location' => $location->id
                ];

            }
            return response()->json([
                'updated_objects' => $countUpdate,
                'skipped_objects' => [
                    'total'   => $countSkipped,
                    'id_list' => $skippedObjectIdList
                ],
                'new_objects'     => [
                    'total'       => $countNew,
                    'location_id' => $idList
                ],
            ]);
        }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return array
     */
    public function store(Request $request)
    {
        $this->validateNewLocation();
        $adresse_id = (new \App\Adresse)->addLocationAddress($request);
        $profile_id = (new \App\Profile)->addProfile($request);

        $storage_id = (!isset($request->uid)) ? Str::uuid() : $request->uid;
        (new \App\Storage)->add($storage_id, $request->label, 'locations');

        $location = new Location();
        $location->l_label = $request->label;
        $location->l_name = $request->name;
        $location->l_beschreibung = $request->description;
        $location->adresse_id = $adresse_id;
        $location->profile_id = $profile_id;
        $location->storage_id = $storage_id;
        $location->save();

        $adresse_id = ($adresse_id === null) ? 'referenced id not found' : $adresse_id;
        $profile_id = ($profile_id === null) ? 'referenced id not found' : $profile_id;

        return [
            'status'   => true,
            'id'       => $location->id,
            'uid'      => $storage_id,
            'address'  => $adresse_id,
            'employee' => $profile_id,
        ];
    }

    /**
     * @return array
     */
    public function validateNewLocation()
    : array
    {
        return request()->validate([
            'label'       => 'bail|unique:locations,l_label|min:2|max:20|required',
            'name'        => '',
            'description' => '',
            'uid'         => 'unique:locations,storage_id',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Location $location
     *
     * @return LocationShowResource
     */
    public function show(Location $location)
    {
        return new LocationShowResource($location);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Location $location
     * @param  Request  $request
     *
     * @return LocationResource
     */
    public function update(Location $location, Request $request)
    {
        $location->l_name = (isset($request->name)) ? $request->name : $location->l_name;
        $location->l_label = (isset($request->label)) ? $request->label : $location->l_label;
        $location->l_beschreibung = (isset($request->description)) ? $request->description : $location->l_beschreibung;
        $location->save();

        return new LocationResource($location);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Location $location
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Location $location)
    {
        $location->delete();
        return response()->json([
            'status' => 'location deleted'
        ]);
    }
}
