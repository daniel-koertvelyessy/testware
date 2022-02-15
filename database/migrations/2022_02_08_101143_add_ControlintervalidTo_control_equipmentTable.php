<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class AddControlintervalidToControlEquipmentTable extends Migration
    {
        /**
         *
         *   Added for 1.66
         *
         *   tasks:
         *    -change col qe_control_date_warn from json to unsignedSmallInteger
         *   - add control_interval_id foreign key col with default val
         *     of 5 => 'weeks'
         *
         *
         *
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {

            /**
             * Collect existing data
             */
            foreach(\App\ControlEquipment::all() as $controlEquipmentItem){
                $qe_control_date_warn[$controlEquipmentItem->id] = $controlEquipmentItem->qe_control_date_warn;
            }

            /**
             *  Change table
             */
            Schema::table('control_equipment', function (Blueprint $table)
            {
                $table->dropColumn('qe_control_date_warn');
                $table->foreignId('control_interval_id')
                    ->nullable()
                    ->default('5')
                    ->constrained()
                    ->onDelete('set null')
                    ->onUpdate('cascade');

            });

            Schema::table('control_equipment', function (Blueprint $table)
            {
                $table->unsignedSmallInteger('qe_control_date_warn')->nullable()->default(4);
            });

            /**
             *
             *  Polulate column data
             *
             * if a new dataset is found or empty, add default value of (int) 4
             *
             */
            foreach(\App\ControlEquipment::all() as $controlEquipmentItem){
                $id = $controlEquipmentItem->id;
                $controlEquipmentItem->qe_control_date_warn = $qe_control_date_warn[$id] ?? 4;
                $controlEquipmentItem->save();
            }


        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            /**
             * Collect existing data
             */
            foreach(\App\ControlEquipment::all() as $controlEquipmentItem){
                $qe_control_date_warn[$controlEquipmentItem->id] = $controlEquipmentItem->qe_control_date_warn;
            }

            Schema::table('control_equipment', function (Blueprint $table)
            {
                $table->dropColumn('qe_control_date_warn');
                $table->dropColumn('control_interval_id');
            });

            Schema::table('control_equipment', function (Blueprint $table)
            {
                $table->json('qe_control_date_warn')->nullable()->default(4);
            });
            /**
             *
             *  Polulate column data
             *
             * if a new dataset is found or empty, add default value of (int) 4
             *
             */
            foreach(\App\ControlEquipment::all() as $controlEquipmentItem){
                $id = $controlEquipmentItem->id;
                $controlEquipmentItem->qe_control_date_warn = $qe_control_date_warn[$id] ?? 4;
                $controlEquipmentItem->save();
            }

        }
    }
