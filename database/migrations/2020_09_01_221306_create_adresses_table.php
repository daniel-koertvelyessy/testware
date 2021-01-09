<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adresses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('ad_label', 20)->unique();
            $table->string('ad_name', 100)->nullable();
            $table->string('ad_name_firma', 100)->nullable();
            $table->string('ad_name_firma_2', 100)->nullable();
            $table->string('ad_name_firma_co', 100)->nullable();
            $table->string('ad_name_firma_abladestelle', 100)->nullable();
            $table->string('ad_name_firma_wareneingang', 100)->nullable();
            $table->string('ad_name_firma_abteilung', 100)->nullable();
            $table->string('ad_anschrift_strasse', 100);
            $table->string('ad_anschrift_hausnummer', 100)->nullable();
            $table->string('ad_anschrift_etage', 100)->nullable();
            $table->string('ad_anschrift_eingang', 100)->nullable();
            $table->string('ad_anschrift_plz', 100);
            $table->string('ad_anschrift_ort', 100);

            $table->unsignedBigInteger('address_type_id')->nullable()->default('1');
            $table->unsignedBigInteger('land_id')->nullable()->default('1');

            $table->foreign('address_type_id')
                ->references('id')
                ->on('address_types')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('land_id')
                ->references('id')
                ->on('lands')
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
        Schema::dropIfExists('adresses');
    }
}
