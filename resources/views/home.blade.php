@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Spotify Playlists</div>

                <div class="panel-body">
                    <table class="table table-hover">
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
                            @for($i = 0; $i < 20; $i++)
                                <tr>
                                    <td>#1</td>
                                    <td>Today's Top Hits</td>
                                    <td>spotify</td>
                                    <td style="text-align: right">15,828,851</td>
                                    <td style="text-align: right">14,407</td>
                                    <td style="text-align: right">0,09%</td>
                                    <td style="text-align: right">23 hours ago</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
