<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRolesTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_roles', function (Blueprint $table) {
            $table->id('role_id');
            $table->string('role_name', 50);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_roles');
    }
}