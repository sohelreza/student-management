<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoomClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zoom_classes', function (Blueprint $table) {
            $table->id();
            
            $table->string('meeting_id')->nullable();
            $table->string('password')->nullable();
            $table->string('topic')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('when')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('teacher_id')->nullable();
            $table->integer('branch')->nullable();
            $table->integer('class')->nullable();
            $table->integer('batch')->nullable();
            $table->integer('student_type')->nullable();
            $table->integer('subject')->nullable();
            $table->boolean('host_video')->nullable();
            $table->boolean('client_video')->nullable();
            $table->integer('meeting_type')->nullable();
            $table->boolean('join_before_host')->nullable();
            $table->boolean('mute_upon_entry')->nullable();
            $table->boolean('enforece_login')->nullable();
            $table->boolean('auto_recording')->nullable();
            $table->text('join_url',)->nullable();
            $table->text('start_url')->nullable();
            $table->integer('live_status')->nullable();
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
        Schema::dropIfExists('zoom_classes');
    }
}
