<div class="nav_menu">
    <nav class="" role="navigation">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>

        <ul class="nav navbar-nav navbar-right">
            <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    {{Auth::user()->name}} {{Auth::user()->surname}}
                    <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="#"><i class="fa fa-sign-out pull-right"></i> Odhlásiť</a></li>
                </ul>
            </li>
            <li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-address-card"></i>
                    <span class="badge bg-green">5</span>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                        <div class="text-center">
                            <a href="#">
                                <strong>Všetky registrácie</strong>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>