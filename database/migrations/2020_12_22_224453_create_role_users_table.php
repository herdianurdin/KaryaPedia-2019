<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleUsersTable extends Migration
{
    public function up()
    {
        Schema::create('role_users', function (Blueprint $table) {
        $table->bigInteger('user_id')->unsigned();
	    $table->bigInteger('role_id')->unsigned();

	    $table->unique(['user_id', 'role_id']);

	    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
	    $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('role_users');
    }
}
