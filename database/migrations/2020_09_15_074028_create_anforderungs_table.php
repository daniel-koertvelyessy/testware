<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnforderungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anforderungs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('an_label', 20)->unique();
            $table->string('an_name', 100)->nullable();
            $table->text('an_description')->nullable();

            $table->unsignedSmallInteger('an_control_interval')->nullable();

            $table->foreignId('control_interval_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreignId('anforderung_type_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreignId('verordnung_id')
                ->nullable()
                ->constrained()
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
        Schema::dropIfExists('anforderungs');
    }
}
