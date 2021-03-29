<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserToNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained();
        });

        Schema::create('note_tag', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('tag_id')->nullable();
            $table->foreignId('note_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notes', function (Blueprint $table) {
            //
        });
    }
}
