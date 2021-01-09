<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlIntervalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_intervals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('ci_label', 10)->unique();
            $table->string('ci_name', 150)->nullable();
            $table->string('ci_si', 10);
            $table->string('ci_delta')->default('MONTH'); // 1 Woche in Sekunden

        });
    }

    /**MINUTE_MICROSECOND
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('control_intervals');
    }
}
