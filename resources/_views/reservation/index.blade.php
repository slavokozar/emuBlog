@extends('layout')


@section('content')
    <div class="container">
        <div class="row">
            @if(isset($resort))
                <h1>Reservations for <a href="{{action('Resort\ResortController@show', $resort->id)}}">{{$resort->name}}</a></h1>
            @else
                <h1>Your reservations</h1>
            @endif

            @if($reservations->count() > 0)

            <div id=reservation-index>
                <table class="table table-hover table-striped reservation-index-table">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Sport</th>
                        <th>Resort</th>
                        <th>Price</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>


                    @foreach($reservations as $reservation)
                        <tr class="reservation-index-row">
                            <td class="col-md-1">{{ Carbon\Carbon::parse($reservation->date)->format('d-m-Y') }}</td>
                            <td class="col-md-1">{{ Carbon\Carbon::parse($reservation->start)->format('H:i') }}</td>
                            <td class="col-md-1">{{ Carbon\Carbon::parse($reservation->end)->format('H:i') }}</td>
                            <td class="col-md-2">{{ $reservation->sport->name }}</td>
                            <td class="col-md-2">
                                <a href="{{ action('Resort\ResortController@show',[$reservation->resort->id]) }}">
                                    {{ $reservation->resort->name }}
                                </a>
                            </td>
                            <td class="col-md-2">{{ $reservation->price }}</td>
                            <td class="col-md-3 text-right">
                                @if(isset($resort))
                                    <a href="{{action('Resort/ReservationController@show', $resort->id, $reservation->id)}}" target="_blank"
                                       class="btn btn-primary">Detail</a>
                                    <a href="{{action('Resort/ReservationController@edit', $resort->id, $reservation->id)}}"
                                       class="btn btn-info">Edit</a>

                                    <form class="remove-form"
                                          action="{{action('Resort/ReservationController@destroy', $resort->id, $reservation->id)}}"
                                          method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                @else
                                    <a href="{{action('ReservationController@show', $reservation->id)}}" target="_blank"
                                       class="btn btn-primary">Detail</a>
                                    <a href="{{action('ReservationController@edit', $reservation->id)}}"
                                       class="btn btn-info">Edit</a>

                                    <form class="remove-form"
                                          action="{{action('ReservationController@destroy', $reservation->id)}}"
                                          method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {{ $reservations->links() }}
            </div>
            @else
                <p>There are no reservations for this resort!</p>
            @endif

        </div>

    </div>
@endsection