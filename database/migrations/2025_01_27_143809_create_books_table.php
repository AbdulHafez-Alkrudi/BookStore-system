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
        Schema::disableForeignKeyConstraints();
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->references('id')->on('authors');
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->foreignId('publisher_id')->references('id')->on('publishers');
            $table->string('title');
            $table->float('price_for_sale');
            $table->float('price_for_borrow');
            $table->integer('amount');
            $table->date('authorship_date');
            $table->boolean('available');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
