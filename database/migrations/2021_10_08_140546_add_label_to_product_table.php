<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLabelToProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produkts', function (Blueprint $table) {
            $table->foreignId('equipment_label_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produkts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('equipment_label_id');
            $table->dropColumn('equipment_label_id');
        });
    }
}
