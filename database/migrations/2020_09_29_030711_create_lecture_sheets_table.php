<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLectureSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecture_sheets', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->date('date')->nullable();
            $table->text('description')->nullable();
            $table->string('file')->nullable();
            $table->integer('student_type')->nullable();
            $table->integer('branch')->nullable();
            $table->integer('class')->nullable();
            $table->integer('batch')->nullable();
            $table->integer('subject')->nullable();
            
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
        Schema::dropIfExists('lecture_sheets');
    }
}
