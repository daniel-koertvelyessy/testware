<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnforderungControlItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anforderung_control_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('aci_name_kurz', 20)->unique();
            $table->string('aci_name_lang', 150);
            $table->text('aci_task')->nullable();
            $table->string('aci_value_si',10)->nullable(); // SI Einheit [°C] [A] [V]
            $table->decimal('aci_vaule_soll')->nullable();
            $table->string('aci_value_target_mode',3)->nullable();
            $table->decimal('aci_value_tol')->nullable();
            $table->string('aci_value_tol_mod',3)->nullable();
            $table->boolean('aci_execution')->nullable();
            $table->boolean('aci_control_equipment_required')->nullable();
            $table->foreignId('aci_contact_id')->nullable();

            $table->foreignId('firma_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreignId('anforderung_id')
                ->nullable()
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
        Schema::dropIfExists('anforderung_control_items');
    }
}
