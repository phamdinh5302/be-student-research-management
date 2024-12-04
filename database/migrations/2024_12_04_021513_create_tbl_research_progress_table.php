<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_01_000013_create_tbl_research_progress_table.php
    //Bảng tiến độ nghiên cứu (ghi nhận tiến độ thực hiện các đề tài).
    public function up()
    {
        Schema::create('tbl_research_progress', function (Blueprint $table) {
            $table->id('progress_id');
            $table->foreignId('topic_id')->constrained('tbl_research_topics')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('task_description');
            $table->text('report_content')->nullable();
            $table->enum('status', ['Đúng tiến độ', 'Trễ tiến độ', 'Hoàn thành']);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_research_progress');
    }
};
