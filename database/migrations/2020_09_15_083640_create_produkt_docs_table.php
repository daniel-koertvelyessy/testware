<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduktDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produkt_docs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('proddoc_label', 150);
            $table->string('proddoc_name', 150)->nullable();
            $table->string('proddoc_name_pfad', 150)->nullable();
            $table->text('proddoc_name_text')->nullable();
            $table->unsignedBigInteger('produkt_id')->nullable();
            $table->unsignedBigInteger('document_type_id')->nullable();

            $table->foreign('produkt_id')
                ->references('id')
                ->on('produkts')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('document_type_id')
                ->references('id')
                ->on('document_types')
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
        Schema::dropIfExists('produkt_docs');
    }
}
