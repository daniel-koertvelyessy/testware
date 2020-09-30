<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerordnungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verordnungs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('vo_name_kurz', 20)->unique();
            $table->string('vo_name_lang', 100)->nullable();
            $table->string('vo_nummer', 100)->nullable();
            $table->string('vo_stand', 100)->nullable();
            $table->text('vo_name_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verordnungs');
    }
}
