<?php

namespace App\Http\Controllers;

use App\SpotifyArtist;
use App\SpotifyArtistPerf;
use App\SpotifyAuth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SpotifyWebAPI;

class SpotifyArtistController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spotifyPerformances = SpotifyArtistPerf::whereDate('date', Carbon::today())->orderBy('popularity', 'desc')->orderBy('followers', 'desc')->paginate(25);

        return view('spotifyartists.index', compact('spotifyPerformances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('spotifyartists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'artist_id' => 'required'
        ]);

        $input = $request->all();

        // Setup Spotify api
        $spotifyAuth = SpotifyAuth::first();
        $refreshToken = $spotifyAuth->refreshToken;
        $session = new SpotifyWebAPI\Session(env('SPOTIFY_CLIENT_ID'), env('SPOTIFY_CLIENT_SECRET'), env('SPOTIFY_REDIRECT_URI'));
        $session->refreshAccessToken($refreshToken);
        $accessToken = $session->getAccessToken();
        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        // Retrieve Spotify artist data
        try {
            $artistData = $api->getArtist($input['artist_id']);
        }
        catch (\Exception $e) {
            // return to create page with error message
            \Session::flash('flash_message', 'Error retrieving artist, try again.');

            return redirect('spotify-artists/create');
        }

        // Create SpotifyArtist record
        $artist = SpotifyArtist::firstOrCreate([
            'name' => $artistData->name,
            'spotify_id' => $input['artist_id'],
            'external_url' => $artistData->external_urls->spotify
        ]);

        // create init performance
        $performance = SpotifyArtistPerf::updateOrCreate(
            ['date' => Carbon::today()->format('Y-m-d'), 'spotify_artist_id' => $artist->id],
            [
                'followers' => $artistData->followers->total,
                'new_followers' => '0',
                'popularity' => $artistData->popularity,
                'new_popularity' => '0'
            ]
        );

        // on succes redirect
        \Session::flash('flash_success', 'Artist has been added.');

        return redirect('spotify-artists');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
