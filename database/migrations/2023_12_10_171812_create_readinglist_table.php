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
        Schema::create('readinglist', function (Blueprint $table) {
            $table->id('list_id');
            $table->integer('user_id');
            $table->integer('book_id');
            $table->string('reading_status');
            $table->integer('reading_page_num');
            $table->string('reading_note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('readinglist');
    }
};
