<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLizenzTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lizenz', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->uuid('lizenz_id')->nullable();
            $table->string('lizenz_user')->nullable();
            $table->string('lizenz_order')->nullable();
            $table->foreignId('lizenz_max_objects')->default(100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lizenz');
    }
}
