<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('label', 20);
            $table->string('name')->nullable();
            $table->boolean('is_super_user')->default(false);
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unique(['role_id', 'user_id']);
            $table->foreignId('role_id')->constrained();
            $table->foreignId('user_id')->constrained();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
