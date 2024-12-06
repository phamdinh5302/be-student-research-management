<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_01_000014_create_tbl_research_results_table.php
    //Bảng kết quả nghiên cứu (chứa kết quả và đánh giá của đề tài).
    public function up()
    {
        if (!Schema::hasTable('tbl_research_results')) {
            Schema::create('tbl_research_results', function (Blueprint $table) {
                $table->foreignId('topic_id')->constrained('tbl_research_topics')->onDelete('cascade')->primary();
                $table->text('result_description');
                $table->float('score')->check('score >= 0 AND score <= 10');
                $table->text('feedback')->nullable();
                $table->timestamps();
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_research_results');
    }
};
