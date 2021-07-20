<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCqExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cq_exams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('teacher_id')->nullable();
            $table->integer('student_type')->nullable();

            $table->integer('branch_id')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('batch_id')->nullable();
            $table->integer('subject_id')->nullable();
            $table->date('exam_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->float('total_exam_duration')->nullable();
            $table->float('total_exam_marks')->nullable();
            $table->float('passing_percentage')->nullable();
            
            $table->integer('status')->nullable();
            $table->string('solve_sheet')->nullable();
            $table->integer('publish_rank')->nullable();
            
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
        Schema::dropIfExists('cq_exams');
    }
}
