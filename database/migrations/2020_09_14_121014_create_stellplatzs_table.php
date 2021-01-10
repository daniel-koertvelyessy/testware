<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStellplatzsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stellplatzs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('sp_label', 20);
            $table->string('sp_name', 100)->nullable();
            $table->text('sp_name_text')->nullable();
            $table->uuid('storage_id')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('stellplatz_typ_id')->nullable();
            $table->foreign('stellplatz_typ_id')
                ->references('id')
                ->on('stellplatz_typs')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('room_id')
                ->references('id')
                ->on('rooms')
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
        Schema::dropIfExists('stellplatzs');
    }
}
