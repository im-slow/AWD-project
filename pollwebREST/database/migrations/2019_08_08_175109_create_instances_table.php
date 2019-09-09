<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstancesTable extends Migration
{

    public function up()
    {
        Schema::create('Instances', function(Blueprint $table) {
            $table->increments('id');
            $table->boolean('userStatus')->default('1');
            $table->timestamps('submission');
            $table->foreign('IDuser')->references('id')->on('users');
            $table->foreign('IDpoll')->references('id')->on('polls');
            // Constraints declaration
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('Instances');
    }
}
