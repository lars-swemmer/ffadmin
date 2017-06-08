<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpotifyArtistPervesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spotify_artist_perves', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('spotify_artist_id')->unsigned()->nullable();
            $table->foreign('spotify_artist_id')->references('id')->on('spotify_artists');
            $table->integer('followers')->nullable();
            $table->integer('new_followers')->nullable();
            $table->integer('popularity')->nullable();
            $table->integer('new_popularity')->nullable();
            $table->string('date')->nullable();
            
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
        Schema::dropIfExists('spotify_artist_perves');
    }
}
