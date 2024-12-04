<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_01_000012_create_tbl_council_topics_table.php
    //Bảng hội đồng - đề tài (liên kết các đề tài được đánh giá bởi hội đồng).
    public function up()
    {
        Schema::create('tbl_council_topics', function (Blueprint $table) {
            $table->foreignId('council_id')->constrained('tbl_evaluation_councils')->onDelete('cascade');
            $table->foreignId('topic_id')->constrained('tbl_research_topics')->onDelete('cascade');
            $table->primary(['council_id', 'topic_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_council_topics');
    }
};
