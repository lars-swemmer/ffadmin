<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpotifyAuth extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    	'accessToken',
    	'refreshToken'	
    ];

    /**
     * Get the user record associated with the spotify_authentication.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
