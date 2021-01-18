<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->timestamps();
            $table->string('r_label', 20);
            $table->string('r_name', 100)->nullable();
            $table->text('r_description')->nullable();
            $table->uuid('storage_id')->nullable();
            $table->unsignedBigInteger('building_id')->nullable();

            $table->foreign('building_id')
                ->references('id')
                ->on('buildings')
                ->onDelete('set null')
                ->onUpdate('cascade');


            $table->unsignedBigInteger('room_type_id')->nullable();

            $table->foreign('room_type_id')
                ->references('id')
                ->on('room_types')
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
        Schema::dropIfExists('room');
    }
}
