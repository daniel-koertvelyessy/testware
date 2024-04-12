<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlEventDatasetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_event_datasets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->decimal('control_event_dataset_read')->nullable();
            $table->boolean('control_event_dataset_pass');
            $table->foreignId('aci_dataset_id')
                  ->nullable()
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('control_event_item_id')
                  ->nullable()
                  ->onUpdate('cascade')
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
        Schema::dropIfExists('control_event_datasets');
    }
}
