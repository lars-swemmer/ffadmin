<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpotifyPlaylistPerf extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'spotify_playlist_id',
        'followers',
        'new_followers',
        'followers_daily_growth',
        'date',
        'last_updated'
    ];

    public function spotifyPlaylist()
    {
        return $this->belongsTo('App\SpotifyPlaylist');
    }
}
