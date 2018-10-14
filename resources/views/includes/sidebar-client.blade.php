<!-- dashboard sidebar -->
<div class="dashboard-sidebar">
    <div class="sidebar-location clearfix text-center">
        <h4>Bashundhara city</h4>
    </div>
    <ul class="nav navbar-nav">
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
                        <li><a href="vehicle-category.html">Vehicle Category</a></li>
                        <li><a href="user-income.html">Users income(check Out)</a></li>
                        <li><a href="sales-report.html">Sales</a></li>
                        <li><a href="ticket-report.html">Ticket</a></li>
                        <li><a href="receipt-report.html">Receipt</a></li>
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
                        <li><a href="new-request-notification.html">New Request Notification</a></li>
                        <li><a href="vip-user-list.html">VIP user List</a></li>
                        <li><a href="vip-reject-list.html">VIP rejct List</a></li>
                    </ul>
                </div>
            </div>
        </li>
        <!-- Dropdown-->
        <li class="panel panel-default active active-employee" id="dropdown">
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
                                        <li><a href="{{ url('/settings/exempted-setting') }}">Exampted Duration/Time</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><a href="assign-vip-parking.html">Assign VIP Parking Rate</a></li>
                        <li><a href="{{ url('/settings/vat') }}">VAT</a></li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>
</div>