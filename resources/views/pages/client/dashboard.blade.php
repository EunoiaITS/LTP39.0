@extends('layout')
@section('content')

    <!-- main-content area -->
    <div class="dashboard-main-content clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Dashboard</h2>
                    <h4 class="date">Date: <span>19-09-2018</span></h4>
                </div>
                <div class="col-md-5 col-sm-6">
                    <div class="dashboard-total clearfix">
                        <div class="money-icon">
                            <img src="{{ asset('public/assets/img/taka.png') }}" alt="">
                        </div>
                        <div class="total-cost">
                            <h3>23,000</h3>
                            <p>Total Sales</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-md-offset-2 col-sm-offset-0  col-sm-6">
                    <div class="dashboard-total clearfix">
                        <h3 class="total-dash">Total: <span>500</span> </h3>
                        <div class="money-icon">
                            <h4>Current Parking Status</h4>
                        </div>
                        <div class="total-cost parking-pie-chart">
                            <canvas id="chart-area" width="190px" height="190px"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection