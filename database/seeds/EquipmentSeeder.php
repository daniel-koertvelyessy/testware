<?php

use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $produkt = factory(App\Produkt::class, 100)->create();
        $storage = \App\Storage::all();
        $bul =  factory(App\Equipment::class, 2012)->make()->each(function ($equip) use ($produkt, $storage) {
            $uid = \Illuminate\Support\Str::uuid();
            $equip->eq_uid = $uid;
            $equip->storage_id =  $storage->random()->id;
            $equip->produkt_id = $produkt->random()->id;
            $equip->save();

            DB::table('equipment_uids')->insert([
                'equipment_uid' => $uid,
                'equipment_id' => $equip->id
            ]);

            DB::table('equipment_histories')->insert([
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => NULL,
                    'eqh_eintrag_kurz' => 'Neu',
                    'eqh_eintrag_text' => 'Das Gerät wurde angelegt',
                    'equipment_id' => $equip->id,
                ]
            ]);

            DB::table('control_equipment')->insert([
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => NULL,
                    'qe_control_date_last' => now()->addMonths(-2),
                    'qe_control_date_due' => now()->addWeeks(random_int(3, 40)),
                    'anforderung_id' => 1,
                    'equipment_id' => $equip->id,
                ]
            ]);
        });



        /*        DB::table('produkts')->insert([
            [
                'id' => '31',
                'created_at' => '2020-09-28 13:03:00',
                'updated_at' => '2020-09-28 13:17:27',
                'deleted_at' => NULL,
                'prod_label' => 'MED-288-U',
                'prod_name' => 'Medikamenten-Kühlschrank MED 288 ULTIMATE',
                'prod_name_text' => NULL,
                'prod_nummer' => '92002652',
                'prod_active' => '1',
                'produkt_kategorie_id' => '1',
                'produkt_state_id' => '1'
            ]
        ]);

        DB::table('produkt_docs')->insert([
            [
                'id' => '1',
                'created_at' => '2020-09-28 13:17:41',
                'updated_at' => '2020-09-28 13:17:41',
                'deleted_at' => NULL,
                'proddoc_label' => 'Anleitung',
                'proddoc_name' => 'MED_288_ULTIMATE.pdf',
                'proddoc_name_pfad' => 'produkt_docu/31/ejhGroVPr8l1Kn7nsjp3V79ZBOLQ1vkBycnqn0ra.pdf',
                'proddoc_name_text' => NULL,
                'produkt_id' => '31',
                'document_type_id' => '1',
            ]
        ]);

        DB::table('produkt_docs')->insert([
            [
                'proddoc_name' => 'MED_288_ULTIMATE.pdf',
                'proddoc_name_pfad' => 'produkt_docu/31/ejhGroVPr8l1Kn7nsjp3V79ZBOLQ1vkBycnqn0ra.pdf',

                'proddoc_label' => 'Anleitung',
            ]
        ]);

        DB::table('firma_produkt')->insert([
            [
                'id' => '1',
                'created_at' => '2020-09-29 09:17:42',
                'updated_at' => '2020-09-29 09:17:42',
                'deleted_at' => NULL,
                'firma_id' => '9',
                'produkt_id' => '31',
            ]
        ]);

        $uid = \Illuminate\Support\Str::uuid();
        DB::table('equipment')->insert([
            [
                'id' => '4',
                'deleted_at' => NULL,
                'created_at' => '2020-09-28 19:50:07',
                'updated_at' => '2020-09-28 19:50:07',
                'eq_inventar_nr' => '323134',
                'eq_serien_nr' => '654367',
                'eq_qrcode' => NULL,
                'eq_ibm' => '2020-09-24',
                'eq_text' => NULL,
                'equipment_state_id' => '1',
                'produkt_id' => '31',
                'storage_id' => '4',
                'eq_uid' => $uid,
            ]
        ]);

        DB::table('equipment_uids')->insert([
            [
                'equipment_uid' => $uid,
                'equipment_id' => '4'
            ]
        ]);

        DB::table('equipment_histories')->insert([
            [
                'id' => '1',
                'created_at' => '2020-09-29 15:30:36',
                'updated_at' => '2020-09-29 15:30:36',
                'deleted_at' => NULL,
                'eqh_eintrag_kurz' => 'Neu',
                'eqh_eintrag_text' => 'Das Gerät wurde angelegt',
                'equipment_id' => '4',
            ]
        ]);*/
    }
}
