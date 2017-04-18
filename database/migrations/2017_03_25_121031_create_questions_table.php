<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('questions');

        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');

            $table->longText('subject');
            $table->text('difficulty');
            $table->string('problem');
            $table->string('answer');
            $table->string('wrong_one');
            $table->string('wrong_two');
            $table->string('wrong_three');
            $table->string('creator');

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
        Schema::dropIfExists('questions');
    }
}
