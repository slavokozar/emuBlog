@extends('layout')

@section('content')
    <div class="container">
        <h1 style="padding-bottom: 55px; text-align: center;">Create a new Field</h1>

        @include('admin.partials.form_errors')

        <div class="row">
            <form class="form-horizontal" method="post" action="{{ action('Resort\FieldController@store',[$resort->id]) }}">
                {!! csrf_field() !!}

                <div class="form-group">
                    <label class="col-md-4 control-label" for="name">Name</label>
                    <div class="col-md-4">
                        <input id="name" name="name" type="text" class="form-control input-lg" value="{{old('name')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="max_advance_reservation">Max Advance ...</label>
                    <div class="col-md-4">
                        <input id="max_advance_reservation" name="max_advance_reservation" type="text" class="form-control input-lg" value="{{old('max_advance_reservation')}}">
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-4 control-label" for="sports">Available Sports</label>
                    <div class="col-md-4">
                        <select multiple class="form-control" name="sports[]" id="sports">
                            @foreach($resort->sports as $sport)
                                <option value="{{$sport->id}}" {{old('sports')!=null && in_array($sport->id,old('sports')) ? 'selected':''}}>{{$sport->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <!-- Button (Double) -->
                <div class="form-group">
                    <div class="col-md-6 control-label">
                        <button name="create" class="btn btn-success" type="submit">Create</button>
                        <a href="{{action('Resort\FieldController@index', $resort->id)}}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>

            </form>

        </div>
    </div>
@endsection