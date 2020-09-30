<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysDivisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {

//            $table->foreign('group_id')
//                ->references('id')
//                ->on('groups')
//                ->onDelete('set null')
//                ->onUpdate('cascade');

        });

        Schema::table('groups', function (Blueprint $table) {

//            $table->unsignedBigInteger('profile_id')->nullable();
//            $table->foreign('profile_id')
//                ->references('id')
//                ->on('profiles')
//                ->onUpdate('set null')
//                ->onDelete('cascade');
//
//            $table->unsignedBigInteger('division_id')->nullable();
//            $table->foreign('division_id')
//                ->references('id')
//                ->on('divisons')
//                ->onUpdate('set null')
//                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
