@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Spotify Authentication</div>
                <div class="panel-body">
                    @if(!empty($spotifyAuth))
                        <a href="{{ $oauthUrl }}" class="btn btn-lg btn-pill btn-success disabled"><span class="icon icon-check"></span> Connected to Spotify</a>

                        <div style="margin-top: 10px;">
                            <a href="{{ $oauthUrl }}" class="text-muted">Connect again...</a>
                        </div>
                    @else
                        <a href="{{ $oauthUrl }}" class="btn btn-lg btn-pill btn-primary">Log in to Spotify</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
