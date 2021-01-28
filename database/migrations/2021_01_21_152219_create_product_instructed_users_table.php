<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInstructedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_instructed_users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->date('product_instruction_date');

            $table->text('product_instruction_instructor_signature')->nullable();
            $table->foreignId('product_instruction_instructor_profile_id')->nullable();
            $table->foreignId('product_instruction_instructor_firma_id')->nullable();

            $table->text('product_instruction_trainee_signature');
            $table->foreignId('product_instruction_trainee_id');
            $table->foreign('product_instruction_trainee_id')
                ->on('profiles')
                ->references('id')
                ->onDelete('cascade');

            $table->foreignId('produkt_id')
                ->constrained()
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_instructed_users');
    }
}
