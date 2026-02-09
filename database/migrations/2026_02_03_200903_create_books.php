<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id(); // auto-increment PK
            $table->string('book_id')->unique(); // custom business ID
            $table->string('book_cover_img', 256)->nullable();
            $table->string('book_title', 256);
            $table->string('book_author', 256);
            $table->date('book_added'); // better as a DATE
            $table->string('book_remarks', 256)->nullable();
            $table->timestamps();
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
