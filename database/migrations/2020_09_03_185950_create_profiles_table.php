<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            //            $table->unsignedBigInteger('user_id')->unique();
            $table->string('ma_nummer', 100)->nullable()->index();
            $table->string('ma_name', 100)->index();
            $table->string('ma_name_2', 100)->nullable();
            $table->string('ma_vorname', 100)->nullable();
            $table->date('ma_geburtsdatum')->nullable();
            $table->date('ma_eingetreten')->nullable();
            $table->date('ma_ausgetreten')->nullable();
            $table->string('ma_telefon', 100)->nullable();
            $table->string('ma_mobil', 100)->nullable();
            $table->string('ma_fax', 100)->nullable();
            $table->string('ma_com_1', 100)->nullable();
            $table->string('ma_com_2', 100)->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
