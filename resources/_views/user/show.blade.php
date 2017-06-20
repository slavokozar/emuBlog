
@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>{{ Auth::user()->name }}</h1>
                <div class="row">
                    <div class="col-xs-3 col-md-3">
                        <a href="#" class="thumbnail">
                            <img src="{{ Auth::user()->image }}" alt="...">
                        </a>
                    </div>

                    <form class="form-horizontal" enctype="multipart/form-data" action="" method="POST">
                        <h5>Change your picture</h5>
                        <input type="file" class="btn btn-primary" name="avatar" value="Choose file">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary" value="Upload">
                            </div>
                        </div>
                    </form>

                    <div class="col-md-9">
                        Something about searching through old reservations
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h2>Additional information</h2>
                <p><strong>Nickname:</strong> {{ Auth::user()->nickname }}</p>
                <p><strong>Age:</strong> {{ Auth::user()->age }}</p>
                <p><strong>Gender:</strong> {{ Auth::user()->gender }}</p>
                <p><strong>Phone:</strong>: {{ Auth::user()->phone }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p><strong>Facebook:</strong> {{ Auth::user()->facebook_id }}</p>
                <p><strong>Google +:</strong> {{ Auth::user()->google_id }}</p>
            </div>
            <div class="col-md-12">
                <select class="selectpicker" >
                    <option>last week</option>
                    <option>last month</option>
                    <option>last year</option>
                </select>
                <button type="button" class="btn btn-primary btn-sm filter">Filter</button>
            </div>
            <div class="col-md-7 booking_table" >
                <div class = "table-responsive">
                    <table class = "table">
                        <caption>Your last bookings</caption>
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Sport</th>
                            <th>Sport centre</th>
                            <th>Instructors</th>
                            <th>Price</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($reservation as $reservation_item)
                            <tr>
                                <td>{{ Carbon\Carbon::parse($reservation_item->date)->format('d-m-Y') }}</td>
                                <td>{{ $reservation_item->sport->name }}</td>
                                <td>{{ $reservation_item->resort->name }}</td>
                                <td>{{ $reservation_item->instructor }}</td>
                                <td>{{ $reservation_item->price }} Kc</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
                <div class="text-center">
                    {{ $reservation->links() }}
                </div>
            </div>
            <div class="col-md-5 booking_chart">
                <h2>Chart of booking</h2>
                <img src="http://icons.iconarchive.com/icons/iconsmind/outline/512/Line-Chart-icon.png" class="img-responsive" alt="" width="280" height="150">
            </div>
        </div>
    </div>
@endsection