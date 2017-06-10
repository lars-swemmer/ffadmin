<?php

namespace App\Console\Commands;

use App\SpotifyAuth;
use App\SpotifyPlaylist;
use App\SpotifyPlaylistPerf;
use Carbon\Carbon;
use Illuminate\Console\Command;
use SpotifyWebAPI;

class SaveSpotifyPlaylistPerf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spotify:playlistPerf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieves spotify playlist performance';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // to-do: refactor code
        // retrieve all playlists from db
        $spotifyPlaylists = SpotifyPlaylist::all();
        $spotifyAuthentication = SpotifyAuth::first();

        // Refresh token (always the case)
        $refreshToken = $spotifyAuthentication->refreshToken;
        $session = new SpotifyWebAPI\Session(env('SPOTIFY_CLIENT_ID'), env('SPOTIFY_CLIENT_SECRET'), env('SPOTIFY_REDIRECT_URI'));
        $session->refreshAccessToken($refreshToken);
        $accessToken = $session->getAccessToken();

        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        foreach($spotifyPlaylists as $playlist) {
            try {
                $playlistData = $api->getUserPlaylist($playlist->user_id, $playlist->spotify_id);

                $this->info($playlist->name);
                $this->info($playlistData->followers->total);

                $followersYesterday = SpotifyPlaylistPerf::whereDate('date', Carbon::yesterday())->where('spotify_playlist_id', $playlist->id)->pluck('followers')->first();
                // to-do short if code
                if(!$followersYesterday == null) {
                    $diff = $playlistData->followers->total - $followersYesterday;
                    $growth = ($playlistData->followers->total - $followersYesterday)/$followersYesterday*100;
                } else {
                    $diff = 0;
                    $growth = 0;
                }

                $last_updated = $playlistData->tracks->items;

                $performance = SpotifyPlaylistPerf::updateOrCreate(
                    ['date' => Carbon::today()->format('Y-m-d'), 'spotify_playlist_id' => $playlist->id],
                    [
                        'followers' => $playlistData->followers->total,
                        'new_followers' => $diff,
                        'followers_daily_growth' => $growth,
                        'last_updated' => Carbon::parse(max($last_updated)->added_at)
                    ]
                );
            }
            catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        }
        
        $this->info('completed on '.Carbon::today());
    }
}
