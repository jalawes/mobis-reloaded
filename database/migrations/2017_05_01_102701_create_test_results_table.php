<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('test_id');
            $table->integer('user_id')->unsigned();

            $table->text('correct_words')->nullable();
            $table->integer('correct_words_count')->unsigned();

            $table->text('incorrect_words')->nullable();
            $table->integer('incorrect_words_count')->unsigned();

            $table->integer('back_space_count')->unsigned()->nullable();
            // $table->integer('wpm')->unsigned();

            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_results');
    }
}
