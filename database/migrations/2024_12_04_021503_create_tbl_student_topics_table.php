<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_01_000008_create_tbl_student_topics_table.php
    //Bảng sinh viên - đề tài (liên kết sinh viên tham gia vào các đề tài nghiên cứu).
    public function up()
    {
        if (!Schema::hasTable('tbl_student_topics')) {
            Schema::create('tbl_student_topics', function (Blueprint $table) {
                $table->id('student_topic_id');
                $table->foreignId('topic_id')
                    ->constrained('tbl_research_topics')
                    ->onDelete('cascade')
                    ->onUpdate('cascade'); // Đảm bảo cập nhật liên kết
                $table->foreignId('student_id')
                    ->constrained('tbl_students')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                $table->boolean('is_leader')->default(false);
                $table->timestamps();
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_student_topics');
    }
};
