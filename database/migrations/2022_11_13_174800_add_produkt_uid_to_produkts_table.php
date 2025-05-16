<?php

use App\Produkt;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProduktUidToProduktsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produkts', function (Blueprint $table) {
            $table->uuid('prod_uuid')->nullable();
        });

        //            foreach (Produkt::all() as $produkt) {
        //                if (!$produkt->prod_uuid) {
        //                    $produkt->prod_uuid = \Illuminate\Support\Str::uuid();
        //                    $produkt->save();
        //                }
        //            }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produkts', function (Blueprint $table) {
            $table->dropColumn('prod_uuid');
        });
    }
}
