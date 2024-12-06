<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblAccountsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tbl_accounts')) {
            Schema::create('tbl_accounts', function (Blueprint $table) {
                $table->id('account_id');
                $table->string('username', 50)->unique();
                $table->string('cccd', 12)->unique();
                $table->enum('gender', ['Nam', 'Nữ']);
                $table->date('birth_date');
                $table->string('email', 100)->unique();
                $table->string('phone_number', 15);
                $table->string('address')->nullable();
                $table->string('profile_picture')->nullable();
                $table->foreignId('role_id')->constrained('tbl_roles')->onDelete('cascade');
                $table->string('password');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('tbl_accounts');
    }
}
