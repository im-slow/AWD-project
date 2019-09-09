<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollsTable extends Migration
{

    public function up()
    {
        Schema::create('Polls', function(Blueprint $table) {
            $table->increments('id');
            $table->string('idNum');
            $table->string('title');
            $table->string('openText');
            $table->string('closeText');
            $table->boolean('openPoll');
            $table->boolean('statePoll');
            $table->string('URLPoll');
            $table->foreign('IDuser')->references('id')->on('users');
            // Constraints declaration
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('Polls');
    }
}
