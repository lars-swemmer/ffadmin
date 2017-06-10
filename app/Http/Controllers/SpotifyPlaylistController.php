<?php

namespace App\Http\Controllers;

use App\SpotifyAuth;
use App\SpotifyPlaylist;
use App\SpotifyPlaylistPerf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SpotifyWebAPI;

class SpotifyPlaylistController extends Controller
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
        $spotifyPerformances = SpotifyPlaylistPerf::whereDate('date', Carbon::today())->orderBy('followers', 'desc')->get();

        return view('spotifyplaylists.index', compact('spotifyPerformances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('spotifyplaylists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request
        $this->validate(request(), [
            'user_id' => 'required',
            'spotify_id' => 'required'
        ]);

        $input = $request->all();

        // setup spotify api
        $spotifyAuthentication = SpotifyAuth::first();
        $refreshToken = $spotifyAuthentication->refreshToken;
        $session = new SpotifyWebAPI\Session(env('SPOTIFY_CLIENT_ID'), env('SPOTIFY_CLIENT_SECRET'), env('SPOTIFY_REDIRECT_URI'));
        $session->refreshAccessToken($refreshToken);
        $accessToken = $session->getAccessToken();
        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        // retrieve spotify playlist data
        try {
            $playlistData = $api->getUserPlaylist($input['user_id'], $input['spotify_id']);
        }
        catch (\Exception $e) {
            // return to create page with error message
            \Session::flash('flash_message', 'Error retrieving playlist, try again.');

            return redirect('spotify-playlists/create');
        }

        // create spotifyplaylist record
        $playlist = SpotifyPlaylist::firstOrCreate([
            'name' => $playlistData->name,
            'user_id' => $input['user_id'],
            'spotify_id' => $input['spotify_id'],
            'external_url' => $playlistData->external_urls->spotify,
        ]);

        $last_updated = $playlistData->tracks->items;

        // create init performance
        $performance = SpotifyPlaylistPerf::updateOrCreate(
            ['date' => Carbon::today()->format('Y-m-d'), 'spotify_playlist_id' => $playlist->id],
            [
                'followers' => $playlistData->followers->total,
                'new_followers' => '0',
                'followers_daily_growth' => '0',
                'last_updated' => Carbon::parse(max($last_updated)->added_at)
            ]
        );

        // on succes redirect
        \Session::flash('flash_success', 'Playlist has been added.');

        return redirect('spotify-playlists');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
