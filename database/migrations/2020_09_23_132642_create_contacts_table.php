<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unique([
                'firma_id',
                'con_vorname',
                'con_name',
            ]);
            $table->string('con_label', 20)->nullable()->index();
            $table->string('con_name', 100)->index();
            $table->string('con_name_2', 100)->nullable();
            $table->string('con_vorname', 100)->nullable();
            $table->text('con_position')->nullable();
            $table->string('con_email', 100)->nullable();
            $table->string('con_telefon', 100)->nullable();
            $table->string('con_mobil', 100)->nullable();
            $table->string('con_fax', 100)->nullable();
            $table->string('con_com_1', 100)->nullable();
            $table->string('con_com_2', 100)->nullable();
            $table->foreignId('firma_id')->nullable();
            $table->foreignId('anrede_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
