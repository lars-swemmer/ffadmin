@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Spotify Playlists &middot; {{ Carbon\Carbon::today()->format('d M Y') }}
                    <a href="{{ route('spotify-playlists.create') }}" class="pull-right"><span class="icon icon-plus"></span> Add playlist</a>
                    
                </div>
                <div class="panel-body">
                
                    @if(Session::has('flash_success'))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success">
                                    {{ Session::get('flash_success') }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <table class="table table-hover" data-sort="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Owner</th>
                                <th style="text-align: right">Followers</th>
                                <th style="text-align: right">New followers</th>
                                <th style="text-align: right">Daily growth</th>
                                <th style="text-align: right">Last updated</th>
                            </tr>
                        </thead>
                        <tbody>

                        	@if($spotifyPerformances->first())
                                @foreach($spotifyPerformances as $key => $performance)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $performance->spotifyPlaylist->name }}</td>
                                        <td>{{ $performance->spotifyPlaylist->user_id }}</td>
                                        <td style="text-align: right">{{ number_format($performance->followers, 0, ',', ',') }}</td>
                                        <td style="text-align: right">{{ number_format($performance->new_followers, 0, ',', ',') }}</td>
                                        <td style="text-align: right">{{ number_format($performance->followers_daily_growth, 2, ',', ',') }}</td>
                                        <td style="text-align: right">{{ Carbon\Carbon::parse($performance->last_updated)->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td><small class="text-muted">No data yet</small></td>
                                    <td><small class="text-muted">-</td>
                                    <td><small class="text-muted">-</td>
                                    <td style="text-align: right"><small class="text-muted">-</td>
                                    <td style="text-align: right"><small class="text-muted">-</td>
                                    <td style="text-align: right"><small class="text-muted">-</td>
                                    <td style="text-align: right"><small class="text-muted">-</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
