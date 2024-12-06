<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_01_000007_create_tbl_research_topics_table.php
    //Bảng đề tài nghiên cứu (chứa thông tin về các đề tài nghiên cứu khoa học).
    public function up()
    {
        if (!Schema::hasTable('tbl_research_topics')) {
            Schema::create('tbl_research_topics', function (Blueprint $table) {
                $table->id('topic_id');
                $table->string('topic_name', 100);
                $table->text('research_goal');
                $table->text('content');
                $table->foreignId('lecturer_id')->constrained('tbl_lecturers')->onDelete('cascade');
                $table->date('start_date');
                $table->date('end_date');
                $table->enum('status', ['Đang thực hiện', 'Hoàn thành', 'Hủy']);
                $table->timestamps();
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_research_topics');
    }
};
