<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{

    public function up()
    {
        Schema::create('Answers', function(Blueprint $table) {
            $table->increments('id');
            $table->string('answer');
            $table->foreign('IDquestion')->references('id')->on('polls');
            // Constraints declaration
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('Answers');
    }
}
