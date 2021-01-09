<?php

namespace App;

class Testware
{

    public static function checkTWStatus(): string
    {
        $data = '';
        $noProdukt = false;
        $missingProdukt = '';
        $noBuilding = false;
        $missingBuilding = '';
        $noLocation = false;
        $missingLocation = '';
        $noVerordnung = false;
        $missingVerordnung = '';
        $noAnforderung = false;
        $emptyAnforderungListe = '';
        $noAnforderungInVerordnung = false;
        $emptyVerordnungListe = '';
        $emptyAnforderungListe = '';
        $noAnforderung = true;
        $noAnforderungInAnforderung = true;
        $missingControlEquipment = '';
        $noControlEquipment = true;


        if (Produkt::count() === 0) {
            $missingProdukt = '<div class="col-md-6 col-lg-3">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>' . __('Hinweis!') . '</strong>
                        <p class="lead">' . __('Es sind keine Produke angelegt') . '</p>
                        <a href="' . route('produkt.create') . '" class="btn btn-light text-primary">' . __('Neues Produkt anlegen') . '</a>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>';
            $noProdukt = true;
        }

        if (ControlProdukt::count() === 0 && !$noProdukt) {
            $missingControlEquipment = '<div class="col-md-6 col-lg-3">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>' . __('Hinweis!') . '</strong>
                        <p class="lead">' . __('Es sind keine Prüfgeräte angelegt') . '</p>
                        <a href="' . route('equipment.maker') . '" class="btn btn-light text-primary">' . __('Neues Gerät anlegen') . '</a>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>';
            $noControlEquipment = true;
        }


        if (Building::count() === 0) {
            $missingBuilding = '<div class="col-md-6 col-lg-3">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>' . __('Hinweis!') . '</strong>
                        <p class="lead">' . __('Es sind keine Gebäude angelegt') . '</p>
                        <a href="' . route('building.create') . '" class="btn btn-light text-primary">' . __('Neues Gebäude anlegen') . '</a>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>';
            $noBuilding = true;
        }
        /*
            Prüfe ob Verordnungen existieren
            */
        if (Verordnung::count() > 0) {
            $emptyVerordnungListe = '<div class="col-md-6 col-lg-3">
                <div class="list-group-item-danger p-2 border-danger border">
                <p class="lead">' . __('Verordnungen ohne Anforderung') . '</p>
                <div class="list-group">';
            foreach (Verordnung::all() as $verordnung) {
                if (Anforderung::where('verordnung_id', $verordnung->id)->count() === 0) {
                    $verordnung_name = $verordnung->vo_name;
                    $emptyVerordnungListe .= '<div class="list-group-item justify-content-between list-group-item-danger">
                        <p>' . $verordnung_name . '</p>
                        <a href="' . route('verordnung.show', $verordnung) . '" class="btn btn-sm btn-light text-primary">Verordnung öffnen</a>';
                    $emptyVerordnungListe .= '</div>';
                    $noAnforderungInVerordnung = true;
                }
            }
            $emptyVerordnungListe .= '</div></div></div>';
        } else {
            $missingVerordnung = '<div class="col-md-6 col-lg-3">

                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>' . __('Hinweis!') . '</strong>
                        <p class="lead">' . __('Es sind keine Verordnungen angelegt') . '</p>
                        <a href="' . route('verordnung.create') . '">' . __('Neue Verordnung anlegen') . '</a>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>';
            $noVerordnung = true;
        }

        /*
           Prüfe ob Verordnungen existieren
           */
        if (Anforderung::count() > 0) {
            $emptyAnforderungListe = '<div class="col-md-6 col-lg-3">
                <div class="list-group-item-danger p-2 border-danger border">
                <p class="lead">' . __('Anforderungen ohne Kontrollvorgänge') . '</p>
                <div class="list-group">';
            foreach (Anforderung::all() as $anforderung) {
                if (Anforderung::where('verordnung_id', $anforderung->id)->count() === 0) {
                    $anforderung_name = $anforderung->an_name;
                    $emptyAnforderungListe .= '<div class="list-group-item justify-content-between list-group-item-danger">
                        <p>' . $anforderung_name . '</p>
                        <a href="' . route('anforderung.show', $anforderung) . '" class="btn btn-sm btn-light text-primary">Anforderung öffnen</a>';
                    $emptyAnforderungListe .= '</div>';
                    $noAnforderungInAnforderung = true;
                }
            }
            $emptyAnforderungListe .= '</div></div></div>';
        } else {
            $missingAnforderung = '<div class="col-md-6 col-lg-3">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>' . __('Hinweis!') . '</strong>
                        <p class="lead">' . __('Es sind keine Anforderungen angelegt') . '</p>
                        <a href="' . route('verordnung.create') . '">' . __('Neue Anforderung anlegen') . '</a>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>';
            $noAnforderung = true;
        }

        $tw = new Testware();
        $checkNumberOfLocations = $tw->checkNumberOfLocations();
        $checkSystemHasBuildings = $tw->checkSystemHasBuildings();

        if ($noProdukt || $checkNumberOfLocations || $checkSystemHasBuildings || $noVerordnung || $noAnforderung || $noAnforderungInVerordnung || $noControlEquipment) {
            $data .= '<h2 class="h4 mt-4">' . __('Es fehlen noch Objekte') . '</h2><div class="row ">';
            if ($noProdukt) {
                $data .= $missingProdukt;
            } else {
                if ($noControlEquipment) $data .= $missingControlEquipment;
            }
            if ($checkNumberOfLocations) {
                $data .= $missingLocation;
            } else {
                if ($checkSystemHasBuildings) $data .= $missingBuilding;
            }
            if ($noVerordnung) $data .= $missingVerordnung;
            if ($noAnforderungInVerordnung) $data .= $emptyVerordnungListe;
            if ($noAnforderung) $data .= $emptyAnforderungListe;
            $data .= '</div>';
        }

        return $data;
    }

    public function checkNumberOfLocations()
    {
        return (Location::count() === 0)
            ?
            '\n<x-testwareStatusBox
                    status="danger"
                    link="' . route('location.create') . '"
                    message="' . __('Es sind keine Standorte vorhanden.') . '"
                    linklabel="' . __('Standort anlegen') . '"
                />'
            :
            false;
    }

    public function checkSystemHasBuildings()
    {
        return (Building::count() === 0)
            ?
            '\n<x-testwareStatusBox
                    status="danger"
                    link="' . route('building.create') . '"
                    message="' . __('Es sind keine Gebäude vorhanden.') . '"
                    linklabel="' . __('Gebäude anlegen') . '"
                />'
            :
            false;
    }

    public function checkNumberOfRooms()
    {
        return (Room::count() === 0)
            ?
            $this->makeTestWareStatusBox(
                'danger',
                route('room.create'),
                __('Es sind keine Räume vorhanden.'),
                __('Räume anlegen')
            )
            :
            false;
    }

    private function makeTestWareStatusBox($status, $link, $message, $linklabel): string
    {
        return '\n<x-testwareStatusBox
                    status="' . $status . '"
                    link="' . $link . '"
                    message="' . $message . '"
                    linklabel="' . $linklabel . '"
                />';
    }
}
