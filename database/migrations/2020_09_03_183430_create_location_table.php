<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('l_benutzt')->nullable();
            $table->string('l_name_kurz', 20);
            $table->string('l_name_lang', 100)->nullable();
            $table->text('l_beschreibung')->nullable();
            $table->unsignedBigInteger('addresses_id')->nullable();
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->foreign('addresses_id')->references('id')->on('addresses')->onDelete('set null');
            $table->uuid('standort_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
