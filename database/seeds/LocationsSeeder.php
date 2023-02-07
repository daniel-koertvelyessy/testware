<?php

    namespace Database\Seeders;

    use App\Adresse;
    use App\Building;
    use App\Location;
    use App\Profile;
    use App\Room;
    use App\Stellplatz;
    use App\Storage;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;

    class LocationsSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {

            $adresseHQ = Adresse::create([
                'ad_label'                => 'ad_malbom_hq',
                'ad_name'                 => 'malbom Stammwerk',
                'ad_name_firma'           => 'malbom GmbH',
                'ad_name_firma_co'        => '',
                'ad_anschrift_strasse'    => 'Malipner Straße',
                'ad_anschrift_hausnummer' => '5',
                'ad_anschrift_plz'        => '13458',
                'ad_anschrift_ort'        => 'Berlin',
                'address_type_id'         => 1,
                'land_id'                 => 1,

            ]);

            $profile = Profile::factory()->create();

            $hauptwerk = Location::create([
                'l_benutzt'      => now(),
                'l_label'        => 'Malbom-HQ-BLN',
                'l_name'         => 'Stammwerk',
                'l_beschreibung' => 'Firmensitz und Verwaltung',
                'adresse_id'     => $adresseHQ->id,
                'profile_id'     => $profile->id,
                'storage_id'     => Str::uuid(),
            ]);

            (new Storage())->add($hauptwerk->storage_id, $hauptwerk->l_label, 'locations');


            $hauptGebaeude = Building::create([
                'b_label'          => 'malbom.g.1',
                'b_name'           => 'Büro / Verwaltung',
                'location_id'      => $hauptwerk->id,
                'building_type_id' => 1,
                'storage_id'       => Str::uuid(),
            ]);

            (new Storage())->add($hauptGebaeude->storage_id, $hauptGebaeude->b_label, 'buildings');

            $empfang = Room::create([
                'r_label' => 'm.g.1.01',
                'r_name' => 'Empfang - Assistenz',
                'storage_id' => Str::uuid(),
                'building_id' => $hauptGebaeude->id,
                'room_type_id' => 1,
            ]);
            (new Storage())->add($empfang->storage_id, $empfang->r_label, 'rooms');

            $stellplatz = Stellplatz::create([
                'sp_label' => 'sp-'.$empfang->id.'.1.01',
                'sp_name' => 'AP Empfang',
                'storage_id' => Str::uuid(),
                'room_id' => $empfang->id,
                'stellplatz_typ_id' => 4,
            ]);
            (new Storage())->add($stellplatz->storage_id, $stellplatz->sp_label, 'stellplatzs');


            $buero_ek = Room::create([
                'r_label' => 'm.g.1.02',
                'r_name' => 'Büro Einkauf - Planung',
                'storage_id' => Str::uuid(),
                'building_id' => $hauptGebaeude->id,
                'room_type_id' => 1,
            ]);
            (new Storage())->add($buero_ek->storage_id, $buero_ek->r_label, 'rooms');

            $stellplatz = Stellplatz::create([
                'sp_label' => 'sp-'.$buero_ek->id.'.1.02',
                'sp_name' => 'AP Fenster Links',
                'storage_id' => Str::uuid(),
                'room_id' => $buero_ek->id,
                'stellplatz_typ_id' => 4,
            ]);
            (new Storage())->add($stellplatz->storage_id, $stellplatz->sp_label, 'stellplatzs');

            $stellplatz = Stellplatz::create([
                'sp_label' => 'sp-'.$buero_ek->id.'.1.03',
                'sp_name' => 'AP Fenster Rechts',
                'storage_id' => Str::uuid(),
                'room_id' => $buero_ek->id,
                'stellplatz_typ_id' => 4,
            ]);
            (new Storage())->add($stellplatz->storage_id, $stellplatz->sp_label, 'stellplatzs');



            $buero_gl = Room::create([
                'r_label' => 'm.g.1.03',
                'r_name' => 'Büro Geschäftsleitung',
                'storage_id' => Str::uuid(),
                'building_id' => $hauptGebaeude->id,
                'room_type_id' => 1,
            ]);
            (new Storage())->add($buero_gl->storage_id, $buero_gl->r_label, 'rooms');

            $pausenraum = Room::create([
                'r_label' => 'm.g.1.04',
                'r_name' => 'Pausenraum - Kaffeeküche',
                'storage_id' => Str::uuid(),
                'building_id' => $hauptGebaeude->id,
                'room_type_id' => 5,
            ]);
            (new Storage())->add($pausenraum->storage_id, $pausenraum->r_label, 'rooms');

            $edv = Room::create([
                'r_label' => 'm.g.1.05',
                'r_name' => 'EDV - Serverraum',
                'storage_id' => Str::uuid(),
                'building_id' => $hauptGebaeude->id,
                'room_type_id' => 6,
            ]);
            (new Storage())->add($edv->storage_id, $edv->r_label, 'rooms');


            $werkstattGebaeude = Building::create([
                'b_label'          => 'malbom.g.2',
                'b_name'           => 'Fertigung / Werkstatt',
                'location_id'      => $hauptwerk->id,
                'building_type_id' => 2,
                'storage_id'       => Str::uuid(),
            ]);

            (new Storage())->add($werkstattGebaeude->storage_id, $werkstattGebaeude->b_label, 'buildings');

            $lagerGebaeude = Building::create([
                'b_label'          => 'malbom.g.3',
                'b_name'           => 'Lager',
                'location_id'      => $hauptwerk->id,
                'building_type_id' => 3,
                'storage_id'       => Str::uuid(),
            ]);

            (new Storage())->add($lagerGebaeude->storage_id, $lagerGebaeude->b_label, 'buildings');


            /**
             *
             *    2. Werk
             *
             */
            $adresseWerk = Adresse::create([
                'ad_label'                => 'ad_malbom_w1',
                'ad_name'                 => 'malbom FuE',
                'ad_name_firma'           => 'malbom GmbH',
                'ad_name_firma_co'        => '',
                'ad_anschrift_strasse'    => 'Plenarer Straße',
                'ad_anschrift_hausnummer' => '15-16',
                'ad_anschrift_plz'        => '521568',
                'ad_anschrift_ort'        => 'Rheine',
                'address_type_id'         => 1,
                'land_id'                 => 1,

            ]);

            $werk = Location::create([
                'l_benutzt'      => now(),
                'l_label'        => 'Maleb-BLN-RE',
                'l_name'         => 'Werk Rheine',
                'l_beschreibung' => 'Fertigung und Entwicklung',
                'adresse_id'     => $adresseWerk->id,
                'profile_id'     => $profile->id,
                'storage_id'     => Str::uuid(),
            ]);

            (new Storage())->add($hauptwerk->storage_id, $hauptwerk->l_label, 'locations');

            (new Storage())->add($werk->storage_id, $werk->l_label, 'locations');


        }
    }
