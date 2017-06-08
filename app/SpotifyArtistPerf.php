<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpotifyArtistPerf extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'spotify_artist_id',
        'followers',
        'new_followers',
        'popularity',
        'new_popularity',
        'date'
    ];

    public function spotifyArtist()
    {
        return $this->belongsTo('App\SpotifyArtist');
    }
}
