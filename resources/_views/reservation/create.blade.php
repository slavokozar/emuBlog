@extends('layout')

@section('content')
<div class="container">
    <div class="row">
    <h1 class="text-center">Reservation form</h1>
    @if (count($errors) > 0)
        <div class="container">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="container reservation-create-background">
        <form id="reservation-form" action="{{action('ReservationController@store')}}" method="post">
            {!! csrf_field() !!}
            <input type="hidden" name="sport_id" value="{{$sport_id}}">
            <input type="hidden" name="resort_id" value="{{$resort_id}}">
            <input type="hidden" name="opened" value="1">
            <input type="hidden" name="meet_info" value="jjjj">
            <input type="hidden" name="contact_phone" value="+8888">
            <div class="row form-margin-top">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label col-sm-6 control-label" for="date">Selected date</label>
                        <div class="col-sm-6">
                            <input type="date" value="{{$date}}{{ old('date') }}" name="date" class="form-control" id="date">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label col-sm-6 control-label" for="start-time">Select your starting time</label>
                        <div class="col-sm-6">
                            <input type="time" name="start" value="{{$time}}{{ old('start') }}" step="1800" class="form-control" id="start-time">
                        </div>
                    </div>
                </div>
            </div>


            <div class="row form-margin-top">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label col-sm-6 control-label" for="end-time">Select your ending time</label>
                        <div class="col-sm-6">
                            <input type="time" name="end" id="end-time" value="{{$time}}{{ old('end') }}" step="1800" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label col-sm-6 control-label"  for="field_id">Please select the court number</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="field_id" id="field_id">
                                @foreach($fields as $field)
                                    <option value="{{$field->id}}">{{$field->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-center form-margin-top">
                <label class="control-label col-sm-12" for="reservation-checksum">Total price of your reservation:</label>
                <div class="col-sm-12">
                    <input class="text-center form-control col-sm-6 offset-md-3 "  id="reservation-checksum" type="text" name="price" value="{{$prices->price}}" readonly>
                </div>
            </div>
            <div class="row text-center form-margin-top">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary btn-lg ">Create reservation</button>
                </div>

            </div>
        </form>
    </div>
      </div>
  </div>
@endsection

@section('scripts')
    <script>
        $('#reservation-form input').change(function(){
            var data = $('#reservation-form').serialize()

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