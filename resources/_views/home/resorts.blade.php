@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Sport Resorts</h1>

                <h2><span style="padding-right: 45px;"><a href="{{action('Resort\ResortController@index')}}" class="btn btn-link">All resorts in system</a></span>


                <a href="{{action('Resort\ResortController@create')}}" class="btn btn-link">Create new resort</a></h2>



                {{--<h3>Information about the sport centre:</h3>--}}
                {{--<p>{{ $resorts->description }}</p>--}}

                {{--<h4>How to get there?</h4>--}}
                {{--<p>{{ $resorts->address_street }}, {{ $resorts->address_city }}, {{ $resorts->address_zip }}</p>--}}

                {{--<ul class="list-unstyled">--}}
                    {{--<li style="padding-bottom: 5px;"><a href="{{action('ReservationController@create')}}" class="btn  btn-default" role="button">Book</a></li>--}}
                {{--</ul>--}}

                {{--<div id="map" class="map"></div>--}}



            </div>
        </div>
    </div>
@endsection

