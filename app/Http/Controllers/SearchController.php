<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Building;
use App\Room;

class SearchController extends Controller
{

    public function search()
    {
        return view('location.index');
    }


    public function acAdminLocations(Request $request)
    {
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
            $l[] = array('value' => $item->id, 'group' => 'building', 'name' => $item->b_name_kurz, 'label' =>  $item->b_name_kurz . ' - Ort ' .  $item->b_raum_ort);
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
