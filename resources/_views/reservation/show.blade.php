@extends('layout')


@section('content')
    <div class="container">
        <section class="reservation-show-detail">
            <div class="row">
                <h1>Your reservation</h1>
                <div class="col-md-6">
                    <table class=table>
                        <caption>Detail</caption>
                        <tbody>
                        <tr>
                            <th scope=row>Date</th>
                            <td>{{ $reservation->date}}</td>
                        </tr>
                        <tr>
                            <th scope=row>Start Time</th>
                            <td>{{ $reservation->start}}</td>
                        </tr>

                        <tr>
                            <th scope=row>End Time</th>
                            <td>{{ $reservation->end }}</td>
                        </tr>

                        <tr>
                            <th scope=row>Sport</th>
                            <td>{{ $reservation->sport->name }}</td>
                        </tr>

                        <tr>
                            <th scope=row>Resort</th>
                            <td><a href="{{ action('Resort\ResortController@show',[$reservation->resort->id]) }}">
                                    {{ $reservation->resort->name }}</a></td>
                        </tr>

                        <tr>
                            <th scope=row>Feild</th>
                            <td>{{ $reservation->field->name }}</td>
                        </tr>

                        <tr>
                            <th scope=row>Price</th>
                            <td>{{ $reservation->price }}</td>
                        </tr>

                        </tbody>
                    </table>

                    <div class="text-right">
                        <a href="{{action('ReservationController@edit', $reservation->id)}}"
                           class="btn btn-info">Edit</a>

                        <form class="remove-form" action="{{action('ReservationController@destroy', $reservation->id)}}"
                              method="post">
                            {!! csrf_field() !!}
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>

                <div id="resort_map" class="col-md-6" style="height: 400px;">
                    <input type="hidden" id="map-resort" value="{{$reservation->resort}}">
                    <input type="hidden" id="map-lat" value="{{$reservation->resort->address_latitude}}">
                    <input type="hidden" id="map-lon" value="{{$reservation->resort->address_longitude}}">
                </div>


            </div>
        </section>
        <section class="reservation-show-resort">
            <div class="row">
                <h2>
                    <a href="{{ action('Resort\ResortController@show',[$reservation->resort->id]) }}">{{$reservation->resort->name}}</a>
                </h2>
                <div class="col-md-6 text-center">

                    @if($reservation->resort->images->first())

                    <img src="{{ asset($reservation->resort->images->first()->path) }}" alt="{{$reservation->resort->name}}" width="450px">
                    @else
                        <img src="http://placehold.it/450x300" alt="Image"
                                style="max-width:100%;" class="img-responsive center-block">
                    @endif


                </div>

                <div class="col-md-6">
                    <table class="table">
                        <caption>Information</caption>
                        <tbody>
                        <tr>
                            <th scope="row">Address</th>
                            <td>{{$reservation->resort->address_street}}
                                {{$reservation->resort->address_zip}}
                                {{$reservation->resort->address_city}}
                            </td>
                        </tr>
                        <tr>
                            <th scope=row>Phone</th>
                            <td>{{$reservation->resort->contact_phone}} </td>
                        </tr>
                        <tr>>
                            <th scope=row>Email</th>
                            <td>{{$reservation->resort->contact_email}}</td>
                        </tr>

                        <tr>
                            <th scope=row>Opening hours</th>
                            <td>{{ $open }}
                                -
                                {{ $close }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </section>


    </div>





@endsection

@section('scripts')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBj-Ef6CWzOzl7MloXshvaOpCctWffBtG8"></script>
    <script src="{{asset('js/embed-map.js')}}"></script>
@endsection