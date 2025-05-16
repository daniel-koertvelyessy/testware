<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->date('control_event_date');
            $table->date('control_event_next_due_date');
            $table->boolean('control_event_pass')->default(false);
            $table->text('control_event_controller_signature')->nullable();
            $table->text('control_event_controller_name');
            $table->text('control_event_supervisor_signature')->nullable();
            $table->text('control_event_supervisor_name')->nullable();
            $table->text('control_event_text')->nullable();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('control_equipment_id')
                ->nullable()
                ->references('id')
                ->on('control_equipment')
                ->onUpdate('cascade')
                ->onDelete('set null');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('control_events');
    }
}
