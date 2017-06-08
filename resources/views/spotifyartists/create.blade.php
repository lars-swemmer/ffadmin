@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Spotify Artists &middot; Create</div>
                <div class="panel-body">

                    @if(count($errors))
                        <div class="row">
                            <div class="col-md-6">
                                <div class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(Session::has('flash_message'))
                        <div class="row">
                            <div class="col-md-6">
                                <div class="alert alert-danger">
                                    {{ Session::get('flash_message') }}
                                </div>
                            </div>
                        </div>
                    @endif

                    {!! Form::open(['url' => 'spotify-artists']) !!}
                        <div class="form-group">
                            {!! Form::label('artist_id', 'Spotify arist ID') !!}
                            {!! Form::text('artist_id', null, ['class' => 'form-control', 'placeholder' => 'Spotify artist ID']) !!}
                        </div>
                    
                        {!! Form::button('<span class="icon icon-plus"></span> Add artist', array('type' => 'submit', 'class' => 'btn btn-pill btn-primary')) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
