<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_01_000004_create_tbl_students_table.php
    //Bảng sinh viên (chứa thông tin về sinh viên).
    public function up()
    {
        Schema::create('tbl_students', function (Blueprint $table) {
            $table->id('student_id');
            $table->foreignId('account_id')->constrained('tbl_accounts')->onDelete('cascade');
            $table->string('student_name', 100);
            $table->string('faculty', 50);
            $table->string('class', 50);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_students');
    }
};
