<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTweetHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweet_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('twitter_id');
            $table->string('username');
            $table->string('tweet');
            $table->dateTimeTz('tweet_created_at');
            $table->json('raw_tweet');
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
        Schema::dropIfExists('tweet_history');
    }
}
