<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_01_000009_create_tbl_proposals_table.php
    //Bảng đề cương nghiên cứu (chứa thông tin về đề cương và trạng thái phê duyệt).
    public function up()
    {
        Schema::create('tbl_proposals', function (Blueprint $table) {
            $table->id('proposal_id');
            $table->foreignId('topic_id')->constrained('tbl_research_topics')->onDelete('cascade');
            $table->text('proposal_content');
            $table->date('submission_date');
            $table->enum('approval_status', ['Đang chờ duyệt', 'Đã phê duyệt', 'Bị từ chối']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_proposals');
    }
};
