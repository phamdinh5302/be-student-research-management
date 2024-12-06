<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_01_000015_create_tbl_awards_table.php
    //Bảng giải thưởng (ghi nhận giải thưởng cho các đề tài xuất sắc).
    public function up()
    {
        if (!Schema::hasTable('tbl_awards')) {
            Schema::create('tbl_awards', function (Blueprint $table) {
                $table->foreignId('topic_id')->constrained('tbl_research_topics')->onDelete('cascade')->primary();
                $table->string('award_name', 100);
                $table->text('award_description')->nullable();
                $table->timestamps();
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_awards');
    }
};
