<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="{{action('Admin\AdminController@index')}}" class="site_title">
            {{--<i class="fa fa-paw"></i>--}}
            {{--<img src="{{asset('assets_admin/img/logo.png')}}" alt="sportEMU logo">--}}
            {{--<span>sportEMU</span>--}}
            <h1>sportEMU</h1>
        </a>
    </div>

    <div class="clearfix"></div>
    <br/>

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <h3>Administration</h3>
            <ul class="nav side-menu">
                <li><a href="{{action('Admin\AdminController@index')}}"><i class="fa fa-fw fa-home"></i> Home</a></li>
                <li><a href="{{action('Admin\SportController@index')}}"><i class="fa fa-fw fa-futbol-o"></i> Sports</a></li>
                <li><a href="{{action('Admin\FacilityController@index')}}"><i class="fa fa-fw fa-shower"></i> Facilities</a></li>

            </ul>
        </div>

    </div>
    <!-- /sidebar menu -->
</div>