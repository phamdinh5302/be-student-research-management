<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_01_000010_create_tbl_evaluation_councils_table.php
    //Bảng hội đồng đánh giá (chứa thông tin về các hội đồng đánh giá đề tài).
    public function up()
    {
        if (!Schema::hasTable('tbl_evaluation_councils')) {
            Schema::create('tbl_evaluation_councils', function (Blueprint $table) {
                $table->id('council_id');
                $table->string('council_name', 100);
                $table->string('council_level', 50);
                $table->dateTime('time');
                $table->string('location', 100);
                $table->timestamps();
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_evaluation_councils');
    }
};
