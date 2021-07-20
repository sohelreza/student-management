<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('batch_id')->nullable();
            $table->integer('subject_id')->nullable();
            $table->integer('student_type')->nullable();
            
            $table->float('total_marks')->nullable();
            $table->float('height_marks')->nullable();

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
        Schema::dropIfExists('exams');
    }
}
