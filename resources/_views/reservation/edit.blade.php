@extends('layout')


@section('content')
    <div class="container">
        <div class="row">

    <h1>Edit reservation form</h1>

    <h2>Please edit below your reservation for sport at sport center {{$reservation->resort_id}}</h2>


    <div class="container">
        @if(isset($resort))
        <form id="edit-form" action="{{action('Resort\ReservationController@update', $reservation->id)}}" method="post">
           
        @else
             <form id="edit-form" action="{{action('ReservationController@update', $reservation->id)}}" method="post">
        @endif
            {!! csrf_field() !!}
            
            <input type="hidden" name="sport_id" value="{{$reservation->sport_id}}">
            <input type="hidden" name="resort_id" value="{{$reservation->resort_id}}">
            <input type="hidden" name="opened" value="{{$reservation->opened}}">
            <input type="hidden" name="meet_info" value="{{$reservation->meet_info}}">
            <input type="hidden" name="contact_phone" value="{{$reservation->contact_phone}}">
            <input type="hidden" name="field_id" value="{{$reservation->field_id}}">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label col-sm-5 control-label" for="date">Selected date</label>
                        <div class="col-sm-7">
                            <input type="date" value="{{$reservation->date}}" name="date" class="form-control" id="date">
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label col-sm-7 control-label" for="start-time">Select your starting time</label>
                        <div class="col-sm-5">
                            <input type="time" name="start" value="{{$reservation->start}}" step="1800" class="form-control" id="start-time">
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label col-sm-7 control-label" for="end-time">Select your ending time</label>
                        <div class="col-sm-5">
                            <input type="time" name="end" id="end-time" value="{{$reservation->end}}" step="1800" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row text-center form-margin-top">
                    <label class="control-label col-sm-12" for="reservation-checksum">Total price of your reservation:</label>
                    <div class="col-sm-12">
                        <input class="text-center form-control col-sm-6 offset-md-3 "  id="reservation-checksum" type="text" name="price" value="{{$reservation->price}}" readonly>
                    </div>
                </div>
                <div class="row text-center form-margin-top">
                    <div class="col-sm-12">
                    
                        <button type="submit" name="_method" value="PATCH" class="btn btn-danger">Update</button>
                    </div>

                </div>

            </div>
        </form>
    </div>
    {{--<select>--}}
        {{--<option value="{{$field->id}}" {{ $field->id == $reservation->field_id ? 'selected' : '' }}>{{$field->name}}</option>--}}
    {{--</select>--}}



    {{--<input type="datetime" value="{{$reservation->date}}">--}}
    </div>
    </div>
    @endsection

    @section('scripts')
        <script>
            $('#edit-form').find('input').change(function(){
                var data = $('#edit-form').serialize()

                $.ajax({
                    'url' : '{{action('ReservationController@recalculate')}}',
                    'method' : 'post',
                    'data' : data
                }).done(function(message){

                    $('#reservation-checksum').val(message);

            }).fail(function(){
                alert('something goes wrong');
            })
        })


    </script>
@endsection