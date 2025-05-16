<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('read')->nullable();
            $table->text('equipment_event_text')->nullable();
            $table->foreignId('equipment_event_user')->nullable();
            $table->foreign('equipment_event_user')
                ->on('users')
                ->references('id')
                ->onDelete('set null');
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
        Schema::dropIfExists('equipment_events');
    }
}
