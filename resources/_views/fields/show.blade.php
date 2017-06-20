@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 header-sport">
                <h1>{{ $field->name }}</h1>

            </div>
            <div class="col-xs-12">
                <h2><span class="label label-primary">General Information</span></h2>
                <table class="table table-hover">
                    <tbody>

                    <tr class="">
                        <td>
                            Games Played
                        </td>
                        <td>
                            250
                        </td>
                    </tr>
                    <tr class="">
                        <td>
                            Schedules Games
                        </td>
                        <td>
                            8
                        </td>
                    </tr>
                    <tr class="">
                        <td>
                            Users
                        </td>
                        <td>
                            850
                        </td>
                    </tr>
                    <tr class="">
                        <td>
                            Rating
                        </td>
                        <td>
                            8.5
                        </td>
                    </tr>
                    </tbody>
                </table>


                <h3><span class="label label-primary">Available Sports</span></h3>

                <div class="sports">
                    @foreach($field->sports as $sport)
                        <img src="http://www.psdgraphics.com/file/football-ball.jpg" style="width: 80px; height: 60px; border-radius: 50%;">
                        <h3>{{ $sport->name }}</h3>
                    @endforeach
                </div>

                </div>

            </div>
        </div>
    </div>
@endsection