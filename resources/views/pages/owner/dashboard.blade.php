@extends('layout')
@section('content')

<!-- main-content area -->
<div class="dashboard-main-content clearfix">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 dashboad-title">
                <h2>Dashboard</h2>
                <h4 class="date">Date: <span>{{ date('d-m-Y') }}</span></h4>
            </div>
            <div class="col-md-5 col-sm-6">
                <div class="dashboard-total clearfix">
                    <div class="money-icon">
                        <img src="{{ asset('public/assets/img/user.png') }}" alt="">
                    </div>
                    <div class="total-cost">
                        <h3>{{ $clients }}</h3>
                        <p>Total Client</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-2 col-sm-offset-0  col-sm-6">
                <div class="dashboard-total clearfix">
                    <div class="money-icon">
                        <img src="{{ asset('public/assets/img/taka.png') }}" alt="">
                    </div>
                    <div class="total-cost">
                        <h3>{{ $bill }}</h3>
                        <p>Total Sale</p>
                    </div>
                </div>
            </div>
            <!-- select client -->
            <div class="col-sm-12">
                <div class="employee-form form-employee-center">
                    <div class="col-sm-4">
                        <div class="vechicle-select">
                            <div class="form-group">
                                <select class="form-control get-select-picker" id="exampleFormControlSelect1" title="Vechile Category" multiple data-size="6">
                                    <option value="">All</option>
                                    <option value="">Client 01</option>
                                    <option value="">Client 02</option>
                                    <option value="">Client 03</option>
                                    <option value="">Client 04</option>
                                    <option value="">Client 05</option>
                                    <option value="">Client 06</option>
                                    <option value="">Client 07</option>
                                    <option value="">Client 08</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- pie chart -->
                    <div class="col-sm-12 padding-0">
                        <div class="col-sm-6 col-md-4">
                            <div class="dashboard-total clearfix">
                                <h3 class="total-dash"> Client One </h3>
                                <div class="money-icon">
                                    <h4>Current Parking Status</h4>
                                </div>
                                <div class="total-cost parking-pie-chart">
                                    <canvas id="chart-area" width="200px" height="200px"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="dashboard-total clearfix">
                                <h3 class="total-dash"> Client Two </h3>
                                <div class="money-icon">
                                    <h4>Current Parking Status</h4>
                                </div>
                                <div class="total-cost parking-pie-chart">
                                    <canvas id="chart-area-2" width="200px" height="200px"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-sm-offset-3 col-md-offset-0 col-md-4">
                            <div class="dashboard-total clearfix">
                                <h3 class="total-dash"> Client Three </h3>
                                <div class="money-icon">
                                    <h4>Current Parking Status</h4>
                                </div>
                                <div class="total-cost parking-pie-chart">
                                    <canvas id="chart-area-3" width="200px" height="200px"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- pagination -->
                    <div class=" col-sm-12 bootstrap-pagination">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection