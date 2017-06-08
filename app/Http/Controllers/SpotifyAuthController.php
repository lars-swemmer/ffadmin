<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpotifyAuthController extends Controller
{
    public function index()
    {
    	return view('spotifyauth.index');
    }

    public function callback()
    {
    	return redirect('spotify-auth');
    }
}
