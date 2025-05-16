<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('label', 100);
            $table->string('name')->nullable();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('label', 100);
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('view')->nullable();
            $table->string('orientation')
                ->default('L')
                ->nullable();
            $table->foreignId('report_type_id')
                ->nullable()
                ->default(1)
                ->constrained('report_types');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
        Schema::dropIfExists('report_types');
    }
}
