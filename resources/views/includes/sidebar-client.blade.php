<!-- dashboard sidebar -->
<div class="dashboard-sidebar">
    <div class="sidebar-location clearfix text-center">
        <h4>{{ Auth::user()->name }}</h4>
    </div>
    <ul class="nav navbar-nav sidebar-scroll-nav" id="sidebar-menu">
        <!-- Dropdown-->
        <li class="panel panel-default active" id="dropdown">
            <a data-toggle="collapse" href="#dropdown-lvl1">
                Employee<span class="icon-right"></span>
            </a>
            <!-- Dropdown level 1 -->
            <div id="dropdown-lvl1" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/create-employee') }}">Create Employee</a></li>
                        <li><a href="{{ url('/manage-employee') }}">Manage Employee</a></li>
                    </ul>
                </div>
            </div>
        </li>
        <!-- Dropdown-->
        <li class="panel panel-default active " id="dropdown">
            <a data-toggle="collapse" href="#dropdown-lvl2">
                Reports<span class="icon-right"></span>
            </a>
            <!-- Dropdown level 1 -->
            <div id="dropdown-lvl2" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/report/vehicle-category') }}">Vehicle Category</a></li>
                        <li><a href="{{ url('/report/user-incomes') }}">Users' Income (Check Out)</a></li>
                        <li><a href="{{ url('/report/sales') }}">Sales</a></li>
                    </ul>
                </div>
            </div>
        </li>
        <!-- Dropdown-->
        <li class="panel panel-default active" id="dropdown">
            <a data-toggle="collapse" href="#dropdown-lvl3">
                VIP<span class="icon-right"></span>
            </a>
            <!-- Dropdown level 1 -->
            <div id="dropdown-lvl3" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/vip-requests') }}">New Request Notification</a></li>
                        <li><a href="{{ url('/vip-list') }}">VIP User List</a></li>
                        <li><a href="{{ url('/vip-reject-list') }}">VIP Reject List</a></li>
                    </ul>
                </div>
            </div>
        </li>
        <!-- Dropdown-->
        <li class="panel panel-default active" id="dropdown">
            <a data-toggle="collapse" href="#dropdown-lvl4">
                Settings<span class="icon-right"></span>
            </a>
            <!-- Dropdown level 1 -->
            <div id="dropdown-lvl4" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul class="nav navbar-nav">
                        <!-- Dropdown-->
                        <li class="panel panel-default active" id="dropdown">
                            <a data-toggle="collapse" href="#dropdown-lvl5">
                                Parking<span class="icon-right"></span>
                            </a>
                            <!-- Dropdown level 1 -->
                            <div id="dropdown-lvl5" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul class="nav navbar-nav">
                                        <li><a class="active" href="{{ url('/settings/vehicle-types') }}">Vehicle Category</a></li>
                                        <li><a href="{{ url('/settings/assign-parking') }}">Assign Parking</a></li>
                                        <li><a href="{{ url('/settings/assign-rate') }}">Assign Hour Rate</a></li>
                                        <li><a href="{{ url('/settings/exempted-setting') }}">Exempted Duration/Time</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        {{--<li><a href="{{ url('/settings/vip-parking') }}">Assign VIP Parking Rate</a></li>--}}
                        <li><a href="{{ url('/settings/vat') }}">VAT</a></li>
                        <li><a href="{{ url('/settings/additional') }}">Additional</a></li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>
</div>
