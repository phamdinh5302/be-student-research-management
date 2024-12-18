<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_01_000011_create_tbl_council_lecturers_table.php
    //Bảng giảng viên trong hội đồng (liên kết giảng viên với hội đồng đánh giá).
    public function up()
    {
        if (!Schema::hasTable('tbl_council_lecturers')) {
            Schema::create('tbl_council_lecturers', function (Blueprint $table) {
                $table->foreign('council_id')->references('id')->on('tbl_evaluation_councils')->onDelete('cascade');
                $table->foreign('lecturer_id')->references('id')->on('tbl_lecturers')->onDelete('cascade');
                $table->enum('duty', ['Chủ tịch hội đồng', 'Ủy viên', 'Thư ký', 'Hỗ trợ kỹ thuật']);
                $table->primary(['council_id', 'lecturer_id']);
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_council_lecturers');
    }
};
