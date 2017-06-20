@extends('layout')

@section('content')
    <div class="container">
        <h1 style="padding-bottom: 55px; text-align: center;">Create a new Resort</h1>

        @include('admin.partials.form_errors')

        <div class="row">
            <form class="form-horizontal" method="post" action="">
                {!! csrf_field() !!}

                <div class="form-group">
                    <label class="col-md-4 control-label" for="name">Name</label>
                    <div class="col-md-4">
                        <input name="name" id="name" type="text" class="form-control input-lg" value="{{old('name')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="invoice_recipient">Invoice recipient</label>
                    <div class="col-md-4">
                        <input name="invoice_recipient" id="invoice_recipient" type="text" class="form-control input-lg"
                               value="{{old('invoice_recipient')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="description">Description</label>
                    <div class="col-md-4">
                        <textarea class="form-control" id="description" rows="5" name="description">{{old('description')}}</textarea>
                    </div>
                </div>

                <hr>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="description">Opening Hours</label>
                </div>

                @for($i=1; $i<=5;$i++)
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="description">{{trans('days.'.$i)}}</label>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="row">
                                <label class="col-md-offset-3 col-md-1 control-label" for="invoice_recipient">Open in</label>
                                <div class="col-md-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" min="0" max="23" step="1" name="open_hour{{$i}}" value="{{old('open_hour'.$i)}}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" min="0" max="50" step="10" name="open_minute{{$i}}" value="{{old('open_minute'.$i)}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <label class="col-md-offset-3 col-md-1 control-label" for="invoice_recipient">Close in</label>
                                <div class="col-md-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" min="0" max="23" step="1" name="close_hour{{$i}}" value="{{old('close_hour'.$i)}}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" min="0" max="50" step="10" name="close_minute{{$i}}" value="{{old('close_minute'.$i)}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
                <hr>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="sports">Available Sports</label>
                    <div class="col-md-4">
                        <select class="sports-multiple-select form-control" id="sports" name="sports[]" multiple="multiple">
                            @foreach($sports as $sport)
                                <option value="{{$sport->id}}" {{old('sports')!=null && in_array($sport->id,old('sports')) ? 'selected':''}}>{{$sport->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="facilities">Available Facilities</label>
                    <div class="col-md-4">
                        <select class="facilities-multiple-select form-control" id="facilities" name="facilities[]" multiple="multiple">
                            @foreach($facilities as $facility)
                                <option value="{{$facility->id}}" {{old('facilities')!=null && in_array($facility->id,old('facilities')) ? 'selected':''}}>{{$facility->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="address_street">Address Street</label>
                    <div class="col-md-4">
                        <input name="address_street" type="text" id="address_street" class="form-control input-lg" value="{{old('address_street')}}">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="address_zip">Address Zip</label>
                    <div class="col-md-4">
                        <input name="address_zip" type="text" id="address_zip" class="form-control input-lg" value="{{old('address_zip')}}">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="address_city">Address City</label>
                    <div class="col-md-4">
                        <input name="address_city" type="text" id="address_city" class="form-control input-lg" value="{{old('address_city')}}">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="address_country">Address Country</label>
                    <div class="col-md-4">
                        <input name="address_country" type="text" id="address_country" class="form-control input-lg" value="{{old('address_country')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="address_latitude">Address Latitude</label>
                    <div class="col-md-4">
                        <input name="address_latitude" type="text" id="address_latitude" class="form-control input-lg" value="{{old('address_latitude')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="address_longitude">Address Longitude</label>
                    <div class="col-md-4">
                        <input name="address_longitude" type="text" id="address_longitude" class="form-control input-lg"
                               value="{{old('address_longitude')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="contact_phone">Contact Phone</label>
                    <div class="col-md-4">
                        <input name="contact_phone" type="text" id="contact_phone" class="form-control input-lg" value="{{old('contact_phone')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="contact_email">Contact Email</label>
                    <div class="col-md-4">
                        <input name="contact_email" type="text" id="contact_email" class="form-control input-lg" value="{{old('contact_email')}}">
                    </div>
                </div>

                <!-- Multiple Radios -->
                <div class="form-group">
                    <label class="col-md-4 control-label">Agreement</label>
                    <div class="col-md-4">
                        <div class="checkbox">
                            <label for="agreement">
                                <input type="checkbox" name="agreement" id="agreement" value="1">
                                Agree to terms and conditions ?
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Button (Double) -->
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-4 control-label">
                        <button name="create" class="btn btn-success" type="submit">Create</button>
                        <a class="btn btn-danger" href="{{action('HomeController@resorts')}}">Cancel</a>
                    </div>
                </div>

            </form>

        </div>
    </div>
@endsection


@section('scripts')

    <script type="text/javascript">

		$(".sports-multiple-select").select2();
		$(".facilities-multiple-select").select2();

    </script>


@endsection