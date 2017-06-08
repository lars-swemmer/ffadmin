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

                    Hier table data
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
