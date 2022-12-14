<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentFuntionControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_funtion_controls', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->dateTime('controlled_at');
            $table->foreignId('function_control_firma')->nullable();
            $table->foreignId('function_control_profil')->nullable();
            $table->boolean('function_control_pass');
            $table->text('function_control_text')->nullable();
            $table->foreignId('equipment_id')
                ->constrained()
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_funtion_controls');
    }
}
