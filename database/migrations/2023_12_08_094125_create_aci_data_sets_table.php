<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAciDataSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aci_data_sets', function (Blueprint $table) {

            $table->id();
            $table->timestamps();

            $table->decimal('data_point_value', 12, 2);

            $table->string('data_point_tol_target_mode');
            $table->decimal('data_point_tol', 12, 3);
            $table->string('data_point_tol_mod', 3)
                ->default('abs');

            $table->integer('data_point_sort')
                ->nullable();

            $table->foreignId('anforderung_control_item_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aci_data_sets');
    }
}
