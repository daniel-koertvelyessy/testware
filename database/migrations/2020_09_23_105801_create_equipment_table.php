<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->timestamps();
            $table->string('eq_name_lang',100)->nullable();
            $table->string('eq_inventar_nr')->unique();
            $table->string('eq_serien_nr')->unique()->nullable();
            $table->string('eq_qrcode')->unique()->nullable();
            $table->date('eq_ibm')->nullable();
            $table->text('eq_text')->nullable();
            $table->decimal('eq_price',10,2)->nullable();
            $table->uuid('eq_uid');
            $table->foreignId('equipment_state_id')
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('produkt_id')
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('standort_id')
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

    }




    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment');
    }
}
