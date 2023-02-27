<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->engine ='InnoDB';
            $table->id();
            $table->bigInteger('user_id')->index();
            $table->bigInteger('isbn');
            $table->string('title');
            $table->string('synopsis');
            $table->bigInteger('author_id')->unsigned();
            $table->bigInteger('genre_id')->unsigned();
            $table->integer('pages')->unsigned();
            $table->boolean('finished');
            $table->timestamps();
            $table->foreign('genre_id')->references('id')->on('genres')->cascadeOnDelete();
            $table->foreign('author_id')->references('id')->on('authors')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
