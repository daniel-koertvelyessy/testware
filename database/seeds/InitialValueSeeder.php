<?php

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class InitialValueSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         * @throws Exception
         */
        public function run()
        {

            DB::table('roles')->insert([
                [
                    'label'         => 'admin',
                    'name'          => 'Administrator',
                    'is_super_user' => true,
                ],
                [
                    'label'         => 'user',
                    'name'          => 'Benuter',
                    'is_super_user' => false,
                ],
                [
                    'label'         => 'revisor',
                    'name'          => 'Revisor',
                    'is_super_user' => false,
                ],
                [
                    'label'         => 'system',
                    'name'          => 'System',
                    'is_super_user' => true,
                ],
            ]);

            DB::table('lands')->insert([
                [
                    'land_iso'  => 'DE',
                    'land_lang' => 'Deutschland'
                ],
                [
                    'land_iso'  => 'AT',
                    'land_lang' => 'Österreich'
                ],
                [
                    'land_iso'  => 'BE',
                    'land_lang' => 'Belgien'
                ],
                [
                    'land_iso'  => 'FI',
                    'land_lang' => 'Finnland'
                ],
                [
                    'land_iso'  => 'DK',
                    'land_lang' => 'Dänemark'
                ],
                [
                    'land_iso'  => 'SK',
                    'land_lang' => 'Slowakei'
                ],
                [
                    'land_iso'  => 'NL',
                    'land_lang' => 'Niederlande'
                ],
                [
                    'land_iso'  => 'ES',
                    'land_lang' => 'Spanien'
                ],
                [
                    'land_iso'  => 'IE',
                    'land_lang' => 'Irland'
                ],
                [
                    'land_iso'  => 'IT',
                    'land_lang' => 'Italien'
                ],
                [
                    'land_iso'  => 'MK',
                    'land_lang' => 'Ehemalige Jugoslawische Republik Mazedonien'
                ],
                [
                    'land_iso'  => 'SE',
                    'land_lang' => 'Schweden'
                ],
                [
                    'land_iso'  => 'PL',
                    'land_lang' => 'Polen'
                ],
                [
                    'land_iso'  => 'VA',
                    'land_lang' => 'Vatikanstadt'
                ],
                [
                    'land_iso'  => 'CY',
                    'land_lang' => 'Zypern'
                ],
                [
                    'land_iso'  => 'FR',
                    'land_lang' => 'Frankreich'
                ],
                [
                    'land_iso'  => 'PT',
                    'land_lang' => 'Portugal'
                ],
                [
                    'land_iso'  => 'GR',
                    'land_lang' => 'Griechenland'
                ],
                [
                    'land_iso'  => 'RO',
                    'land_lang' => 'Rumänien'
                ],
                [
                    'land_iso'  => 'LU',
                    'land_lang' => 'Luxemburg'
                ],
                [
                    'land_iso'  => 'HU',
                    'land_lang' => 'Ungarn'
                ],
            ]);

            DB::table('address_types')->insert([
                [
                    'adt_name'      => 'Hausadresse',
                    'adt_text_lang' => 'Standard Adresse'
                ],
                [
                    'adt_name'      => 'RG-Adresse',
                    'adt_text_lang' => 'Rechnungsadresse'
                ],
                [
                    'adt_name'      => 'LS-Adresse',
                    'adt_text_lang' => 'Lieferadresse'
                ]
            ]);

            DB::table('anredes')->insert([
                [
                    'an_kurz'   => 'Hr',
                    'an_formal' => 'Herr',
                    'an_greet'  => 'Sehr geehrter Herr',
                ],
                [
                    'an_kurz'   => 'Fr',
                    'an_formal' => 'Frau',
                    'an_greet'  => 'Sehr geehrte Frau',
                ]
            ]);

            DB::table('control_intervals')->insert([
                [
                    'ci_label' => 'Sekunde',
                    'ci_name'  => 'Sekunden',
                    'ci_si'    => 's',
                    'ci_delta' => 'SECOND',
                ],
                [
                    'ci_label' => 'Minute',
                    'ci_name'  => 'Minuten',
                    'ci_si'    => 'min',
                    'ci_delta' => 'MINUTE',
                ],
                [
                    'ci_label' => 'Stunde',
                    'ci_name'  => 'Stunden',
                    'ci_si'    => 'h',
                    'ci_delta' => 'HOUR',
                ],
                [
                    'ci_label' => 'Tag',
                    'ci_name'  => 'Tage',
                    'ci_si'    => 'd',
                    'ci_delta' => 'DAY',
                ],
                [
                    'ci_label' => 'Woche',
                    'ci_name'  => 'Wochen',
                    'ci_si'    => 'w',
                    'ci_delta' => 'WEEK',
                ],
                [
                    'ci_label' => 'Monat',
                    'ci_name'  => 'Monate',
                    'ci_si'    => 'm',
                    'ci_delta' => 'MONTH',
                ],
                [
                    'ci_label' => 'Quartal',
                    'ci_name'  => 'Quartale',
                    'ci_si'    => '4m',
                    'ci_delta' => 'QUARTER',
                ],
                [
                    'ci_label' => 'Jahr',
                    'ci_name'  => 'Jahre',
                    'ci_si'    => 'Y',
                    'ci_delta' => 'YEAR',
                ],
            ]);

            DB::table('building_types')->insert([
                [
                    'btname'         => 'Büro',
                    'btbeschreibung' => 'Gebäude mit reiner Büronutzung'
                ],
                [
                    'btname'         => 'Werkstatt',
                    'btbeschreibung' => 'Gebäude mit reiner Werkstattnutzung'
                ],
                [
                    'btname'         => 'Lager',
                    'btbeschreibung' => 'Gebäude mit reiner Lagernutzung'
                ]
            ]);

            DB::table('report_types')->insert([
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'label'      => 'MGM',
                    'name'       => 'Berichte für die Leitung',
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'label'      => 'QMS',
                    'name'       => 'Berichte für das Qualitätsmanagement',
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'label'      => 'COM',
                    'name'       => 'Berichte zur testWare',
                ],

            ]);

            DB::table('room_types')->insert([
                [
                    'rt_label' => 'Büro',
                    'rt_name'  => 'Büroraum'
                ],
                [
                    'rt_label' => 'Montage',
                    'rt_name'  => 'Montageraum'
                ],
                [
                    'rt_label' => 'Abstell',
                    'rt_name'  => 'Abstellraum'
                ],
                [
                    'rt_label' => 'Material',
                    'rt_name'  => 'Materialraum'
                ],
                [
                    'rt_label' => 'EDV',
                    'rt_name'  => 'EDV-Raum'
                ],
                [
                    'rt_label' => 'Pausenraum',
                    'rt_name'  => 'Kaffee- / Pausenraum'
                ]
            ]);

            DB::table('produkt_states')->insert([
                [
                    'ps_label' => 'freigegeben',
                    'ps_name'  => 'Produkt kann verwendet werden',
                    'ps_color' => 'success',
                    'ps_icon'  => 'fas fa-check',
                ],
                [
                    'ps_label' => 'gesperrt',
                    'ps_name'  => 'Produkt ist gesperrt und darf nicht verwendet werden',
                    'ps_color' => 'danger',
                    'ps_icon'  => 'fas fa-exclamation',
                ]
            ]);

            DB::table('produkt_kategories')->insert([
                [
                    'pk_label'       => 'ohne',
                    'pk_name_nummer' => '-',
                    'pk_name'        => 'Keine Zuordnung'
                ],
                [
                    'pk_label'       => 'bm230',
                    'pk_name_nummer' => 'm230',
                    'pk_name'        => 'Betriebsmittel 230 VAC'
                ],
                [
                    'pk_label'       => 'edv230',
                    'pk_name_nummer' => 'e230',
                    'pk_name'        => 'Bürogeräte 230 VAC'
                ],

            ]);

            DB::table('equipment_states')->insert([
                [
                    'estat_label' => 'freigegeben',
                    'estat_name'  => 'Gerät kann verwendet werden',
                    'estat_color' => 'success',
                    'estat_icon'  => 'fas fa-check',
                ],
                [
                    'estat_label' => 'beschädigt',
                    'estat_name'  => 'Gerät ist beschädigt, kann aber verwendet werden',
                    'estat_color' => 'warning',
                    'estat_icon'  => 'fas fa-exclamation-circle',
                ],
                [
                    'estat_label' => 'reparatur',
                    'estat_name'  => 'Gerät wird repariert und kann nicht verwendet werden',
                    'estat_color' => 'warning',
                    'estat_icon'  => 'fas fa-exclamation-triangle',
                ],
                [
                    'estat_label' => 'gesperrt',
                    'estat_name'  => 'Gerät ist gesperrt und darf nicht verwendet werden',
                    'estat_color' => 'danger',
                    'estat_icon'  => 'fas fa-exclamation',
                ]
            ]);

            DB::table('verordnungs')->insert([
                [
                    'created_at'     => now(),
                    'updated_at'     => now(),
                    'vo_label'       => 'VDE 0701-0702',
                    'vo_nummer'      => 'DIN VDE 0701-0702',
                    'vo_stand'       => '2016',
                    'vo_name'        => 'Erst- / Prüfung von elektrischen Geräten',
                    'vo_description' => 'Errichten von Niederspannungsanlagen - Teil 6: Prüfungen (IEC 60364-6:2016); Deutsche Übernahme HD 60364-6:2016 + A11:2017',
                ],
                [
                    'created_at'     => now(),
                    'updated_at'     => now(),
                    'vo_label'       => 'MPBetreibV',
                    'vo_nummer'      => 'MPBetreibV-2018',
                    'vo_stand'       => '29.11.2018 I 2034',
                    'vo_name'        => 'Medizinprodukte-Betreiberverordnung',
                    'vo_description' => 'Verordnung über das Errichten, Betreiben und Anwenden von Medizinprodukten',
                ],
                [
                    'created_at'     => now(),
                    'updated_at'     => now(),
                    'vo_label'       => 'MPSV',
                    'vo_nummer'      => 'MPSV_2017',
                    'vo_stand'       => '01.1.2017',
                    'vo_name'        => 'Medizinprodukte-Sicherheitsplanverordnung',
                    'vo_description' => 'Verordnung über die Erfassung, Bewertung und Abwehr von Risiken bei Medizinprodukten',
                ],
                [
                    'created_at'     => now(),
                    'updated_at'     => now(),
                    'vo_label'       => 'iso9001',
                    'vo_nummer'      => '9001:2015',
                    'vo_stand'       => '2015',
                    'vo_name'        => 'Qualitätsmanagementsysteme –Anforderungen',
                    'vo_description' => 'Die Einführung eines Qualitätsmanagementsystems ist eine strategische Entscheidung einer Organisation, die helfen kann, ihre Gesamtleistung zu steigern und eine gute Basis für nachhaltige
Entwicklungsinitiativen bereitstellt.',
                ],

            ]);

            DB::table('anforderung_types')->insert([
                [
                    'at_label'       => 'control',
                    'at_name'        => 'Prüfung',
                    'at_description' => 'Überprüfung eines Gerätes entsprechend den Vorgaben. Beispiel eine Aufnahme eines Kontrollwertes oder eine visuelle Prüfung',
                ],
                [
                    'at_label'       => 'wartung',
                    'at_name'        => 'Wartung',
                    'at_description' => 'Die regelmäßige Wartung von Geräten ermöglicht deren sicheren Gebrauch.',
                ],
                [
                    'at_label'       => 'kalibrierung',
                    'at_name'        => 'Kalibrierung',
                    'at_description' => 'Die regelmäßige Kalibrierung von Geräten ermöglicht eine genaue Bewertung der Messergebnisse.',
                ],


            ]);

            DB::table('anforderungs')->insert([
                [
                    'created_at'          => now(),
                    'updated_at'          => now(),
                    'an_label'            => 'VDE Klasse 1',
                    'an_name'             => 'Einstufung VDE Schutzklasse 1',
                    'verordnung_id'       => 1,
                    'anforderung_type_id' => 1,
                    'an_control_interval' => 1,
                    'control_interval_id' => 8,
                ],
                [
                    'created_at'          => now(),
                    'updated_at'          => now(),
                    'an_label'            => 'VDE Klasse 2',
                    'an_name'             => 'Einstufung VDE Schutzklasse 2',
                    'verordnung_id'       => 1,
                    'anforderung_type_id' => 1,
                    'an_control_interval' => 1,
                    'control_interval_id' => 8,
                ],
                [
                    'created_at'          => now(),
                    'updated_at'          => now(),
                    'an_label'            => 'VDE Klasse 3',
                    'an_name'             => 'Einstufung VDE Schutzklasse 3',
                    'verordnung_id'       => 1,
                    'anforderung_type_id' => 1,
                    'an_control_interval' => 1,
                    'control_interval_id' => 8,
                ],
                [
                    'created_at'          => now(),
                    'updated_at'          => now(),
                    'an_label'            => 'VDE Leitungen',
                    'an_name'             => 'Einstufung VDE Schutzklasse Leitungen',
                    'verordnung_id'       => 1,
                    'anforderung_type_id' => 1,
                    'an_control_interval' => 1,
                    'control_interval_id' => 8,
                ],

            ]);

            DB::table('anforderung_control_items')->insert([
                [
                    'created_at'                     => now(),
                    'updated_at'                     => now(),
                    'aci_label'                      => 'vde1_sicht_gehaeuse',
                    'aci_name'                       => 'Sichtprüfung Gehäuse',
                    'aci_task'                       => 'Ist das gehäuse und evtl. mechanische Teile unbeschädugt.',
                    'aci_sort'                       => 5,
                    'aci_value_target_mode'          => null,
                    'aci_control_equipment_required' => 0,
                    'aci_value_si'                   => null,
                    'aci_execution'                  => 0,
                    'aci_vaule_soll'                 => null,
                    'aci_contact_id'                 => null,
                    'firma_id'                       => null,
                    'anforderung_id'                 => 1,
                ],
                [
                    'created_at'                     => now(),
                    'updated_at'                     => now(),
                    'aci_label'                      => 'vde1_sicht_isolierun',
                    'aci_name'                       => 'Sichtprüfung Leitungen',
                    'aci_task'                       => 'Isolierte Leitungen mängelfrei',
                    'aci_value_target_mode'          => null,
                    'aci_sort'                       => 10,
                    'aci_control_equipment_required' => 0,
                    'aci_value_si'                   => null,
                    'aci_execution'                  => 0,
                    'aci_vaule_soll'                 => null,
                    'aci_contact_id'                 => null,
                    'firma_id'                       => null,
                    'anforderung_id'                 => 1,
                ],
                [
                    'created_at'                     => now(),
                    'updated_at'                     => now(),
                    'aci_label'                      => 'vde1_sicht_typschild',
                    'aci_name'                       => 'Sichtprüfung Aufschriften',
                    'aci_task'                       => 'Sind Typenschilder korrekt, Aufschriften vorhanden bzw. vollständig.',
                    'aci_value_target_mode'          => null,
                    'aci_control_equipment_required' => 0,
                    'aci_sort'                       => 15,
                    'aci_value_si'                   => null,
                    'aci_execution'                  => 0,
                    'aci_vaule_soll'                 => null,
                    'aci_contact_id'                 => null,
                    'firma_id'                       => null,
                    'anforderung_id'                 => 1,
                ],
                [
                    'created_at'                     => now(),
                    'updated_at'                     => now(),
                    'aci_label'                      => 'vde1_conL',
                    'aci_name'                       => 'Prüfung auf Durchgängigkeit',
                    'aci_task'                       => 'Die Prüfung der Durchgängigkeit der Leiter und die Verbindung zu Körpern, falls zutreffend, muss dabei laut Unterabschnitt 6.4.3.2 durch eine Widerstandsmessung erfolgen. Dazu zählen:
                    - Schutzleiter (einschließlich der Schutzpotenzialausgleichsleiter)
                    - Körper
                    - aktive Leiter ringförmiger Endstromkreise.',
                    'aci_value_target_mode'          => null,
                    'aci_sort'                       => 20,
                    'aci_control_equipment_required' => 0,
                    'aci_value_si'                   => null,
                    'aci_execution'                  => 0,
                    'aci_vaule_soll'                 => null,
                    'aci_contact_id'                 => null,
                    'firma_id'                       => null,
                    'anforderung_id'                 => 1,
                ],
                [
                    'created_at'                     => now(),
                    'updated_at'                     => now(),
                    'aci_label'                      => 'vde1_Riso',
                    'aci_name'                       => 'Messung des Isolationswiderstand',
                    'aci_task'                       => 'Isolationswiderstand zwischen a) aktiven Leitern und b) aktiven Leitern und dem mit der Erdungsanlage verbundenen Schutzleiter gemessen werden muss.Prüfung des Isolationswiderstand bei 500V. Dieser darf nicht unter 0,5MOhm betragen.',
                    'aci_value_si'                   => 'MOhm',
                    'aci_execution'                  => 0,
                    'aci_value_target_mode'          => 'gt',
                    'aci_sort'                       => 25,
                    'aci_control_equipment_required' => 1,
                    'aci_vaule_soll'                 => 0.5,
                    'aci_contact_id'                 => null,
                    'firma_id'                       => null,
                    'anforderung_id'                 => 1,
                ],
                [
                    'created_at'                     => now(),
                    'updated_at'                     => now(),
                    'aci_label'                      => 'vde2_sicht_gehaeuse',
                    'aci_name'                       => 'Sichtprüfung Gehäuse',
                    'aci_task'                       => 'Ist das gehäuse und evtl. mechanische Teile unbeschädugt.',
                    'aci_value_target_mode'          => null,
                    'aci_control_equipment_required' => 0,
                    'aci_sort'                       => 5,
                    'aci_value_si'                   => null,
                    'aci_execution'                  => 0,
                    'aci_vaule_soll'                 => null,
                    'aci_contact_id'                 => null,
                    'firma_id'                       => null,
                    'anforderung_id'                 => 2,
                ],
                [
                    'created_at'                     => now(),
                    'updated_at'                     => now(),
                    'aci_label'                      => 'vde2_sicht_isolierun',
                    'aci_name'                       => 'Sichtprüfung Leitungen',
                    'aci_task'                       => 'Isolierte Leitungen mängelfrei',
                    'aci_value_target_mode'          => null,
                    'aci_control_equipment_required' => 0,
                    'aci_sort'                       => 10,
                    'aci_value_si'                   => null,
                    'aci_execution'                  => 0,
                    'aci_vaule_soll'                 => null,
                    'aci_contact_id'                 => null,
                    'firma_id'                       => null,
                    'anforderung_id'                 => 2,
                ],
                [
                    'created_at'                     => now(),
                    'updated_at'                     => now(),
                    'aci_label'                      => 'vde2_sicht_typschild',
                    'aci_name'                       => 'Sichtprüfung Aufschriften',
                    'aci_task'                       => 'Sind Typenschilder korrekt, Aufschriften vorhanden bzw. vollständig.',
                    'aci_value_target_mode'          => null,
                    'aci_control_equipment_required' => 0,
                    'aci_sort'                       => 15,
                    'aci_value_si'                   => null,
                    'aci_execution'                  => 0,
                    'aci_vaule_soll'                 => null,
                    'aci_contact_id'                 => null,
                    'firma_id'                       => null,
                    'anforderung_id'                 => 2,
                ],
                [
                    'created_at'                     => now(),
                    'updated_at'                     => now(),
                    'aci_label'                      => 'vde2_conL',
                    'aci_name'                       => 'Prüfung auf Durchgängigkeit',
                    'aci_task'                       => 'Die Prüfung der Durchgängigkeit der Leiter und die Verbindung zu Körpern, falls zutreffend, muss dabei laut Unterabschnitt 6.4.3.2 durch eine Widerstandsmessung erfolgen. Dazu zählen:
                    - Schutzleiter (einschließlich der Schutzpotenzialausgleichsleiter)
                    - Körper
                    - aktive Leiter ringförmiger Endstromkreise.',
                    'aci_value_target_mode'          => null,
                    'aci_control_equipment_required' => 0,
                    'aci_sort'                       => 20,
                    'aci_value_si'                   => null,
                    'aci_execution'                  => 0,
                    'aci_vaule_soll'                 => null,
                    'aci_contact_id'                 => null,
                    'firma_id'                       => null,
                    'anforderung_id'                 => 2,
                ],
                [
                    'created_at'                     => now(),
                    'updated_at'                     => now(),
                    'aci_label'                      => 'vde3_conL',
                    'aci_name'                       => 'Prüfung auf Durchgängigkeit',
                    'aci_task'                       => 'Die Prüfung der Durchgängigkeit der Leiter und die Verbindung zu Körpern, falls zutreffend, muss dabei laut Unterabschnitt 6.4.3.2 durch eine Widerstandsmessung erfolgen. Dazu zählen:
                    - Schutzleiter (einschließlich der Schutzpotenzialausgleichsleiter)
                    - Körper
                    - aktive Leiter ringförmiger Endstromkreise.',
                    'aci_value_target_mode'          => null,
                    'aci_control_equipment_required' => 0,
                    'aci_sort'                       => 5,
                    'aci_value_si'                   => null,
                    'aci_execution'                  => 0,
                    'aci_vaule_soll'                 => null,
                    'aci_contact_id'                 => null,
                    'firma_id'                       => null,
                    'anforderung_id'                 => 3,
                ],
                [
                    'created_at'                     => now(),
                    'updated_at'                     => now(),
                    'aci_label'                      => 'vdeL_conL',
                    'aci_name'                       => 'Prüfung auf Durchgängigkeit',
                    'aci_task'                       => 'Die Prüfung der Durchgängigkeit der Leiter und die Verbindung zu Körpern, falls zutreffend, muss dabei laut Unterabschnitt 6.4.3.2 durch eine Widerstandsmessung erfolgen. Dazu zählen:
                    - Schutzleiter (einschließlich der Schutzpotenzialausgleichsleiter)
                    - Körper
                    - aktive Leiter ringförmiger Endstromkreise.',
                    'aci_value_target_mode'          => null,
                    'aci_control_equipment_required' => 0,
                    'aci_sort'                       => 5,
                    'aci_value_si'                   => null,
                    'aci_execution'                  => 0,
                    'aci_vaule_soll'                 => null,
                    'aci_contact_id'                 => null,
                    'firma_id'                       => null,
                    'anforderung_id'                 => 4,
                ],
            ]);
            /* */
            DB::table('stellplatz_typs')->insert([
                [
                    'spt_label' => 'Regalfach',
                    'spt_name'  => 'Fach in einem Standardregal',
                ],
                [
                    'spt_label' => 'Schubfach',
                    'spt_name'  => 'Fach in einem Schubfachregal',
                ],
                [
                    'spt_label' => 'Stellplaz',
                    'spt_name'  => 'Aufstellplatz in einem Raum',
                ],
                [
                    'spt_label' => 'AP Büro',
                    'spt_name'  => 'Arbeitsplatz mit Schreibtisch und Container',
                ],
                [
                    'spt_label' => 'AP Werkstatt',
                    'spt_name'  => 'Arbeitsplatz mit fest montierten Geräten',
                ],
                [
                    'spt_label' => 'AP Werkstatt mob',
                    'spt_name'  => 'Arbeitsplatz mit mobilen Geräten',
                ],

            ]);

            DB::table('document_types')->insert([
                [
                    'doctyp_label'     => 'Anleitung',
                    'doctyp_name'      => 'Betriebsanleitung',
                    'doctyp_mandatory' => '1',
                ],
                [
                    'doctyp_label'     => 'Funktionstest',
                    'doctyp_name'      => 'Funktionstest',
                    'doctyp_mandatory' => '1',
                ],
                [
                    'doctyp_label'     => 'Prüfbericht',
                    'doctyp_name'      => 'Bericht über den Verlauf einer Geräteprüfung',
                    'doctyp_mandatory' => '0',
                ],
                [
                    'doctyp_label'     => 'Zeichnung',
                    'doctyp_name'      => 'Technische Zeichnung',
                    'doctyp_mandatory' => '0',
                ],
                [
                    'doctyp_label'     => 'Verordnung',
                    'doctyp_name'      => 'Verordnung zur Verwendung von Geräten',
                    'doctyp_mandatory' => '1',
                ],
                [
                    'doctyp_label'     => 'Anforderung',
                    'doctyp_name'      => 'Anforderung aus einer Verordnung',
                    'doctyp_mandatory' => '1',
                ],
            ]);

        }
    }
