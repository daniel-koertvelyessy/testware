<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFirstTestFieldToAnforderungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anforderungs', function (Blueprint $table) {
            $table->boolean('is_initial_test')->default(false);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anforderungs', function (Blueprint $table) {
            $table->dropColumn('is_initial_test');
        });
    }
}
