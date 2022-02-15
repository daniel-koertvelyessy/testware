<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWarnintervalidToAnforderungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anforderungs', function (Blueprint $table) {
            $table->foreignId('warn_interval_id')
                ->default(5)
                ->nullable();
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
            $table->dropColumn('warn_interval_id');
        });
    }
}
