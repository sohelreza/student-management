<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcqExamEnrollAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcq_exam_enroll_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('mcq_exam_enroll_id')->nullable();
            $table->integer('student_id')->nullable();
            $table->integer('exam_id')->nullable();
            $table->integer('question_id')->nullable();
            $table->integer('option_id')->nullable();
            $table->integer('correct_answer')->nullable();
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
        Schema::dropIfExists('mcq_exam_enroll_answers');
    }
}
