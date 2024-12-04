<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_01_000006_create_tbl_lecturer_research_directions_table.php
    //Bảng giảng viên - hướng nghiên cứu (liên kết giảng viên với các hướng nghiên cứu họ phụ trách).
    public function up()
    {
        Schema::create('tbl_lecturer_research_directions', function (Blueprint $table) {
            $table->foreignId('lecturer_id')->constrained('tbl_lecturers')->onDelete('cascade');
            $table->foreignId('research_direction_id')->constrained('tbl_research_directions')->onDelete('cascade');
            $table->primary(['lecturer_id', 'research_direction_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_lecturer_research_directions');
    }
};
