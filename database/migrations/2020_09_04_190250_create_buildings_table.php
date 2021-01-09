<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('b_label', 20)->unique();
            $table->string('b_name_ort', 100)->nullable();
            $table->string('b_name', 100)->nullable();
            $table->text('b_name_text')->nullable();
            $table->boolean('b_we_has')->default(false);
            $table->string('b_we_name', 100)->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('building_type_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
            $table->foreign('building_type_id')->references('id')->on('building_types')->onDelete('set null');
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
        Schema::dropIfExists('buildings');
    }
}
