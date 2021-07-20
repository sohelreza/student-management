<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->integer('class_id')->unsigned();
            $table->integer('branch_id')->unsigned();
            $table->string('name');
            $table->string('time');
            $table->integer('max_student_number')->unsigned();
            $table->integer('student_number')->unsigned();
            $table->string('phase');
            $table->integer('status');
            $table->integer('student_type');
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
        Schema::dropIfExists('batches');
    }
}
