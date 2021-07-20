<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCqExamEnrollAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cq_exam_enroll_answers', function (Blueprint $table) {
            $table->id();

            $table->integer('student_id')->nullable();
            $table->integer('exam_id')->nullable();
            $table->integer('image')->nullable();
            
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
        Schema::dropIfExists('cq_exam_enroll_answers');
    }
}
