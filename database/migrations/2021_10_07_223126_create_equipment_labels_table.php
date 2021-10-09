<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_labels', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('label',20);
            $table->string('name',100)->nullable();
            $table->boolean('show_labels')->default(true);
            $table->boolean('show_inventory')->default(true);
            $table->boolean('show_location')->default(true);
            $table->integer('label_w')->nullable();
            $table->integer('Label_h')->nullable();
            $table->integer('label_ml')->nullable();
            $table->integer('label_mt')->nullable();
            $table->integer('label_mr')->nullable()->default(1);
            $table->integer('qrcode_y')->nullable();
            $table->integer('qrcode_x')->nullable();
            $table->integer('logo_y')->nullable();
            $table->integer('logo_x')->nullable();
            $table->integer('logo_h')->nullable();
            $table->integer('logo_w')->nullable();
            $table->text('logo_svg')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_labels');
    }
}
