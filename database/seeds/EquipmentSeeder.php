<?php

    use App\ControlEquipment;
    use App\ControlEvent;
    use App\ControlEventItem;
    use App\Equipment;
    use App\EquipmentFuntionControl;
    use App\EquipmentHistory;
    use App\EquipmentQualifiedUser;
    use App\EquipmentUid;
    use App\Produkt;
    use App\ProduktDoc;
    use Illuminate\Database\Seeder;


    class EquipmentSeeder extends Seeder
    {

        /**
         * @param Produkt $produkt
         * @param string $name
         * @param string $invid
         * @param string $serial
         * @param int $storageid
         * @return Equipment
         */
        public function addEquipment(Produkt $produkt, string $name, string $invid, int $storageid = 4): Equipment
        {
            return Equipment::create([
                'purchased_at'       => now()->subDays(4),
                'installed_at'       => now(),
                'eq_inventar_nr'     => $invid,
                'eq_serien_nr'       => $this->makeSerial(),
                'eq_uid'             => \Illuminate\Support\Str::uuid(),
                'eq_name'            => $name ?? $produkt->prod_name,
                'eq_price'           => $produkt->prod_price,
                'equipment_state_id' => 1,
                'produkt_id'         => $produkt->id,
                'storage_id'         => $storageid,

            ]);
        }

        /**
         * @param Equipment $equipment
         * @param String $header
         * @param String $text
         * @return void
         */
        public function addEquipHistory(Equipment $equipment, String $header, String $text)
        {
            EquipmentHistory::create([
                'eqh_eintrag_kurz' => $header,
                'eqh_eintrag_text' => $text,
                'equipment_id' => $equipment->id,
            ]);
        }

        public function addEquipmentUUid(Equipment $equipment): EquipmentUid
        {
            return EquipmentUid::create([
                'equipment_uid' => $equipment->eq_uid,
                'equipment_id'  => $equipment->id,
            ]);
        }

        public function addEquipmentFunktionControl(Equipment $equipment): EquipmentFuntionControl
        {
            return EquipmentFuntionControl::create([
                'controlled_at'           => now(),
                'function_control_firma'  => NULL,
                'function_control_profil' => $equipment->qualifiedUserList($equipment)[0]->id,
                'function_control_pass'   => true,
                'function_control_text'   => NULL,
                'equipment_id'            => $equipment->id,
            ]);
        }

        public function addControlEventItems(Equipment $equipment, ControlEvent $controlEvent,Int $aci, $read = NULL): ControlEventItem
        {
            return ControlEventItem::create([
                'control_item_aci'  => $aci,
                'control_item_read' => $read,
                'control_item_pass' => true,
                'equipment_id'      => $equipment->id,
                'control_event_id'  => $controlEvent->id,
            ]);
        }

        public function addControl(Equipment $equipment): ControlEquipment
        {
            return ControlEquipment::create([
                'qe_control_date_last' => now(),
                'qe_control_date_due'  => now()->addYear(),
                'qe_control_date_warn' => 3,
                'anforderung_id'       => $equipment->produkt->ProduktAnforderung->first()->anforderung_id,
                'equipment_id'         => $equipment->id,

            ]);
        }

        public function addControlEvent(Equipment $equipment, ControlEquipment $controlEquipment): ControlEvent
        {
            $user = $equipment->qualifiedUserList($equipment)[0];
            return ControlEvent::create([
                'control_event_date'                 => now(),
                'control_event_next_due_date'        => now()->addYear(),
                'control_event_pass'                 => true,
                'control_event_controller_signature' => $user->signature,
                'control_event_controller_name'      => $user->profile->fullname(),
                'user_id'                            => $user->id,
                'control_equipment_id'               => $controlEquipment->id
            ]);
        }

        public function addOldControl(Equipment $equipment): ControlEquipment
        {
            return ControlEquipment::create([
                'deleted_at'           => now()->subWeeks(2),
                'qe_control_date_last' => now()->subWeeks(2),
                'qe_control_date_due'  => now()->addYear(),
                'qe_control_date_warn' => 3,
                'anforderung_id'       => $equipment->produkt->ProduktAnforderung->first()->anforderung_id,
                'equipment_id'         => $equipment->id,

            ]);
        }

        public function makeSerial(): string
        {
            return Str::limit(\Illuminate\Support\Str::uuid(), 10);
        }

        public function addQualifiedUser(Equipment $equipment): EquipmentQualifiedUser
        {
            return EquipmentQualifiedUser::create([
                'equipment_qualified_firma' => $equipment->produkt->firma->first()->id,
                'equipment_qualified_date'  => now()->subDays(2),
                'user_id'                   => 1,
                'equipment_id'              => $equipment->id,
            ]);
        }

        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {

            /**
             *
             *
             *    Zuerst Produkte erstellen, aus denen Geräte abgeleitet werden
             *
             *
             */


            $workstation = Produkt::create([
                'prod_label'           => 'op-3000m',
                'prod_name'            => 'OptiPlex 3000 Micro',
                'prod_nummer'          => 's012o3000mff_vp',
                'prod_active'          => 1,
                'prod_price'           => 617.67,
                'produkt_kategorie_id' => 3,
                // Bürogeräte 230 VAC
                'produkt_state_id'     => 1,
                // freigegeben
                'prod_uuid'            => \Illuminate\Support\Str::uuid(),
            ]);

            \App\ProduktAnforderung::create([
                'produkt_id'     => $workstation->id,
                'anforderung_id' => 1,
            ]);

            \App\FirmaProdukt::create([
                'firma_id'   => 1,
                'produkt_id' => $workstation->id,
            ]);

            \App\ProductQualifiedUser::create([
                'produkt_id'              => $workstation->id,
                'user_id'                 => 1,
                'product_qualified_date'  => now()->subMonth(),
                'product_qualified_firma' => 1
            ]);


            $monitor_27 = Produkt::create([
                'prod_label'           => 'P2722HE',
                'prod_name'            => 'Dell 27-USB-C-Hub-Monitor',
                'prod_nummer'          => 'P2722he',
                'prod_active'          => 1,
                'prod_price'           => 312.67,
                'produkt_kategorie_id' => 3,
                // Bürogeräte 230 VAC
                'produkt_state_id'     => 1,
                // freigegeben
                'prod_uuid'            => \Illuminate\Support\Str::uuid(),
                'equipment_label_id' => 1

            ]);

  /*          ProduktDoc::create([
                'proddoc_label'     => 'HB_P2722HE',
                'proddoc_name'      => 'acessaData_logo_sw-rd.pdf',
                'proddoc_name_pfad' => 'product_files/' . $monitor_27->id . '/62jXwBRkghvy4fDpv5LvCQxpxXZZdmtpMSdUwuNL.pdf',
                'produkt_id'        => $monitor_27->id,
                'document_type_id'  => 1,
            ]);*/

            \App\ProduktAnforderung::create([
                'produkt_id'     => $monitor_27->id,
                'anforderung_id' => 1,
            ]);

            \App\FirmaProdukt::create([
                'firma_id'   => 1,
                'produkt_id' => $monitor_27->id,
            ]);

            \App\ProductQualifiedUser::create([
                'produkt_id'              => $monitor_27->id,
                'user_id'                 => 1,
                'product_qualified_date'  => now()->subMonth(),
                'product_qualified_firma' => 1
            ]);

            $mauskeyboard = Produkt::create([
                'prod_label'           => 'KM5221W',
                'prod_name'            => 'Dell Pro-Wireless-Tastatur und -Maus - KM5221W - deutsch',
                'prod_nummer'          => '580-Ajrd',
                'prod_active'          => 1,
                'prod_price'           => 51.40,
                'produkt_kategorie_id' => 1,
                // ohne
                'produkt_state_id'     => 1,
                // freigegeben
                'prod_uuid'            => \Illuminate\Support\Str::uuid(),
                'equipment_label_id' => 1

            ]);

            \App\ProduktAnforderung::create([
                'produkt_id'     => $mauskeyboard->id,
                'anforderung_id' => 3,
            ]);

            \App\FirmaProdukt::create([
                'firma_id'   => 1,
                'produkt_id' => $mauskeyboard->id,
            ]);

            \App\ProductQualifiedUser::create([
                'produkt_id'              => $mauskeyboard->id,
                'user_id'                 => 1,
                'product_qualified_date'  => now()->subMonth(),
                'product_qualified_firma' => 1
            ]);

            $siptelefon = Produkt::create([
                'prod_label'           => 'YL-SIP-T42U',
                'prod_name'            => 'Yealink SIP-T42U',
                'prod_nummer'          => '5A24-01A',
                'prod_active'          => 1,
                'prod_price'           => 90.90,
                'produkt_kategorie_id' => 1,
                // ohne
                'produkt_state_id'     => 1,
                // freigegeben
                'prod_uuid'            => \Illuminate\Support\Str::uuid(),
                'equipment_label_id' => 1

            ]);

            \App\ProduktAnforderung::create([
                'produkt_id'     => $siptelefon->id,
                'anforderung_id' => 3,
            ]);

            \App\FirmaProdukt::create([
                'firma_id'   => 1,
                'produkt_id' => $siptelefon->id,
            ]);

            \App\ProductQualifiedUser::create([
                'produkt_id'              => $siptelefon->id,
                'user_id'                 => 1,
                'product_qualified_date'  => now()->subMonth(),
                'product_qualified_firma' => 1
            ]);

            $flukeTester = Produkt::create([
                'prod_label'           => 'Fluke-6500-2',
                'prod_name'            => 'Gerätetester Fluke 6500-2',
                'prod_nummer'          => 'F6500-2',
                'prod_active'          => 1,
                'prod_price'           => 903.90,
                'produkt_kategorie_id' => 1,
                // ohne
                'produkt_state_id'     => 1,
                // freigegeben
                'prod_uuid'            => \Illuminate\Support\Str::uuid(),
                'equipment_label_id' => 1
            ]);

            \App\ControlProdukt::create(['produkt_id' => $flukeTester->id]);

            \App\ProduktAnforderung::create([
                'produkt_id'     => $flukeTester->id,
                'anforderung_id' => 3,
            ]);

            \App\FirmaProdukt::create([
                'firma_id'   => 2,
                'produkt_id' => $flukeTester->id,
            ]);

            \App\ProductQualifiedUser::create([
                'produkt_id'              => $flukeTester->id,
                'user_id'                 => 1,
                'product_qualified_date'  => now()->subMonth(),
                'product_qualified_firma' => 2
            ]);


            /**
             *
             *   Jetzt ein paar Geräte ableiten
             *
             */
            $workstationEmpfang = $this->addEquipment($workstation, $workstation->prod_name . ' Empfang', 'BM.1.001');
            $monitorEmpfang = $this->addEquipment($monitor_27, $monitor_27->prod_name . ' Empfang', 'BM.1.002');
            $siptelefonEmpfang = $this->addEquipment($siptelefon, $siptelefon->prod_name . ' Empfang', 'BM.1.003');


            $workstationBuroI = $this->addEquipment($workstation, $workstation->prod_name . ' Büro AP 1', 'BM.1.004');
            $monitorBuroI = $this->addEquipment($monitor_27, $monitor_27->prod_name . ' Büro AP 1', 'BM.1.005');
            $siptelefonBuroI = $this->addEquipment($siptelefon, $siptelefon->prod_name . ' Büro AP 1', 'BM.1.006');

            $workstationBuroII = $this->addEquipment($workstation, $workstation->prod_name . ' Büro AP 2', 'BM.1.007');
            $monitorBuroII = $this->addEquipment($monitor_27, $monitor_27->prod_name . ' Büro AP 2', 'BM.1.008');
            $siptelefonBuroII = $this->addEquipment($siptelefon, $siptelefon->prod_name . ' Büro AP 2', 'BM.1.009');

            $workstationBuroIII = $this->addEquipment($workstation, $workstation->prod_name . ' Büro AP 3', 'BM.1.010');
            $monitorBuroIII = $this->addEquipment($monitor_27, $monitor_27->prod_name . ' Büro AP 3', 'BM.1.011');
            $siptelefonBuroIII = $this->addEquipment($siptelefon, $siptelefon->prod_name . ' Büro AP 3', 'BM.1.012');

            $workstationBuroIV = $this->addEquipment($workstation, $workstation->prod_name . ' Büro AP 4', 'BM.1.013');
            $monitorBuroIV = $this->addEquipment($monitor_27, $monitor_27->prod_name . ' Büro AP 4', 'BM.1.014');
            $siptelefonBuroIV = $this->addEquipment($siptelefon, $siptelefon->prod_name . ' Büro AP 4', 'BM.1.015');


            $pruefgeraet = $this->addEquipment($flukeTester, $flukeTester->prod_name, 'BM.3.0012');


            $geraete = [
                $workstationEmpfang,
                $monitorEmpfang,
                $siptelefonEmpfang,
                $pruefgeraet,
                $workstationBuroI,
                $monitorBuroI,
                $siptelefonBuroI,
                $workstationBuroII,
                $monitorBuroII,
                $siptelefonBuroII,
                $workstationBuroIII,
                $monitorBuroIII,
                $siptelefonBuroIII,
                $workstationBuroIV,
                $monitorBuroIV,
                $siptelefonBuroIV,
            ];


            foreach ($geraete as $greaet) {

                $this->addEquipHistory($greaet, 'Gerät angelegt', 'Das Gerät wurde vom System als Demogerät angelegt');

                $this->addQualifiedUser($greaet);
                $this->addEquipHistory($greaet, 'Befähigte Person hinzugefügt', 'Es wurde der Benutzer Demo User als befähigte Person angelegt.');

                $this->addEquipmentUUid($greaet);
                $this->addEquipmentFunktionControl($greaet);
                $this->addEquipHistory($greaet, 'Funktionsprüfung', 'Die Funktionsprüfung ist erfolgreich durchgeführt worden.');

                $control = $this->addOldControl($greaet);
                $nextControl = $this->addControl($greaet);

                $this->addEquipHistory($greaet, 'Prüfung erfolgt', 'Am '. $control->deleted_at . ' wurde das Gerät erfolgreich geprüft. Als neuer Prüftermin wurder der ' . $nextControl->qe_control_date_due . ' festgesetzt.');

                $controlEvent = $this->addControlEvent($greaet, $control);
                $this->addControlEventItems($greaet, $controlEvent, 1);
                $this->addControlEventItems($greaet, $controlEvent, 2);
                $this->addControlEventItems($greaet, $controlEvent, 3);
                $this->addControlEventItems($greaet, $controlEvent, 4);
                $this->addControlEventItems($greaet, $controlEvent, 5, 2.1);

            }


        }


    }
