<?php

    namespace App\Http\Services\Location;

    use App\Adresse;

    class AddressService
    {

        protected function query(string $term)
        {
            return Adresse::where('ad_label','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('ad_name','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('ad_name_firma','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('ad_name_firma_2','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('ad_name_firma_co','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('ad_name_firma_abladestelle','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('ad_name_firma_wareneingang','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('ad_name_firma_abteilung','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('ad_anschrift_strasse','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('ad_anschrift_hausnummer','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('ad_anschrift_etage','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('ad_anschrift_eingang','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('ad_anschrift_plz','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('ad_anschrift_ort','ILIKE', '%' . strtolower($term) . '%')
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