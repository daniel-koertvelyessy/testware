<?php

    namespace App\Http\Services\Location;

    use App\Adresse;

    class AddressService
    {

        protected function query(string $term)
        {
            return Adresse::whereRaw('lower(ad_label) like ?', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(ad_name) like ? ', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(ad_name_firma) like ? ', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(ad_name_firma_2) like ? ', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(ad_name_firma_co) like ? ', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(ad_name_firma_abladestelle) like ? ', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(ad_name_firma_wareneingang) like ? ', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(ad_name_firma_abteilung) like ? ', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(ad_anschrift_strasse) like ? ', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(ad_anschrift_hausnummer) like ? ', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(ad_anschrift_etage) like ? ', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(ad_anschrift_eingang) like ? ', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(ad_anschrift_plz) like ? ', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(ad_anschrift_ort) like ? ', '%' . strtolower($term) . '%')
                ->get();

        }

        public static function getSearchResults(string $term): array
        {
            $data = [];
            foreach ((new AddressService)->query($term) as $ret) {
                $data[] = [
                    'link'  => route('adresse.show', $ret),
                    'label' => '[' . __('Adresse') . '] ' . $ret->ad_label . ' ' . $ret->ad_anschrift_strasse . ' / ' . $ret->ad_anschrift_hausnummer
                ];
            }

            return $data;

        }

        public static function search(string $term)
        {
            return (new AddressService)->query($term);
        }


    }