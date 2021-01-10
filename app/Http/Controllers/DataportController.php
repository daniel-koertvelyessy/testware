<?php

namespace App\Http\Controllers;

use App\Building;
use App\Location;
use App\Produkt;
use App\Room;
use App\Stellplatz;
use Illuminate\Http\Request;

class DataportController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function exportLocationJSON()
    {
        return response(Location::all(), 200)
            ->header('Cache-Control', 'public')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', ' application/json')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Content-disposition', "attachment; filename=" . "testware_storagee_" . time() . ".json");
    }

    public function importLocationJSON(Request $request)
    {
        $res = '';
        if ($request->hasFile('importDataPortFile')) {

            $file = $request->file('importDataPortFile');

            $request->validate([
                'importDataPortFile' => 'required|file|mimes:json,xml|max:2048' // size:2048 => 2048kB
            ]);

            $json = file_get_contents($file->getPath() . '\\' . $file->getFilename(), true);
            $jsonObjekt = json_decode($json);
            $duplikat = 0;
            $fehler = 0;
            $fehlerItem = [];
            $neuObjekt = 0;
            $flagNoObjekt = false;
            $mkObjekt = false;
            foreach ($jsonObjekt as $jo) {
                if (isset($jo->l_label)) {

                    $flagNoObjekt = Location::where('l_label', $jo->l_label)->count() === 0;

                    $location = [
                        'l_name'    => $jo->l_name,
                        'l_beschreibung' => $jo->l_beschreibung,
                        'profile_id'     => $jo->profile_id,
                        'adresse_id'     => $jo->adresse_id,
                        'storage_id'    => $jo->storage_id,
                    ];

                    if ($request->handleImportData === 'append' && !$flagNoObjekt) {
                        $newName = $this->makeCopyName($jo->l_label);
                        if (Location::where('l_label', $newName)->count() === 0) {
                            $location['l_label'] = $this->makeCopyName($jo->l_label);
                            $mkObjekt = true;
                            $neuObjekt++;
                        } elseif (Location::where('l_label', $this->makeCopyName($newName))->count() === 0) {
                            //                            dump('data-append / Duplikat² wird angelegt');
                            $location['l_label'] = $this->makeCopyName($newName);
                            $neuObjekt++;
                            $mkObjekt = true;
                        } else {
                            $fehler++;
                            $fehlerItem[] = $jo->l_label;
                        }
                        if ($mkObjekt) $this->addLocation($location);
                    }

                    if ($request->handleImportData === 'append' && $flagNoObjekt) {
                        $location['l_label'] = $jo->l_label;
                        $this->addLocation($location);
                        $neuObjekt++;
                    }
                    if ($request->handleImportData === 'ignore') {
                        if ($flagNoObjekt) {
                            $location['l_label'] = $jo->l_label;
                            $this->addLocation($location);
                            $neuObjekt++;
                        } else {
                            $duplikat++;
                        }
                    }
                } else {
                    $flagNoObjekt = true;
                    break;
                }
            }
            $res = $this->makeImportResultBlock(count($jsonObjekt), $neuObjekt, $flagNoObjekt, $duplikat, $fehler, $fehlerItem);
        } else {
            $res = '<p class="text-warning">Keine Datei zum Auswerten gefunden!</p>';
        }
        $request->session()->flash('status', $res);
        return redirect()->back();
    }

    protected function makeCopyName($name)
    {
        $neuName = '';
        switch (true) {
            case strlen($name) <= 20 && strlen($name) > 14:
                $neuName = substr($name, 0, 13) . '_1';
                break;
            case strlen($name) <= 14:
                $neuName = $name . '_1';
                break;
        }
        return $neuName;
    }

    protected function addLocation($jo)
    {
        Location::create($jo);
    }

    protected function makeImportResultBlock($numObjekte, $neuObjekt, $flagNoObjekt, $duplikat, $fehler, $fehlerItem)
    {

        $res = '<ul class="list-group">
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Insgesamt  Objekte zum Import übertragen
                        <span class="badge badge-primary badge-pill">' . $numObjekte . '</span>
                      </li>';

        if ($neuObjekt > 0)
            $res .= '<li class="list-group-item d-flex justify-content-between align-items-center">
                        Neu angelegt
                        <span class="badge badge-success badge-pill">' . $neuObjekt . '</span>
                      </li>';

        if ($flagNoObjekt)
            $res .= '  <li class="list-group-item d-flex justify-content-between align-items-center">
                        Es wurden keine passenden Objektdaten gefunden!
                        <span class="badge badge-light badge-pill">&times</span>
                      </li>';

        if ($duplikat > 0)
            $res .= '<li class="list-group-item d-flex justify-content-between align-items-center">
                        Übersprungene Duplikate
                        <span class="badge badge-primary badge-pill">' . $duplikat . '</span>
                      </li>';

        if ($fehler > 0) {
            $res .= '<li class="list-group-item d-flex justify-content-between align-items-center">
                        Fehler beim Einfügen in Datenbank
                        <span class="badge badge-danger badge-pill">' . $fehler . '</span>
                        <p style="flex:none; display: block!important;flex-direction: column;">';
            foreach ($fehlerItem as $item) {
                $res .= '<span>Kürzel => ' . $item . '</span><br>';
            }
            $res .= '        </p>
                      </li>';
        }

        $res .= '</ul>';
        return $res;
    }

    public function exportBuildingJSON()
    {
        return response(Building::all(), 200)
            ->header('Cache-Control', 'public')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', ' application/json')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Content-disposition', "attachment; filename=" . "testware_gebaude_" . time() . ".json");
    }

    public function importBuildingJSON(Request $request)
    {

        if ($request->hasFile('importDataPortFile')) {
            $file = $request->file('importDataPortFile');
            $request->validate([
                'importDataPortFile' => 'required|file|mimes:json,xml|max:2048' // size:2048 => 2048kB
            ]);

            $json = file_get_contents($file->getPath() . '\\' . $file->getFilename(), true);
            $jsonObjekt = json_decode($json);

            $duplikat = 0;
            $fehler = 0;
            $fehlerItem = [];
            $neuObjekt = 0;
            $flagNoObjekt = false;
            $mkObjekt = false;
            foreach ($jsonObjekt as $jo) {
                if (isset($jo->b_label)) {

                    $flagNoObjekt = Building::where('b_label', $jo->b_label)->count() === 0;

                    $objekt = [
                        'b_name_ort'       => $jo->b_name_ort,
                        'b_name'      => $jo->b_name,
                        'b_name_text'      => $jo->b_name_text,
                        'b_we_has'         => $jo->b_we_has,
                        'b_we_name'        => $jo->b_we_name,
                        'location_id'      => $jo->location_id,
                        'building_type_id' => $jo->building_type_id,
                        'storage_id'      => $jo->storage_id,
                    ];

                    if ($request->handleImportData === 'append' && !$flagNoObjekt) {
                        $newName = $this->makeCopyName($jo->b_label);
                        if (Building::where('b_label', $newName)->count() === 0) {
                            $objekt['b_label'] = $this->makeCopyName($jo->b_label);
                            $mkObjekt = true;
                            $neuObjekt++;
                        } elseif (Building::where('b_label', $this->makeCopyName($newName))->count() === 0) {
                            //                            dump('data-append / Duplikat² wird angelegt');
                            $objekt['b_label'] = $this->makeCopyName($newName);
                            $neuObjekt++;
                            $mkObjekt = true;
                        } else {
                            $fehler++;
                            $fehlerItem[] = $jo->b_label;
                        }
                        if ($mkObjekt) $this->addBuilding($objekt);
                    }

                    if ($request->handleImportData === 'append' && $flagNoObjekt) {
                        //                        dump('data-append / b_label)->count()===0');
                        $objekt['b_label'] = $jo->b_label;
                        $this->addBuilding($objekt);
                        $neuObjekt++;
                    }

                    if ($request->handleImportData === 'ignore') {
                        if ($flagNoObjekt) {
                            $objekt['b_label'] = $jo->b_label;
                            $this->addBuilding($objekt);
                            $neuObjekt++;
                        } else {
                            $duplikat++;
                        }
                    }
                } else {
                    $flagNoObjekt = true;
                    break;
                }
            }

            $res = $this->makeImportResultBlock(count($jsonObjekt), $neuObjekt, $flagNoObjekt, $duplikat, $fehler, $fehlerItem);
        } else {
            $res = '<p class="text-warning">Keine Datei zum Auswerten gefunden!</p>';
        }
        $request->session()->flash('status', $res);
        return redirect()->back();
    }

    protected function addBuilding($jo)
    {
        Building::create($jo);
    }

    public function exportRoomJSON()
    {
        return response(Room::with('RoomType')->get(), 200)
            ->header('Cache-Control', 'public')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', ' application/json')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Content-disposition', "attachment; filename=" . "testware_raume_" . time() . ".json");
    }

    public function importRoomJSON(Request $request)
    {
        if ($request->hasFile('importDataPortFile')) {
            $file = $request->file('importDataPortFile');
            $request->validate([
                'importDataPortFile' => 'required|file|mimes:json,xml|max:2048' // size:2048 => 2048kB
            ]);

            $json = file_get_contents($file->getPath() . '\\' . $file->getFilename(), true);
            $jsonObjekt = json_decode($json);

            $duplikat = 0;
            $fehler = 0;
            $fehlerItem = [];
            $neuObjekt = 0;
            $flagNoObjekt = false;
            $mkObjekt = false;
            foreach ($jsonObjekt as $jo) {
                if (isset($jo->r_label)) {

                    $flagNoObjekt = Room::where('r_label', $jo->r_label)->count() === 0;

                    $objekt = [
                        'r_name' => $jo->r_name,
                        'r_name_text' => $jo->r_name_text,
                        'building_id' => $jo->building_id,
                        'storage_id' => $jo->storage_id,
                        'room_type_id' => $jo->room_type_id,
                    ];

                    if ($request->handleImportData === 'append' && !$flagNoObjekt) {
                        $newName = $this->makeCopyName($jo->r_label);
                        if (Room::where('r_label', $newName)->count() === 0) {
                            $objekt['r_label'] = $this->makeCopyName($jo->r_label);
                            $mkObjekt = true;
                            $neuObjekt++;
                        } elseif (Room::where('r_label', $this->makeCopyName($newName))->count() === 0) {
                            //                            dump('data-append / Duplikat² wird angelegt');
                            $objekt['r_label'] = $this->makeCopyName($newName);
                            $neuObjekt++;
                            $mkObjekt = true;
                        } else {
                            $fehler++;
                            $fehlerItem[] = $jo->r_label;
                        }
                        if ($mkObjekt) $this->addRoom($objekt);
                    }

                    if ($request->handleImportData === 'append' && $flagNoObjekt) {
                        //                        dump('data-append / r_label)->count()===0');
                        $objekt['r_label'] = $jo->r_label;
                        $this->addRoom($objekt);
                        $neuObjekt++;
                    }

                    if ($request->handleImportData === 'ignore') {
                        if ($flagNoObjekt) {
                            $objekt['r_label'] = $jo->r_label;
                            $this->addRoom($objekt);
                            $neuObjekt++;
                        } else {
                            $duplikat++;
                        }
                    }
                } else {
                    $flagNoObjekt = true;
                    break;
                }
            }

            $res = $this->makeImportResultBlock(count($jsonObjekt), $neuObjekt, $flagNoObjekt, $duplikat, $fehler, $fehlerItem);
        } else {
            $res = '<p class="text-warning">Keine Datei zum Auswerten gefunden!</p>';
        }
        $request->session()->flash('status', $res);
        return redirect()->back();
    }

    public function exportStellplatzJSON()
    {
        return response(Stellplatz::all(), 200)
            ->header('Cache-Control', 'public')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', ' application/json')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Content-disposition', "attachment; filename=" . "testware_stellplatzliste_" . time() . ".json");
    }

    public function importStellplatzJSON(Request $request)
    {
        if ($request->hasFile('importDataPortFile')) {
            $file = $request->file('importDataPortFile');
            $request->validate([
                'importDataPortFile' => 'required|file|mimes:json|max:2048' // size:2048 => 2048kB
            ]);

            $json = file_get_contents($file->getPath() . '\\' . $file->getFilename(), true);
            $jsonObjekt = json_decode($json);

            $duplikat = 0;
            $fehler = 0;
            $fehlerItem = [];
            $neuObjekt = 0;
            $flagNoObjekt = false;
            $mkObjekt = false;
            foreach ($jsonObjekt as $jo) {
                if (isset($jo->sp_label)) {

                    $flagNoObjekt = Stellplatz::where('sp_label', $jo->sp_label)->count() === 0;

                    $objekt = [
                        'sp_name' => $jo->sp_name,
                        'sp_name_text' => $jo->sp_name_text,
                        'room_id' => $jo->room_id,
                        'storage_id' => $jo->storage_id,
                        'stellplatz_typ_id' => $jo->stellplatz_typ_id,
                    ];

                    if ($request->handleImportData === 'append' && !$flagNoObjekt) {
                        $newName = $this->makeCopyName($jo->sp_label);
                        if (Stellplatz::where('sp_label', $newName)->count() === 0) {
                            $objekt['sp_label'] = $this->makeCopyName($jo->sp_label);
                            $mkObjekt = true;
                            $neuObjekt++;
                        } elseif (Stellplatz::where('sp_label', $this->makeCopyName($newName))->count() === 0) {
                            //                            dump('data-append / Duplikat² wird angelegt');
                            $objekt['sp_label'] = $this->makeCopyName($newName);
                            $neuObjekt++;
                            $mkObjekt = true;
                        } else {
                            $fehler++;
                            $fehlerItem[] = $jo->sp_label;
                        }
                        if ($mkObjekt) $this->addStellplatz($objekt);
                    }

                    if ($request->handleImportData === 'append' && $flagNoObjekt) {
                        //                        dump('data-append / sp_label)->count()===0');
                        $objekt['sp_label'] = $jo->sp_label;
                        $this->addStellplatz($objekt);
                        $neuObjekt++;
                    }

                    if ($request->handleImportData === 'ignore') {
                        if ($flagNoObjekt) {
                            $objekt['sp_label'] = $jo->sp_label;
                            $this->addStellplatz($objekt);
                            $neuObjekt++;
                        } else {
                            $duplikat++;
                        }
                    }
                } else {
                    $flagNoObjekt = true;
                    break;
                }
            }

            $res = $this->makeImportResultBlock(count($jsonObjekt), $neuObjekt, $flagNoObjekt, $duplikat, $fehler, $fehlerItem);
        } else {
            $res = '<p class="text-warning">Keine Datei zum Auswerten gefunden!</p>';
        }
        $request->session()->flash('status', $res);
        return redirect()->back();
    }

    public function exportProduktToJson()
    {
        return response(Produkt::with(
            'ProduktKategorie',
            'ProduktState',
            'ProduktParam',
            'ProduktAnforderung'
        )->get(), 200)
            ->header('Cache-Control', 'public')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', ' application/json')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Content-disposition', "attachment; filename=" . "testware_produkte_" . time() . ".json");
    }

    protected function addRoom($jo)
    {
        Room::create($jo);
    }

    protected function addStellplatz($jo)
    {
        Stellplatz::create($jo);
    }
}
