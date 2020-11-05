<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_instructions', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->timestamps();

            $table->date('equipment_instruction_date');

            $table->text('equipment_instruction_instructor_signature')->nullable();
            $table->foreignId('equipment_instruction_instructor_profile_id')->nullable();
            $table->foreignId('equipment_instruction_instructor_firma_id')->nullable();

            $table->text('equipment_instruction_trainee_signature');
            $table->foreignId('equipment_instruction_trainee_id');
            $table->foreign('equipment_instruction_trainee_id')
                ->on('profiles')
                ->references('id')
                ->onDelete('cascade');

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
        Schema::dropIfExists('equipment_instructions');
    }
}
