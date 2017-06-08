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
                                <th style="text-align: right">Popularity</th>
                                <th style="text-align: right">Change</th>
                                <th style="text-align: right">Followers</th>
                                <th style="text-align: right">New</th>
                            </tr>
                        </thead>
                        <tbody>

                        	

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
