<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpotifyArtist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
        'followers',
    	'spotify_id',
    	'popularity',
    	'external_url'
    ];

    public function spotifyArtistPerf()
    {
        return $this->hasMany('App\SpotifyArtistPerf');
    }
}
