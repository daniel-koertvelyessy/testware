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
            $table->string('prod_label', 20);
            $table->string('prod_name', 100)->nullable();
            $table->text('prod_description')->nullable();
            $table->string('prod_nummer', 100)->unique();
            $table->boolean('prod_active')->default(true);
            $table->decimal('prod_price', 10)->nullable();
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
