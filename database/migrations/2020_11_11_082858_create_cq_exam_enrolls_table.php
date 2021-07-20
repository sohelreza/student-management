<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCqExamEnrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cq_exam_enrolls', function (Blueprint $table) {
            $table->id();

            $table->integer('student_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('batch_id')->nullable();
            $table->integer('subject_id')->nullable();
            $table->integer('exam_id')->nullable();
            $table->float('score')->nullable();

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
        Schema::dropIfExists('cq_exam_enrolls');
    }
}
