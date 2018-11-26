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
                                <select class="form-control get-select-picker" id="exampleFormControlSelect1" title="Clients List" multiple data-size="6">
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- pie chart -->
                    <div class="col-sm-12 padding-0">
                        @foreach($users as $u)
                        <div class="col-sm-6 col-md-4">
                            <div class="dashboard-total clearfix">
                                <h3 class="total-dash"> {{ $u->name }} </h3>
                                <div class="money-icon">
                                    <h4>Current Parking Status</h4>
                                </div>
                                <div class="total-cost parking-pie-chart">
                                    <canvas id="chart-area{{$u->id}}" width="200px" height="200px"/>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- pagination -->
                    <div class=" col-sm-12 bootstrap-pagination">
                        <nav aria-label="Page navigation example">
                            {{ $users->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection