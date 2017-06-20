@extends('layout')

@section('content')
    <div class="container">
        <h1 style="padding-bottom: 55px; text-align: center;">Edit my ressort</h1>

        @include('admin.partials.form_errors')

        <div class="row">
            <form class="form-horizontal" action="{{action('Resort\ResortController@update', $resort->id)}}" method="post">
                {!! csrf_field() !!}
                <input name="_method" type="hidden" value="PATCH">
                <input type="hidden" name="agreement" value="1">
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="name">Name</label>
                    <div class="col-md-4">
                        <input id="name" name="name" value="{{$resort->name}}" type="text" class="form-control input-lg">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="invoice_recipient">Invoice</label>
                    <div class="col-md-4">
                        <input id="invoice_recipient" name="invoice_recipient" value="{{$resort->invoice_recipient}}" type="text"
                               class="form-control input-lg">
                    </div>
                </div>

                <!-- Textarea -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="description">Description</label>
                    <div class="col-md-4">
                        <textarea class="form-control" rows="5" id="description" name="description">{{$resort->description}}</textarea>
                    </div>
                </div>

                <hr>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="description">Opening Hours</label>
                </div>

                @foreach($openingHours as $openingHour)
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="description">{{trans('days.'.$openingHour->weekday)}}</label>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="row">
                                <label class="col-md-offset-3 col-md-1 control-label" for="invoice_recipient">Open in</label>
                                <div class="col-md-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" min="0" max="23" step="1" name="open_hour{{$openingHour->weekday}}" value="{{explode(':',$openingHour->start)[0]}}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" min="0" max="50" step="10" name="open_minute{{$openingHour->weekday}}" value="{{explode(':',$openingHour->start)[1]}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <label class="col-md-offset-3 col-md-1 control-label" for="invoice_recipient">Close in</label>
                                <div class="col-md-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" min="0" max="23" step="1" name="close_hour{{$openingHour->weekday}}" value="{{explode(':',$openingHour->end)[0]}}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" min="0" max="50" step="10" name="close_minute{{$openingHour->weekday}}" value="{{explode(':',$openingHour->end)[1]}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <hr>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="sports">Available Sports</label>
                    <div class="col-md-4">
                        <select multiple class="form-control" name="sports[]" id="sports">
                            @foreach($sports as $sport)
                                <option value="{{$sport->id}}" {{$resortSports->contains($sport) ? 'selected':''}}>{{$sport->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="facilities">Available Facilities</label>
                    <div class="col-md-4">
                        <select multiple class="form-control" name="facilities[]" id="facilities">
                            @foreach($facilities as $facility)
                                <option value="{{$facility->id}}" {{$resortFacilities->contains($facility) ? 'selected':''}}>{{$facility->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="address_street">Address Street</label>
                    <div class="col-md-4">
                        <input id="address_street" value="{{$resort->address_street}}" name="address_street" type="text" class="form-control input-lg">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="address_zip">Address Zip</label>
                    <div class="col-md-4">
                        <input id="address_zip" value="{{$resort->address_zip}}" name="address_zip" type="text" class="form-control input-lg">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="address_city">Address City</label>
                    <div class="col-md-4">
                        <input id="address_city" value="{{$resort->address_city}}" name="address_city" type="text" class="form-control input-lg">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="address_country">Address Country</label>
                    <div class="col-md-4">
                        <input id="address_country" value="{{$resort->address_country}}" name="address_country" type="text" class="form-control input-lg">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="address_latitude">Address Latitude</label>
                    <div class="col-md-4">
                        <input id="address_latitude" value="{{$resort->address_latitude}}" name="address_latitude" type="text"
                               class="form-control input-lg">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="address_longitude">Address Longitude</label>
                    <div class="col-md-4">
                        <input id="address_longitude" value="{{$resort->address_longitude}}" name="address_longitude" type="text"
                               class="form-control input-lg">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="contact_phone">Contact Phone</label>
                    <div class="col-md-4">
                        <input id="contact_phone" value="{{$resort->contact_phone}}" name="contact_phone" type="text" class="form-control input-lg">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="contact_email">Contact Email</label>
                    <div class="col-md-4">
                        <input id="contact_email" value="{{$resort->contact_email}}" name="contact_email" type="text" class="form-control input-lg">
                    </div>
                </div>

                <!-- Button (Double) -->
                <div class="form-group">
                    <div class="col-md-6 control-label">
                        <button name="update" class="btn btn-success" type="submit">Save</button>
                        <a class="btn btn-danger" href="{{action('Resort\ResortController@index')}}">Cancel</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection