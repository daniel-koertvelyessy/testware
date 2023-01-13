<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSortToAnforderungControlItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anforderung_control_items', function (Blueprint $table) {
            $table->tinyInteger('aci_sort')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anforderung_control_items', function (Blueprint $table) {
            $table->dropColumn('aci_sort');
        });
    }
}
