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
        Schema::create('books_borrow_return', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id')->nullable(true);
            $table->unsignedBigInteger('member_id')->nullable(true);
            $table->date('borrowed_date');
            $table->date('returned_date')->nullable(true);
            $table->date('return_promised_date')->nullable(true)->comment('promised date to return the book');
            $table->string('remarks')->nullable(true);
            $table->timestamps();
            // fk
            $table->foreign('book_id')->references('id')->on('books')->onDelete('set null');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books_borrow_return');
    }
};
