<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjectNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('label')->unique();
            $table->string('name')->nullable();
            $table->string('color')->nullable();
        });

        Schema::create('note_tags', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('tab_id')->nullable();
            $table->foreignId('note_id')->nullable();
        });

        Schema::create('note_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('label')->unique();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
        });

        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('uid');
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('note_type_id')->nullable()->constrained()->onDelete('cascade');
            $table->boolean('is_intern')->default(true);
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
        });

        Schema::create('note_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('note_id')->constrained()->onDelete('cascade');
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('note_tags');
        Schema::dropIfExists('note_items');
        Schema::dropIfExists('note_types');
    }
}
