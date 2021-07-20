<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentHomeworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_homework', function (Blueprint $table) {
            
            $table->id();
            $table->integer('student_id');
            $table->integer('teacher_id')->nullable();
            $table->integer('class_id');
            $table->integer('batch_id');
            $table->integer('branch_id');
            $table->string('title')->nullable();
            $table->integer('subject_id')->nullable();
            $table->date('submission_date');
            $table->date('evaluation_date')->nullable();
            $table->string('score')->nullable();
            $table->integer('status')->nullable();
            
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
        Schema::dropIfExists('student_homework');
    }
}
