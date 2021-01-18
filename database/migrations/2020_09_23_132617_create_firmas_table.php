<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firmas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('fa_label', 20)->index();
            $table->string('fa_name', 100)->index()->nullable();
            $table->text('fa_description')->nullable();
            $table->string('fa_kreditor_nr', 100)->index()->nullable();
            $table->string('fa_debitor_nr', 100)->index()->nullable();
            $table->string('fa_vat', 30)->nullable();
            $table->foreignId('adresse_id')
                ->nullable()
                ->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firmas');
    }
}
