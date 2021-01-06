<?php

namespace App\Http\Controllers;

use App\Building;
use App\Http\Resources\BuildingFull as BuildingFullResource;
use App\Http\Resources\CompartmentFull;
use App\Http\Resources\LocationFull;
use App\Http\Resources\LocationFull as LocationFullResource;
use App\Http\Resources\RoomFull;
use App\Location;
use App\Room;
use App\Stellplatz;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ExportController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function locationsToJson() {
        return response(LocationFullResource::collection(
            Location::with('Adresse','Profile' )->get()
        ), 200)
            ->header('Cache-Control', 'public')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', ' application/json')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Content-disposition', "attachment; filename=" . "testware_". __('Standorte').'_' . time() . ".json");
    }

    public function buildingsToJson() {
        return response(BuildingFullResource::collection(
            Building::all()
        ), 200)
            ->header('Cache-Control', 'public')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', ' application/json')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Content-disposition', "attachment; filename=" . "testware_". __('Gebäude').'_' . time() . ".json");
    }

    public function roomsToJson() {
        return response(RoomFull::collection(
            Room::all()
        ), 200)
            ->header('Cache-Control', 'public')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', ' application/json')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Content-disposition', "attachment; filename=" . "testware_". __('Räume').'_' . time() . ".json");
    }


    public function compartmentsToJson() {
        return response(CompartmentFull::collection(
            Stellplatz::all()
        ), 200)
            ->header('Cache-Control', 'public')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', ' application/json')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Content-disposition', "attachment; filename=" . "testware_". __('Stellplättze').'_' . time() . ".json");
    }

}
