<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpotifyPlaylist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
        'user_id',
    	'spotify_id',
    	'external_url'	
    ];

    public function spotifyPlaylistPerf()
    {
        return $this->hasMany('App\SpotifyPlaylistPerf');
    }
}
