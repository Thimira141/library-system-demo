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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_id')->unique();
            $table->string('member_cover_img', 256)->nullable();
            $table->string('member_name', 256);
            $table->string('member_nic_type', 50);
            $table->string('member_nic_number', 256);
            $table->date('member_dob');
            $table->date('member_added');
            $table->string('member_email', 256);
            $table->string('member_tel', 256);
            $table->string('member_address', 256);
            $table->string('member_remarks', 256)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
