@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Spotify Artists
                    <a href="{{ route('spotify-artists.create') }}" class="pull-right"><span class="icon icon-plus"></span> Add artist</a>
                    
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

                        @if($spotifyPerformances->first())
                            @foreach($spotifyPerformances as $key => $performance)
                                <tr>
                                    <td>{{ (($spotifyPerformances->currentPage() - 1 ) * $spotifyPerformances->perPage() ) + $loop->iteration }}</td>
                                    <td>{{ $performance->spotifyArtist->name }}</td>
                                    <td style="text-align: right">{{ $performance->popularity }}</td>
                                    <td style="text-align: right">{{ $performance->new_popularity }}</td>
                                    <td style="text-align: right">{{ number_format($performance->followers, 0, '', ',') }}</td>
                                    <td style="text-align: right">{{ $performance->new_followers }}</td>
                                </tr>
                            @endforeach
                        @else

                        @endif

                        </tbody>
                    </table>
                    <div class="text-center">
                        {{ $spotifyPerformances->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
