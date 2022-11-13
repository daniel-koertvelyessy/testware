<?php

    namespace App\Http\Controllers;

    use App\Adresse;
    use App\Anforderung;
    use App\AnforderungControlItem;
    use App\Http\Services\Equipment\EquipmentEventItemService;
    use App\Http\Services\Location\AddressService;
    use App\Http\Services\Location\CompartmentService;
    use App\ControlEvent;
    use App\Equipment;
    use App\EquipmentEvent;
    use App\EquipmentEventItem;
    use App\Http\Services\Control\ControlEventService;
    use App\Http\Services\Equipment\EquipmentEventService;
    use App\Http\Services\Equipment\EquipmentService;
    use App\Http\Services\Location\BuildingService;
    use App\Http\Services\Location\LocationService;
    use App\Http\Services\Location\RoomService;
    use App\Http\Services\Product\ProductService;
    use App\Http\Services\Regulation\RequirementService;
    use App\Http\Services\Regulation\RegulationService;
    use App\Http\Services\Regulation\RequirementControlItemService;
    use App\Produkt;
    use App\Stellplatz;
    use App\Verordnung;
    use Illuminate\Http\Request;
    use App\Location;
    use App\Building;
    use App\Room;
    use Illuminate\Support\Facades\Cache;

    class SearchController extends Controller
    {

        public function __construct()
        {
            $this->middleware('auth');
        }

        public function index(Request $request)
        {

            if (isset($request->srchTopMenuTerm)) {
                $term = $request->srchTopMenuTerm;

                $cacheDuration = now()->addSeconds(9);

                $resultsEquipment = Cache::remember('search-Equipment-' . $term, $cacheDuration, function () use ($term)
                {
                    return EquipmentService::search($term);
                }
                );

                $resultsProdukt = Cache::remember('search-Produkt-' . $term, $cacheDuration, function () use ($term)
                {
                    return ProductService::search($term);
                }
                );

                $resultsEquipmentEvent = Cache::remember('search-EquipmentEvent-' . $term, $cacheDuration, function () use ($term)
                {
                    return EquipmentEventService::search($term);
                }
                );

                $resultsEquipmentEventItem = Cache::remember('search-EquipmentEventItem-' . $term, $cacheDuration, function () use ($term)
                {
                    return EquipmentEventService::search($term);
                }
                );

                $resultsControlEvent = Cache::remember('search-ControlEvent-' . $term, $cacheDuration, function () use ($term)
                {
                    return ControlEventService::search($term);
                }
                );

                $resultsVerordnung = Cache::remember('search-Verordnung-' . $term, $cacheDuration, function () use ($term)
                {
                    return RegulationService::search($term);
                }
                );

                $resultsAnforderung = Cache::remember('search-Anforderung-' . $term, $cacheDuration, function () use ($term)
                {
                    return RequirementService::search($term);
                }
                );

                $resultsAnforderungItem = Cache::remember('search-AnforderungItem-' . $term, $cacheDuration, function () use ($term)
                {
                    return RequirementService::search($term);
                }
                );

                $resultsBuildung = Cache::remember('search-Buildung-' . $term, $cacheDuration, function () use ($term)
                {
                    return BuildingService::search($term);
                }
                );

                $resultsLocation = Cache::remember('search-Location-' . $term, $cacheDuration, function () use ($term)
                {
                    return LocationService::search($term);
                }
                );

                $resultsRoom = Cache::remember('search-Room-' . $term, $cacheDuration, function () use ($term)
                {
                    return RoomService::search($term);
                }
                );

                $resultsStellplatz = Cache::remember('search-Stellplatz-' . $term, $cacheDuration, function () use ($term)
                {
                    return CompartmentService::search($term);
                }
                );

                $resultsAdresse = Cache::remember('search-Adresse-' . $term, $cacheDuration, function () use ($term)
                {
                    return AddressService::search($term);
                }
                );

                $numResults = $resultsProdukt->count()
                    + $resultsVerordnung->count()
                    + $resultsEquipment->count()
                    + $resultsEquipmentEvent->count()
                    + $resultsControlEvent->count()
                    + $resultsAnforderung->count()
                    + $resultsAnforderungItem->count()
                    + $resultsBuildung->count()
                    + $resultsLocation->count()
                    + $resultsRoom->count()
                    + $resultsStellplatz->count()
                    + $resultsAdresse->count()
                    + $resultsEquipmentEventItem->count();

                $resArray = [
                    'term'                      => $term,
                    'numResults'                => $numResults,
                    'resultsEquipment'          => $resultsEquipment,
                    'resultsProdukt'            => $resultsProdukt,
                    'resultsEquipmentEvent'     => $resultsEquipmentEvent,
                    'resultsEquipmentEventItem' => $resultsEquipmentEventItem,
                    'resultsControlEvent'       => $resultsControlEvent,
                    'resultsVerordnung'         => $resultsVerordnung,
                    'resultsAnforderung'        => $resultsAnforderung,
                    'resultsAnforderungItem'    => $resultsAnforderungItem,
                    'resultsBuildung'           => $resultsBuildung,
                    'resultsLocation'           => $resultsLocation,
                    'resultsRoom'               => $resultsRoom,
                    'resultsStellplatz'         => $resultsStellplatz,
                    'resultsAdresse'            => $resultsAdresse,
                ];
            } else {
                $resArray = ['term' => false];
            }

            return view('search', $resArray);
        }

        public function searchInModules(): array
        {
            $term = request('term');

            $data[] = EquipmentService::getSearchResults($term);

             $data[] = (ProductService::getSearchResults($term));
             $data[] = (EquipmentEventService::getSearchResults($term));
             $data[] = (EquipmentEventItemService::getSearchResults($term));
             $data[] = (RegulationService::getSearchResults($term));
             $data[] = (RequirementService::getSearchResults($term));
             $data[] = (RequirementControlItemService::getSearchResults($term));
             $data[] = (BuildingService::getSearchResults($term));
             $data[] = (RoomService::getSearchResults($term));
             $data[] = (CompartmentService::getSearchResults($term));
             $data[] = (AddressService::getSearchResults($term));

            return empty($data)
                ? [
                    'link'  => '#',
                    'label' => 'Keine Ergebnisse gefunden'
                ]
                : array_flatten($data,1);
        }

        public function search()
        {
            return view('location.index');
        }

        public function acAdminLocations(Request $request)
        {
            $search = $request->get('term');

            $dataLoc = Location::select('id', 'l_label', 'l_name')
                ->where('l_label', 'LIKE', "%$search%")
                ->orWhere('l_name', 'LIKE', "%$search%")
                ->orWhere('l_beschreibung', 'LIKE', "%$search%")
                ->get();

            //        dd($data);
            $l = [];
            foreach ($dataLoc as $item) {
                $l[] = array(
                    'value' => $item->id,
                    'group' => 'location',
                    'name'  => $item->l_label,
                    'label' => $item->l_label . ' - ' . substr($item->l_name, 0, 5)
                );
            }

            $dataBuilding = Building::select([
                'id',
                'b_label',
                'b_raum_ort'
            ])
                ->where('b_label', 'LIKE', "%$search%")
                ->orWhere('b_raum_ort', 'LIKE', "%$search%")
                ->orWhere('b_raum_lang', 'LIKE', "%$search%")
                ->orWhere('b_beschreibung', 'LIKE', "%$search%")
                ->orWhere('b_we_name', 'LIKE', "%$search%")
                ->get();

            foreach ($dataBuilding as $item) {
                $l[] = array(
                    'value' => $item->id,
                    'group' => 'building',
                    'name'  => $item->b_label,
                    'label' => $item->b_label . ' - Ort ' . $item->b_raum_ort
                );
            }

            $dataRoom = Room::select([
                'id',
                'r_label',
                'r_name'
            ])
                ->where('r_label', 'LIKE', "%$search%")
                ->orWhere('r_name', 'LIKE', "%$search%")
                ->orWhere('r_description', 'LIKE', "%$search%")
                ->get();

            foreach ($dataRoom as $item) {
                $l[] = array(
                    'value' => $item->id,
                    'name'  => $item->r_label,
                    'label' => $item->r_label . ' - ' . substr($item->r_name, 0, 5)
                );
            }


            return response()->json($l);
        }

        public function searchInDocumentation(Request $request): Request
        {
            return $request;
        }
    }
