<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamEnrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_enrolls', function (Blueprint $table) {
            $table->id();

            $table->integer('exam_id')->nullable();
            $table->integer('student_id')->nullable();

            $table->string('roll_no')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();

            $table->string('total_marks')->nullable();
            $table->string('obtained_marks')->nullable();
            $table->string('height_marks')->nullable();
            $table->string('merit_position')->nullable();

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
        Schema::dropIfExists('exam_enrolls');
    }
}
