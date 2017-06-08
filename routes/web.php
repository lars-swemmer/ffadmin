<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/spotify-auth', 'SpotifyAuthController@index')->name('spotify-auth');
Route::get('/spotify-callback', 'SpotifyAuthController@callback')->name('spotify-callback');

// SpotifyArtist resource
Route::resource('spotify-artists', 'SpotifyArtistController', ['except' => ['edit', 'update']]);

// SpotifyPlaylist resource
Route::resource('spotify-playlists', 'SpotifyPlaylistController', ['except' => ['edit', 'update']]);
