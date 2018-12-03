<!-- dashboard sidebar -->
<div class="dashboard-sidebar">
    <div class="sidebar-location clearfix text-center">
        <h4>Dexhub</h4>
    </div>
    <ul class="nav navbar-nav sidebar-scroll-nav" id="sidebar-menu">
        <!-- Dropdown-->
        <li class="panel panel-default active" id="dropdown">
            <a data-toggle="collapse" href="#dropdown-lvl1">
                Device<span class="icon-right"></span>
            </a>
            <!-- Dropdown level 1 -->
            <div id="dropdown-lvl1" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/create-device') }}">Create Device</a></li>
                        <li><a href="{{ url('/manage-device') }}">Manage Device</a></li>
                    </ul>
                </div>
            </div>
        </li>
        <!-- Dropdown-->
        <li class="panel panel-default active" id="dropdown">
            <a data-toggle="collapse" href="#dropdown-lvl2">
                Client<span class="icon-right"></span>
            </a>
            <!-- Dropdown level 1 -->
            <div id="dropdown-lvl2" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/create-client') }}">Create Client</a></li>
                        <li><a href="{{ url('/clients-list?type=park') }}">Manage Client</a></li>
                    </ul>
                </div>
            </div>
        </li>
        <!-- Dropdown-->
        <li class="panel panel-default active" id="dropdown">
            <a data-toggle="collapse" href="#dropdown-lvl3">
                Billing <span class="notification"><i class="far fa-bell"></i></span> <span class="icon-right"></span>
            </a>
            <!-- Dropdown level 1 -->
            <div id="dropdown-lvl3" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/create-billing') }}">Create Billing</a></li>
                        <li><a href="{{ url('/manage-billing') }}">Manage Bill</a></li>
                    </ul>
                </div>
            </div>
        </li>
        <li><a href="{{ url('/reports') }}"> Report</a></li>
        <li><a href="{{ url('/create-advert') }}"> Advert</a></li>
    </ul>
</div>
