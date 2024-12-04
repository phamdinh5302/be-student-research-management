<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_01_000017_create_tbl_notification_receivers_table.php
    //Bảng người nhận thông báo (liên kết thông báo với các tài khoản người nhận).
    public function up()
    {
        Schema::create('tbl_notification_receivers', function (Blueprint $table) {
            $table->foreignId('notification_id')->constrained('tbl_notifications')->onDelete('cascade');
            $table->foreignId('receiver_account_id')->constrained('tbl_accounts')->onDelete('cascade');
            $table->primary(['notification_id', 'receiver_account_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_notification_receivers');
    }
};
