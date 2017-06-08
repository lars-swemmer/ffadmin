<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpotifyPlaylistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spotify_playlists', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable();
            $table->string('user_id')->nullable();
            $table->string('spotify_id')->nullable();
            $table->string('external_url')->nullable();

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
        Schema::dropIfExists('spotify_playlists');
    }
}
