<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname');
            $table->string('number');
            $table->string('email');
            $table->string('username');
            $table->string('password');
            $table->bigInteger('roles_id')->unsigned();
            $table->foreign('roles_id')->references('id')->on('roles');
            $table->tinyInteger('is_validated')->default(0);
            $table->string('validation_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
