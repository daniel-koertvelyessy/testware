<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class AddWarnintervalToAnforderungsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
          Schema::table('anforderungs', function (Blueprint $table)
            {
                $table->unsignedSmallInteger('an_date_warn')->nullable()->default(4);
                $table->foreignId('control_interval_id')
                    ->nullable()
                    ->default('5')
                    ->constrained()
                    ->onDelete('set null')
                    ->onUpdate('cascade');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
           Schema::table('anforderungs', function (Blueprint $table)
            {
                $table->dropColumn([
                    'control_interval_id',
                    'an_date_warn'
                ]);
            });
        }
    }
