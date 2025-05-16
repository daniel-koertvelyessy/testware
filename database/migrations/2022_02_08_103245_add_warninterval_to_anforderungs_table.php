<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWarnintervalToAnforderungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anforderungs', function (Blueprint $table) {
            $table->unsignedSmallInteger('an_date_warn')->nullable()->default(4);

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
            $table->dropColumn([
                'an_date_warn',
            ]);
        });
    }
}
