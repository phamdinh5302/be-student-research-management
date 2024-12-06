<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_01_000016_create_tbl_notifications_table.php
    //Bảng thông báo (lưu trữ các thông báo được gửi trong hệ thống).
    public function up()
    {
        if (!Schema::hasTable('tbl_notifications')) {
            Schema::create('tbl_notifications', function (Blueprint $table) {
                $table->id('notification_id');
                $table->foreignId('sender_account_id')->constrained('tbl_accounts', 'account_id')->onDelete('cascade');
                $table->string('title');
                $table->datetime('sent_time');
                $table->text('message');
                $table->timestamps();
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_notifications');
    }
};
