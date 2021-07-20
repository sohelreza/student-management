<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcqOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcq_options', function (Blueprint $table) {
            $table->id();
            
            $table->integer('question_id')->nullable();
            $table->string('option_number')->nullable();
            $table->text('option_title')->nullable();
            $table->integer('right_answer')->nullable();
            
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
        Schema::dropIfExists('mcq_options');
    }
}
