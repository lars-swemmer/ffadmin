<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpotifyPlaylistPervesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spotify_playlist_perves', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('spotify_playlist_id')->unsigned()->nullable();
            $table->foreign('spotify_playlist_id')->references('id')->on('spotify_playlists');
            $table->integer('followers')->nullable();
            $table->integer('new_followers')->nullable();
            $table->float('followers_daily_growth')->nullable();
            $table->timestamp('last_updated')->nullable();
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
        Schema::dropIfExists('spotify_playlist_perves');
    }
}
