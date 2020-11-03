<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitialValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Daniel Körtvélyessy',
                'email' => 'daniel.koertvelyessy@gmail.com',
                'email_verified_at' => now(),
                'username' => 'daniel',
                'password' => '$2y$10$QTYenoYuRpR6Kp5e2UjidOZ8xRDlxnQjtdxFed/ecvfSzE3UVezna',
            ],
            [
                'name' => 'Martin Schubert',
                'email' => 'martin@bitpack.io',
                'email_verified_at' => now(),
                'username' => 'martin',
                'password' => '$2y$10$X7eQRHOqNesOEXh8sCZlKu2PF3XSi2SgU90x7r1TPbAmg5MJRu.Si',
            ],
            [
                'name' => 'Matthias Roethig',
                'email' => 'matthias@bitpack.io',
                'email_verified_at' => now(),
                'username' => 'matthias',
                'password' => '$2y$10$rSL7UWBig6GElydsciIDO.K54wfG2TgNdIKiw3KFd6K2dmSKlZ8G6',
            ],
        ]);

        DB::table('profiles')->insert([
            [
                'user_id' => 3,
                'ma_nummer' => random_int(1000, 2000),
                'ma_name' => 'Roethig',
                'ma_name_2' => '',
                'ma_vorname' => 'Matthias',
                'ma_geburtsdatum' => now()->addYears(-38),
                'ma_eingetreten' => now()->addYears(-5),
                'ma_telefon' => '',
                'ma_mobil' => '',
            ],
            [
                'user_id' => 2,
                'ma_nummer' => random_int(1000, 2000),
                'ma_name' => 'Schubert',
                'ma_name_2' => '',
                'ma_vorname' => 'Martin',
                'ma_geburtsdatum' => now()->addYears(-42),
                'ma_eingetreten' => now()->addYears(-13),
                'ma_telefon' => '',
                'ma_mobil' => '',
            ],
            [
                'user_id' => 1,
                'ma_nummer' => random_int(1000, 2000),
                'ma_name' => 'Körtvélyessy',
                'ma_name_2' => '',
                'ma_vorname' => 'Daniel',
                'ma_geburtsdatum' => now()->addYears(-46),
                'ma_eingetreten' => now()->addYears(-15),
                'ma_telefon' => '03040586940',
                'ma_mobil' => '',
            ],
        ]);

        DB::table('anredes')->insert([
            [
                'an_kurz' => 'Hr',
                'an_formal' => 'Herr',
                'an_greet' => 'Sehr geehrter Herr',
            ], [
                'an_kurz' => 'Fr',
                'an_formal' => 'Frau',
                'an_greet' => 'Sehr geehrte Frau',
            ]
        ]);

        DB::table('lands')->insert([
            ['land_iso' => 'DE', 'land_lang' => 'Deutschland'],
            ['land_iso' => 'AT', 'land_lang' => 'Österreich'],
            ['land_iso' => 'BE', 'land_lang' => 'Belgien'],
            ['land_iso' => 'FI', 'land_lang' => 'Finnland'],
            ['land_iso' => 'DK', 'land_lang' => 'Dänemark'],
            ['land_iso' => 'SK', 'land_lang' => 'Slowakei'],
            ['land_iso' => 'NL', 'land_lang' => 'Niederlande'],
            ['land_iso' => 'ES', 'land_lang' => 'Spanien'],
            ['land_iso' => 'IE', 'land_lang' => 'Irland'],
            ['land_iso' => 'IT', 'land_lang' => 'Italien'],
            ['land_iso' => 'MK', 'land_lang' => 'Ehemalige Jugoslawische Republik Mazedonien'],
            ['land_iso' => 'SE', 'land_lang' => 'Schweden'],
            ['land_iso' => 'PL', 'land_lang' => 'Polen'],
            ['land_iso' => 'VA', 'land_lang' => 'Vatikanstadt'],
            ['land_iso' => 'CY', 'land_lang' => 'Zypern'],
            ['land_iso' => 'FR', 'land_lang' => 'Frankreich'],
            ['land_iso' => 'PT', 'land_lang' => 'Portugal'],
            ['land_iso' => 'GR', 'land_lang' => 'Griechenland'],
            ['land_iso' => 'RO', 'land_lang' => 'Rumänien'],
            ['land_iso' => 'LU', 'land_lang' => 'Luxemburg'],
            ['land_iso' => 'HU', 'land_lang' => 'Ungarn'],
        ]);

        DB::table('control_intervals')->insert([  // SELECT INTERVAL 1 DAY + '2008-12-31';    SELECT DATE_ADD('2010-12-31 23:59:59', INTERVAL 1 DAY);
            [
              'ci_name' => 'Sekunde',
              'ci_name_lang' => 'Sekunden',
              'ci_si' => 's',
              'ci_delta' => 'SECOND',
            ],
            [
              'ci_name' => 'Minute',
              'ci_name_lang' => 'Minuten',
              'ci_si' => 'min',
              'ci_delta' => 'MINUTE',
            ],
            [
              'ci_name' => 'Stunde',
              'ci_name_lang' => 'Stunden',
              'ci_si' => 'h',
              'ci_delta' => 'HOUR',
            ],
            [
              'ci_name' => 'Tag',
              'ci_name_lang' => 'Tage',
              'ci_si' => 'd',
              'ci_delta' => 'DAY',
            ],
            [
              'ci_name' => 'Woche',
              'ci_name_lang' => 'Wochen',
              'ci_si' => 'w',
              'ci_delta' => 'WEEK',
            ],
            [
              'ci_name' => 'Monat',
              'ci_name_lang' => 'Monate',
              'ci_si' => 'm',
              'ci_delta' => 'MONTH',
            ],
            [
              'ci_name' => 'Quartal',
              'ci_name_lang' => 'Quartale',
              'ci_si' => '4m',
              'ci_delta' => 'QUARTER',
            ],
            [
              'ci_name' => 'Jahr',
              'ci_name_lang' => 'Jahre',
              'ci_si' => 'Y',
              'ci_delta' => 'YEAR',
            ],
        ]);

        DB::table('building_types')->insert([
            [
                'btname' => 'Büro',
                'btbeschreibung' => 'Gebäude mit reiner Büronutzung'
            ],
            [
                'btname' => 'Werkstatt',
                'btbeschreibung' => 'Gebäude mit reiner Werkstattnutzung'
            ],
            [
                'btname' => 'Lager',
                'btbeschreibung' => 'Gebäude mit reiner Lagernutzung'
            ]
        ]);


        DB::table('address_types')->insert([
            [
                'adt_name' => 'Heimadress',
                'adt_text_lang' => 'Standard Adresse'
            ],
            [
                'adt_name' => 'RG-Adresse',
                'adt_text_lang' => 'Rechnungsadresse'
            ],
            [
                'adt_name' => 'LS-Adresse',
                'adt_text_lang' => 'Lieferadresse'
            ]
        ]);

        DB::table('room_types')->insert([
            [
                'rt_name_kurz' => 'Büro',
                'rt_name_lang' => 'Büroraum'
            ],
            [
                'rt_name_kurz' => 'Abstell',
                'rt_name_lang' => 'Abstellraum'
            ],
            [
                'rt_name_kurz' => 'Material',
                'rt_name_lang' => 'Materialraum'
            ]
        ]);

        DB::table('produkt_states')->insert([
            [
                'ps_name_kurz' => 'freigegeben',
                'ps_name_lang' => 'Produkt kann verwendet werden',
                'ps_color' => 'success',
                'ps_icon' => 'fas fa-check',
            ],
            [
                'ps_name_kurz' => 'gesperrt',
                'ps_name_lang' => 'Produkt ist gesperrt und darf nicht verwendet werden',
                'ps_color' => 'danger',
                'ps_icon' => 'fas fa-exclamation',
            ]
        ]);


        DB::table('equipment_states')->insert([
            [
                'estat_name_kurz' => 'freigegeben',
                'estat_name_lang' => 'Gerät kann verwendet werden',
                'estat_color' => 'success',
                'estat_icon' => 'fas fa-check',
            ],
            [
                'estat_name_kurz' => 'beschädigt',
                'estat_name_lang' => 'Gerät ist beschädigt, kann aber verwendet werden',
                'estat_color' => 'warning',
                'estat_icon' => 'fas fa-exclamation-circle',
            ],
            [
                'estat_name_kurz' => 'reparatur',
                'estat_name_lang' => 'Gerät kann nicht verwendet werden und muss repariert werden',
                'estat_color' => 'warning',
                'estat_icon' => 'fas fa-exclamation-triangle',
            ],
            [
                'estat_name_kurz' => 'gesperrt',
                'estat_name_lang' => 'Gerät ist gesperrt und darf nicht verwendet werden',
                'estat_color' => 'danger',
                'estat_icon' => 'fas fa-exclamation',
            ]
        ]);

        DB::table('produkt_kategories')->insert([
            [
                'pk_name_kurz' => 'ohne',
                'pk_name_nummer' => '-',
                'pk_name_lang' => 'Keine Zuordnung'
            ],
            [
                'pk_name_kurz' => 'kühlerMed',
                'pk_name_nummer' => 'mk-',
                'pk_name_lang' => 'Medizinische Kühlschänke'
            ],

        ]);
        DB::table('verordnungs')->insert([
            [
                'vo_name_kurz' => 'VDE 0100-600',
                'vo_nummer' => 'DIN VDE 0100-600',
                'vo_stand' => '2016',
                'vo_name_lang' => 'Erst- / Prüfung von elektrischen Geräten',
                'vo_name_text' => 'Errichten von Niederspannungsanlagen - Teil 6: Prüfungen (IEC 60364-6:2016); Deutsche Übernahme HD 60364-6:2016 + A11:2017',
            ],
            [
                'vo_name_kurz' => 'MPBetreibV',
                'vo_nummer' => 'MPBetreibV-2018',
                'vo_stand' => '29.11.2018 I 2034',
                'vo_name_lang' => 'Medizinprodukte-Betreiberverordnung',
                'vo_name_text' => 'Verordnung über das Errichten, Betreiben und Anwenden von Medizinprodukten',
            ],
            [
                'vo_name_kurz' => 'MPSV',
                'vo_nummer' => 'MPSV_2017',
                'vo_stand' => '01.1.2017',
                'vo_name_lang' => 'Medizinprodukte-Sicherheitsplanverordnung',
                'vo_name_text' => 'Verordnung über die Erfassung, Bewertung und Abwehr von Risiken bei Medizinprodukten',
            ],
            [
                'vo_name_kurz' => 'iso9001',
                'vo_nummer' => '9001:2015',
                'vo_stand' => '2015',
                'vo_name_lang' => 'Qualitätsmanagementsysteme –Anforderungen',
                'vo_name_text' => 'Die Einführung eines Qualitätsmanagementsystems ist eine strategische Entscheidung einer Organisation, die helfen kann, ihre Gesamtleistung zu steigern und eine gute Basis für nachhaltige
Entwicklungsinitiativen bereitstellt.',
            ],

        ]);

        DB::table('anforderung_types')->insert([
            [
                'at_name_kurz' => 'control',
                'at_name_lang' => 'Prüfung',
                'at_name_text' => 'Überprüfung eines Gerätes entsprechend den Vorgaben. Beispiel eine Aufnahme eines Kontrollwertes oder eine visuelle Prüfung',
            ],
            [
                'at_name_kurz' => 'wartung',
                'at_name_lang' => 'Wartung',
                'at_name_text' => 'Die regelmäßige Wartung von Geräten ermöglicht deren sicheren Gebrauch.',
            ],
            [
                'at_name_kurz' => 'kalibrierung',
                'at_name_lang' => 'Kalibrierung',
                'at_name_text' => 'Die regelmäßige Kalibrierung von Geräten ermöglicht eine genaue Bewertung der Messergebnisse.',
            ],


        ]);

        DB::table('anforderungs')->insert([
            [
                'an_name_kurz' => 'VDE Klasse 1',
                'an_name_lang' => 'Einstufung VDE Schutzklasse 1',
                'verordnung_id' => 1,
                'anforderung_type_id' => 1,
                'an_control_interval' => 1,
                'control_interval_id' => 8,
            ],
            [
                'an_name_kurz' => 'VDE Klasse 2',
                'an_name_lang' => 'Einstufung VDE Schutzklasse 2',
                'verordnung_id' => 1,
                'anforderung_type_id' => 1,
                'an_control_interval' => 1,
                'control_interval_id' => 8,
            ],
            [
                'an_name_kurz' => 'VDE Klasse 3',
                'an_name_lang' => 'Einstufung VDE Schutzklasse 3',
                'verordnung_id' => 1,
                'anforderung_type_id' => 1,
                'an_control_interval' => 1,
                'control_interval_id' => 8,
            ],
            [
                'an_name_kurz' => 'VDE Leitungen',
                'an_name_lang' => 'Einstufung VDE Schutzklasse Leitungen',
                'verordnung_id' => 1,
                'anforderung_type_id' => 1,
                'an_control_interval' => 1,
                'control_interval_id' => 8,
            ],
            [
                'an_name_kurz' => 'MedProdUnkr',
                'an_name_lang' => 'Unkritischen Medizinprodukt',
                'verordnung_id' => 2,
                'anforderung_type_id' => 1,
                'an_control_interval' => 1,
                'control_interval_id' => 8,
            ],
            [
                'an_name_kurz' => 'MedProdSK-A',
                'an_name_lang' => 'Semikritisches Medizinprodukt Typ A',
                'verordnung_id' => 2,
                'anforderung_type_id' => 1,
                'an_control_interval' => 1,
                'control_interval_id' => 8,
            ],
            [
                'an_name_kurz' => 'MedProdSK-B',
                'an_name_lang' => 'Semikritisches Medizinprodukt Typ B',
                'verordnung_id' => 2,
                'anforderung_type_id' => 1,
                'an_control_interval' => 1,
                'control_interval_id' => 8,
            ],
            [
                'an_name_kurz' => 'MedProdKR-A',
                'an_name_lang' => 'Kritisches Medizinprodukt Typ A',
                'verordnung_id' => 2,
                'anforderung_type_id' => 1,
                'an_control_interval' => 1,
                'control_interval_id' => 8,
            ],
            [
                'an_name_kurz' => 'MedProdKR-B',
                'an_name_lang' => 'Kritisches Medizinprodukt Typ B',
                'verordnung_id' => 2,
                'anforderung_type_id' => 1,
                'an_control_interval' => 1,
                'control_interval_id' => 8,
            ],
            [
                'an_name_kurz' => '9001-Cal',
                'an_name_lang' => 'Kalibrierung Prüfmittel',
                'verordnung_id' => 4,
                'anforderung_type_id' => 3,
                'an_control_interval' => 1,
                'control_interval_id' => 8,
            ],
        ]);

     /*   DB::table('anforderung_control_items')->insert([
            [
                'aci_name_kurz' => 'conL',
                'aci_name_lang' => 'Prüfung auf Durchgängigkeit',
                'aci_task' => 'Die Prüfung der Durchgängigkeit der Leiter und die Verbindung zu Körpern, falls zutreffend, muss dabei laut Unterabschnitt 6.4.3.2 durch eine Widerstandsmessung erfolgen. Dazu zählen:
                - Schutzleiter (einschließlich der Schutzpotenzialausgleichsleiter)
                - Körper
                - aktive Leiter ringförmiger Endstromkreise.',
                'aci_value_si' => '',
                'aci_vaule_soll' => 0,
                'aci_contact_id' => 1,
                'firma_id' => 1,
                'anforderung_id' => 1,
            ],
            [
                'aci_name_kurz' => 'Riso',
                'aci_name_lang' => 'Messung des Isolationswiderstand',
                'aci_task' => 'Isolationswiderstand zwischen a) aktiven Leitern und b) aktiven Leitern und dem mit der Erdungsanlage verbundenen Schutzleiter gemessen werden muss.Prüfung des Isolationswiderstand bei 500V. Dieser darf nicht unter 0,5MOhm betragen.',
                'aci_value_si' => 'MOhm',
                'aci_vaule_soll' => 0,
                'aci_contact_id' => 1,
                'firma_id' => 1,
                'anforderung_id' => 1,
            ],
        ]);*/


        DB::table('stellplatz_typs')->insert([
            [
                'spt_name_kurz' => 'Regalfach',
                'spt_name_lang' => 'Fach in einem Standardregal',
            ],
            [
                'spt_name_kurz' => 'Schubfach',
                'spt_name_lang' => 'Fach in einem Schubfachregal',
            ],
            [
                'spt_name_kurz' => 'Stellplaz',
                'spt_name_lang' => 'Aufstellplatz in einem Raum',
            ],
        ]);


        DB::table('document_types')->insert([
            [
                'doctyp_name_kurz' => 'Funktionstest',
                'doctyp_name_lang' => 'Funktionstest',
                'doctyp_mandatory' => '1',
            ],
            [
                'doctyp_name_kurz' => 'Anleitung',
                'doctyp_name_lang' => 'Betriebsanleitung',
                'doctyp_mandatory' => '1',
            ],
            [
                'doctyp_name_kurz' => 'Zeichnung',
                'doctyp_name_lang' => 'Technische Zeichnung',
                'doctyp_mandatory' => '0',
            ],
            [
                'doctyp_name_kurz' => 'Prüfbericht',
                'doctyp_name_lang' => 'Bericht über den Verlauf einer Geräteprüfung',
                'doctyp_mandatory' => '1',
            ],
            [
                'doctyp_name_kurz' => 'Verordnung',
                'doctyp_name_lang' => 'Verordnung zur Verwendung von Geräten',
                'doctyp_mandatory' => '1',
            ],
            [
                'doctyp_name_kurz' => 'Anforderung',
                'doctyp_name_lang' => 'Anforderung aus einer Verordnung',
                'doctyp_mandatory' => '1',
            ],
        ]);




        factory(App\Profile::class, 6)->create();
    }
}
