<body>

<div class="parking-kori-dashboard clearfix">
    <!-- dashboard header -->
    <div class="dashboard-header navbar-fixed-top">
        <div class="container-fluid">
            <div class="col-sm-3 col-xs-2">
                <div class="slide-drawer-menu">
                    <span class="menu-icon"></span>
                    <span class="menu-icon menu-icon-small"></span>
                    <span class="menu-icon"></span>
                </div>
            </div>
            <div class="col-sm-6 col-xs-8">
                <div class="parking-kori-dash-logo text-center">
                    <a href="{{ url('/') }}"><img src="{{ asset('public/assets/img/pklogo.png') }}" alt="parking kori"></a>
                </div>
            </div>
            <div class="col-sm-3 col-xs-2">
                <div class="user-icon">
                    <img src="{{ asset('public/assets/img/user-icon.png') }}" alt="user-icon">
                </div>
                <div class="user-dropdown">
                    <ul>
                        <li><a href="#" class="name">Jhon</a></li>
                        <li><a href="#" class="logout" data-toggle="modal" data-target="#logout-modal">Log Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>