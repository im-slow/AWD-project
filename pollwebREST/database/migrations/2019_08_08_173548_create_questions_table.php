<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{

    public function up()
    {
        Schema::create('Questions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('positionNumber');
            $table->string('uniqueCode');
            $table->string('questionText');
            $table->string('note');
            $table->boolean('mandatory');
            $table->enum('questionType', ['SHORTTEXT', 'LONGTEXT', 'NUMBER', 'DATE', 'SINGLECHOISE', 'MULTIPLECHOISE']);
            $table->string('minimum');
            $table->string('maximum');
            $table->string('questionOption');
            $table->foreign('IDpoll')->references('id')->on('polls');
            // Constraints declaration
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('Questions');
    }
}
