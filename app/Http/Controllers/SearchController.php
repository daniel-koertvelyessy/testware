<?php

namespace App\Http\Controllers;

use App\Adresse;
use App\Anforderung;
use App\AnforderungControlItem;
use App\ControlEvent;
use App\Equipment;
use App\EquipmentEvent;
use App\EquipmentEventItem;
use App\Produkt;
use App\Stellplatz;
use App\Verordnung;
use Illuminate\Http\Request;
use App\Location;
use App\Building;
use App\Room;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller {


    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {

        if (isset($request->srchTopMenuTerm)) {
            $term = $request->srchTopMenuTerm;

            $cacheDuration = 9;

            $resultsEquipment = Cache::remember(
                'search-Equipment-' . $term,
                now()->addSeconds($cacheDuration),
                function () use ($term) {
                    $obj = new Equipment();
                    return $obj->search($term);
                }
            );

            $resultsProdukt = Cache::remember(
                'search-Produkt-' . $term,
                now()->addSeconds($cacheDuration),
                function () use ($term) {
                    $obj = new Produkt();
                    return $obj->search($term);
                }
            );

            $resultsEquipmentEvent = Cache::remember(
                'search-EquipmentEvent-' . $term,
                now()->addSeconds($cacheDuration),
                function () use ($term) {
                    $obj = new EquipmentEvent();
                    return $obj->search($term);
                }
            );

            $resultsEquipmentEventItem = Cache::remember(
                'search-EquipmentEventItem-' . $term,
                now()->addSeconds($cacheDuration),
                function () use ($term) {
                    $obj = new EquipmentEventItem();
                    return $obj->search($term);
                }
            );

            $resultsControlEvent = Cache::remember(
                'search-ControlEvent-' . $term,
                now()->addSeconds($cacheDuration),
                function () use ($term) {
                    $obj = new ControlEvent();
                    return $obj->search($term);
                }
            );

            $resultsVerordnung = Cache::remember(
                'search-Verordnung-' . $term,
                now()->addSeconds($cacheDuration),
                function () use ($term) {
                    $obj = new Verordnung();
                    return $obj->search($term);
                }
            );

            $resultsAnforderung = Cache::remember(
                'search-Anforderung-' . $term,
                now()->addSeconds($cacheDuration),
                function () use ($term) {
                    $obj = new Anforderung();
                    return $obj->search($term);
                }
            );

            $resultsAnforderungItem = Cache::remember(
                'search-AnforderungItem-' . $term,
                now()->addSeconds($cacheDuration),
                function () use ($term) {
                    $obj = new AnforderungControlItem();
                    return $obj->search($term);
                }
            );

            $resultsBuildung = Cache::remember(
                'search-Buildung-' . $term,
                now()->addSeconds($cacheDuration),
                function () use ($term) {
                    $obj = new Building();
                    return $obj->search($term);
                }
            );

            $resultsLocation = Cache::remember(
                'search-Location-' . $term,
                now()->addSeconds($cacheDuration),
                function () use ($term) {
                    $obj = new Location();
                    return $obj->search($term);
                }
            );

            $resultsRoom = Cache::remember(
                'search-Room-' . $term,
                now()->addSeconds($cacheDuration),
                function () use ($term) {
                    $obj = new Room();
                    return $obj->search($term);
                }
            );

            $resultsStellplatz = Cache::remember(
                'search-Stellplatz-' . $term,
                now()->addSeconds($cacheDuration),
                function () use ($term) {
                    $obj = new Stellplatz();
                    return $obj->search($term);
                }
            );

            $resultsAdresse = Cache::remember(
                'search-Adresse-' . $term,
                now()->addSeconds($cacheDuration),
                function () use ($term) {
                    $obj = new Adresse();
                    return $obj->search($term);
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

    public function searchInModules(Request $request) {
        $term = request('term');
        $data=[];

        $obj = new Equipment();
        $return = $obj->search($term);
        foreach ($return as $ret) {
            $data[] =[ 'link' => route('equipment.show', $ret),
                        'label' => '[' . __('Gerät') . '] Inv-#: ' . $ret->eq_inventar_nr . ' SN-#: ' . $ret->eq_serien_nr];
        }

        $obj = new Produkt();
        $return = $obj->search($term);
        foreach ($return as $ret) {
            $data[] =[ 'link' => route('produkt.show', $ret),
                        'label' => '[' . __('Produkt') . '] ' . $ret->prod_name_kurz . ' ' . $ret->prod_nummer];
        }

        $obj = new EquipmentEvent();
        $return = $obj->search($term);
        foreach ($return as $ret) {
            $data[] =[ 'link' => route('equipmentevent.show', $ret),
                        'label' => '[' . __('Ereignis') . '] vom ' . $ret->created_at . ' Meldung: ' . str_limit($ret->equipment_event_text, 10)];
        }

        $obj = new EquipmentEventItem();
        $return = $obj->search($term);
        foreach ($return as $ret) {
            $data[] =[ 'link' => route('equipmenteventitem.show', $ret),
                        'label' => '[' . __('Meldung') . '] '. $ret->updated_at . ' Text: ' . str_limit($ret->equipment_event_item_text,20)];
        }

        $obj = new ControlEvent();
        $return = $obj->search($term);
        foreach ($return as $ret) {
            $data[] =[ 'link' => route('controlevent.show', $ret),
                        'label' => '[' . __('Prüfung') . '] '. $ret->control_event_date . ' Text: ' . str_limit($ret->control_event_text,20)];
        }

        $obj = new Verordnung();
        $return = $obj->search($term);
        foreach ($return as $ret) {
            $data[] =[ 'link' => route('verordnung.show', $ret),
                        'label' =>  '[' . __('Verordnung') . '] ' . str_limit($ret->vo_name_lang,30)];
        }

        $obj = new Anforderung();
        $return = $obj->search($term);
        foreach ($return as $ret) {
            $data[] =[ 'link' => route('anforderung.show', $ret),
                        'label' => '[' . __('Anforderung') . '] ' . str_limit($ret->an_name_lang,30)];
        }

        $obj = new AnforderungControlItem();
        $return = $obj->search($term);
        foreach ($return as $ret) {
            $data[] =[ 'link' => route('anforderungcontrolitem.show', $ret),
                        'label' =>'[' . __('Vorgang') . '] ' . str_limit($ret->aci_name_lang,30)];
        }

        $obj = new Location();
        $return = $obj->search($term);
        foreach ($return as $ret) {
            $data[] =[ 'link' => route('location.show', $ret),
                        'label' => '[' . __('Standort') . '] ' . $ret->l_name_kurz];
        }

        $obj = new Building();
        $return = $obj->search($term);
        foreach ($return as $ret) {
            $data[] =[ 'link' => route('building.show', $ret),
                        'label' => '[' . __('Gebäude') . '] ' .$ret->b_name_kurz ];
        }


        $obj = new Room();
        $return = $obj->search($term);
        foreach ($return as $ret) {
            $data[] =[ 'link' => route('room.show', $ret),
                        'label' => '[' . __('Raum') . '] ' . $ret->r_name_kurz ];
        }

        $obj = new Stellplatz();
        $return = $obj->search($term);
        foreach ($return as $ret) {
            $data[] =[ 'link' => route('room.show', $ret),
                        'label' => '[' . __('Stellplatz') . '] ' . $ret->sp_name_kurz ];
        }

        $obj = new Adresse();
        $return = $obj->search($term);
        foreach ($return as $ret) {
            $data[] =[ 'link' => route('adresse.show', $ret),
                        'label' => '[' . __('Adresse') . '] ' . $ret->ad_name_kurz . ' ' . $ret->ad_anschrift_strasse . ' / ' . $ret->ad_anschrift_hausnummer];
        }

        return $data;

    }

    public function search() {
        return view('location.index');
    }


    public function acAdminLocations(Request $request) {
        $search = $request->get('term');

        $dataLoc = Location::select('id', 'l_name_kurz', 'l_name_lang')
            ->where('l_name_kurz', 'LIKE', "%$search%")
            ->orWhere('l_name_lang', 'LIKE', "%$search%")
            ->orWhere('l_beschreibung', 'LIKE', "%$search%")
            ->get();

        //        dd($data);
        $l = [];
        foreach ($dataLoc as $item) {
            $l[] = array('value' => $item->id, 'group' => 'location', 'name' => $item->l_name_kurz, 'label' => $item->l_name_kurz . ' - ' . substr($item->l_name_lang, 0, 5));
        }

        $dataBuilding = Building::select('id', 'b_name_kurz', 'b_raum_ort')
            ->where('b_name_kurz', 'LIKE', "%$search%")
            ->orWhere('b_raum_ort', 'LIKE', "%$search%")
            ->orWhere('b_raum_lang', 'LIKE', "%$search%")
            ->orWhere('b_beschreibung', 'LIKE', "%$search%")
            ->orWhere('b_we_name', 'LIKE', "%$search%")
            ->get();

        foreach ($dataBuilding as $item) {
            $l[] = array('value' => $item->id, 'group' => 'building', 'name' => $item->b_name_kurz, 'label' => $item->b_name_kurz . ' - Ort ' . $item->b_raum_ort);
        }

        $dataRoom = Room::select('id', 'r_name_kurz', 'r_name_lang')
            ->where('r_name_kurz', 'LIKE', "%$search%")
            ->orWhere('r_name_lang', 'LIKE', "%$search%")
            ->orWhere('r_name_text', 'LIKE', "%$search%")
            ->get();

        foreach ($dataRoom as $item) {
            $l[] = array('value' => $item->id, 'name' => $item->r_name_kurz, 'label' => $item->r_name_kurz . ' - ' . substr($item->r_name_lang, 0, 5));
        }


        return response()->json($l);
    }
}
