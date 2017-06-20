<nav id="custom-navbar" class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{action('HomeController@index')}}">Sport&#95;<span class="nav-emu">EMU</span></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
            {{--<li><a href="{{ action('HomeController@teams') }}">teams</a></li>--}}
            {{--<li><a href="{{ action('HomeController@resorts') }}">resorts</a></li>--}}
            {{--<li><a href="{{ action('HomeController@instructors') }}">instructors</a></li>--}}

            <!-- Authentication Links -->
                @if (Auth::guest())
                    <div class="nav-start">
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    </div>
                @else

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">

                            <li>
                                <a href="{{ action('UserController@show', [Auth::user()->id]) }}"><i
                                            class="fa fa-fw fa-btn fa-user"></i> Profile</a>
                            </li>

                            {{-- ak mam nejake rezervacie --}}
                            <li>
                                <a href="{{ action('ReservationController@index') }}"><i
                                            class="fa fa-fw fa-list-ul"></i> Reservations</a>
                            </li>

                            {{-- ak mam nejake strediska --}}
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="{{ action('ReservationController@index') }}"><i
                                            class="fa fa-fw fa-th-large"></i> Resorts</a>
                            </li>

                            {{-- logout --}}
                            <li role="separator" class="divider"></li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    {{ csrf_field() }}
                                    <button class="" type="submit" name="submitBtn"><i class="fa fa-fw fa-sign-out"></i>
                                        Log out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div><!--/.navbar-collapse -->
    </div>
</nav>
