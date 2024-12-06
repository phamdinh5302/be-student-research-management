<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_01_000003_create_tbl_lecturers_table.php
    //Bảng giảng viên (chứa thông tin về giảng viên)
    public function up()
    {
        if (!Schema::hasTable('tbl_lecturers')) {
            Schema::create('tbl_lecturers', function (Blueprint $table) {
                $table->id('lecturer_id');  //mã giảng viên
                $table->foreignId('account_id')->constrained('tbl_accounts')->onDelete('cascade'); //mã tài khoản
                $table->string('lecturer_name', 100);   //tên
                $table->string('faculty', 50); //khóa
                $table->string('academic_degree', 50); //học vị
                $table->integer('number_of_topics')->default(1); //sô đề tài hướng dẫn
                $table->timestamps();
            });
        }
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_lecturers');
    }
};
