<?php

namespace App\Http\Controllers;

use App\SpotifyAuth;
use Illuminate\Http\Request;
use SpotifyWebAPI;

class SpotifyAuthController extends Controller
{
    public function index()
    {
    	// auth credentials
		$session = new SpotifyWebAPI\Session(
		    env('SPOTIFY_CLIENT_ID'),
		    env('SPOTIFY_CLIENT_SECRET'),
		    env('SPOTIFY_REDIRECT_URI')
		);

		$options = [
		    'scope' => [
		        'user-follow-read',
		        'user-follow-modify',
		        'playlist-modify-public',
		        'user-top-read',
		        'user-read-private',
		    ],
		];

		$oauthUrl = $session->getAuthorizeUrl($options);
		$spotifyAuth = SpotifyAuth::first();

    	return view('spotifyauth.index', compact('oauthUrl', 'spotifyAuth'));
    }

    public function callback()
    {
    	$session = new SpotifyWebAPI\Session(env('SPOTIFY_CLIENT_ID'), env('SPOTIFY_CLIENT_SECRET'), env('SPOTIFY_REDIRECT_URI'));
		$session->requestAccessToken($_GET['code']);
		$accessToken = $session->getAccessToken();

		$api = new SpotifyWebAPI\SpotifyWebAPI();
		$api->setAccessToken($accessToken);

		$spotifyAuth = SpotifyAuth::updateOrCreate(
		    ['user_id' => auth()->id()],
		    ['accessToken' => $session->getAccessToken(), 'refreshToken' => $session->getRefreshToken()]
		);

    	return redirect('spotify-auth');
    }
}
