<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standorts', function (Blueprint $table) {
            $table->id('id');
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('std_id');
            $table->string('std_kurzel');
            $table->string('std_objekt_typ');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('standorts');
    }
}
