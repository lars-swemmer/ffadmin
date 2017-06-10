<?php

namespace App\Console\Commands;

use App\SpotifyArtist;
use App\SpotifyArtistPerf;
use App\SpotifyAuth;
use Carbon\Carbon;
use Illuminate\Console\Command;
use SpotifyWebAPI;

class SaveSpotifyArtistPerf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spotify:artistPerf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieves spotify artist performance';

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
        $spotifyAuthentication = SpotifyAuth::first();

        // Refresh token (always the case)
        $refreshToken = $spotifyAuthentication->refreshToken;
        $session = new SpotifyWebAPI\Session(env('SPOTIFY_CLIENT_ID'), env('SPOTIFY_CLIENT_SECRET'), env('SPOTIFY_REDIRECT_URI'));
        $session->refreshAccessToken($refreshToken);
        $accessToken = $session->getAccessToken();

        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        // haal alle artiesten op uit database per 5(0)
        SpotifyArtist::chunk(50, function ($spotifyArtists) use($api) {
            // haal alle artiesten op uit de Spotify API
            $artistSpotifyData = $api->getArtists($spotifyArtists->pluck('spotify_id')->toArray()); // hier zit alle artist data uit spotify

            // loop voor elke artiest en zoek bijbehorende followers aantal aan de hand van spotify id
            foreach($spotifyArtists as $artist) {
                try {
                    // haal alle ids op van spotify api en zet volgers erachter zodat we hierop kunnne zoeken en juiste waarders aan elkaar kunnen koppelen
                    $spotify_followers = array_column($artistSpotifyData->artists, 'followers', 'id');
                    $spotify_popularity = array_column($artistSpotifyData->artists, 'popularity', 'id');

                    // haal artiest de resultaten van gisteren op
                    $followersYesterday = SpotifyArtistPerf::whereDate('date', Carbon::yesterday())->where('spotify_artist_id', $artist->id)->pluck('followers')->first();
                    if(!$followersYesterday == null) {
                        $new_followers = $spotify_followers[$artist->spotify_id]->total - $followersYesterday;
                    } else {
                        $new_followers = 0;
                    }

                    $popularityYesterday = SpotifyArtistPerf::whereDate('date', Carbon::yesterday())->where('spotify_artist_id', $artist->id)->pluck('popularity')->first();
                    if(!$popularityYesterday == null) {
                        $new_popularity = $spotify_popularity[$artist->spotify_id] - $popularityYesterday;
                    } else {
                        $new_popularity = 0;
                    }

                    // create performance voor de artiest en koppel juiste followers aantal die uit spotify api is gehaald
                    $performance = SpotifyArtistPerf::updateOrCreate(
                        ['date' => Carbon::today()->format('Y-m-d'), 'spotify_artist_id' => $artist->id],
                        [
                            'followers' => $spotify_followers[$artist->spotify_id]->total,
                            'new_followers' => $new_followers,
                            'popularity' => $spotify_popularity[$artist->spotify_id],
                            'new_popularity' => $new_popularity
                        ]
                    );
                }
                catch (\Exception $e) {
                    $this->error($e->getMessage());
                }
            }
        });

        $this->info('spotify:artistPerformance completed on: '.Carbon::today());
    }
}
