@extends('layout')

@section('content')
    <div class="container">
        <h1 style="padding-bottom: 55px; text-align: center;">Editing a Field</h1>
        <div class="row">
            <div class="col-xs-12">
                <form class="form-horizontal" method="post" action="{{action('Resort\FieldController@update',[$resort->id, $field->id])}}">
                    <fieldset>
                    {!! csrf_field() !!}
                        <!-- Text input-->
                        <input name="_method" type="hidden" value="PATCH">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">Name</label>
                            <div class="col-md-4">
                                <input id="textinput" name="name" type="text" value="{{$field->name}}" class="form-control input-lg">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="max_advance_reservation">Max Advance ...</label>
                            <div class="col-md-4">
                                <input id="textinput" name="max_advance_reservation" value="{{$field->max_advance_reservation}}" type="text" class="form-control input-lg">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="sports">Available Sports</label>
                            <div class="col-md-4">
                                <select multiple class="form-control" name="sports[]">
                                    @foreach($resort->sports as $sport)
                                        <option value="{{$sport->id}}" {{$fieldSports->contains($sport) ? 'selected':''}}>{{$sport->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <!-- Button (Double) -->
                        <div class="form-group">
                            <div class="col-md-6 control-label">
                                <button name="update" class="btn btn-success" type="submit">Save</button>
                                <a class="btn btn-danger" href="{{action('Resort\ResortController@index')}}">Cancel</a>
                            </div>
                        </div>

                    </fieldset>
                </form>

            </div>
        </div>
    </div>
@endsection