<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_01_000005_create_tbl_research_directions_table.php
    //Bảng hướng nghiên cứu (chứa các lĩnh vực nghiên cứu cụ thể).
    public function up()
    {
        if (!Schema::hasTable('tbl_research_directions')) {
            Schema::create('tbl_research_directions', function (Blueprint $table) {
                $table->id('research_direction_id');
                $table->string('research_direction_name', 100);
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_research_directions');
    }
};
