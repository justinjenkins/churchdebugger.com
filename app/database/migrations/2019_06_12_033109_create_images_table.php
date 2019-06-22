<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('imageid', 8)->unique();
            $table->string('message')->nullable();
            $table->string('passage_text', 500)->nullable();
            $table->string('reference')->nullable();
            $table->string('unsplash_id', 64)->nullable();
            $table->bigInteger('twitter_id')->nullable();
            //$table->foreign('twitter_id')->references('twitter_id')->on('tweet_history');
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
        Schema::dropIfExists('images');
    }
}
