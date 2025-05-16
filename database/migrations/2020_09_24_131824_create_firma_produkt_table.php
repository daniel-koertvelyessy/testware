<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmaProduktTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firma_produkt', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('firma_id')->nullable();
            $table->unsignedBigInteger('produkt_id')->nullable();

            $table->foreign('firma_id')
                ->references('id')
                ->on('firmas')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('produkt_id')
                ->references('id')
                ->on('produkts')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->unique(['firma_id', 'produkt_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firma_produkt');
    }
}
