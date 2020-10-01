<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controls', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('control_name_kurzel',20);
            $table->date('control_date');
            $table->boolean('control_pass')->default(false);
            $table->text('control_signature_controller');
            $table->text('control_signature_superviser')->nullable();

//            $table->foreignId('control_equipment_id')
//                ->references('id')
//                ->on('control_equipment')
//                ->onUpdate('cascade')
//                ->onDelete('set null');
//
//            $table->foreignId('equipment_id')
//                ->nullable()
//                ->constrained()
//                ->onUpdate('cascade')
//                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('controls');
    }
}
