<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Grades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('grade');

            $table->bigInteger('grade_for')->unsigned();
            $table->foreign('grade_for')->references('id')->on('users');

            $table->bigInteger('graded_by')->unsigned();
            $table->foreign('graded_by')->references('id')->on('users');

            // $table->bigInteger('subjects_id')->unsigned();
            // $table->foreign('subjects_id')->references('id')->on('subjects');

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
        Schema::dropIfExists('grades');
    }
}
