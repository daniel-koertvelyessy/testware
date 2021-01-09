<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduktTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produkts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('prod_name_kurz', 20);
            $table->string('prod_name_lang', 100)->nullable();
            $table->text('prod_name_text')->nullable();
            $table->string('prod_nummer', 100);
            $table->boolean('prod_active')->default(true);

            $table->unsignedBigInteger('produkt_kategorie_id')->nullable();
            $table->foreign('produkt_kategorie_id')
                ->references('id')
                ->on('produkt_kategories')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('produkt_state_id')->nullable();
            $table->foreign('produkt_state_id')
                ->references('id')
                ->on('produkt_states')
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
        Schema::dropIfExists('produkts');
    }
}
