@extends('layout')
@section('content')

    <!-- main-content area -->
    <div class="dashboard-main-content clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Reports <img src="img/down-arrow.png" alt=""></h2>
                    <h4 class="date">Users income</h4>
                    <h4 class="total-strong"><strong>Total</strong></h4>
                </div>
                <div class="col-sm-12 total-area padding-0">
                    <div class="col-sm-6 col-md-3">
                        <div class="calender-area-date">
                            <div class="date-icon">
                                <span>D</span>
                            </div>
                            <div class="date-timepicker">
                                <h4 class="date-span">{{ $daily }}</h4>
                                <div class="per">+5%</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="calender-area-date">
                            <div class="date-icon">
                                <span>W</span>
                            </div>
                            <div class="date-timepicker">
                                <h4 class="date-span">{{ $weekly }}</h4>
                                <div class="per">+5%</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="calender-area-date">
                            <div class="date-icon">
                                <span>M</span>
                            </div>
                            <div class="date-timepicker">
                                <h4 class="date-span">{{ $monthly }}</h4>
                                <div class="per">+5%</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="calender-area-date">
                            <div class="date-icon">
                                <span>Y</span>
                            </div>
                            <div class="date-timepicker">
                                <h4 class="date-span">{{ $yearly }}</h4>
                                <div class="per">+5%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 vechicale-catagory padding-0">
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="vechicle-select">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">(Must Select One)</label>
                                <select class="form-control get-select-picker" name="emp" id="exampleFormControlSelect1" title="Select Employee">
                                    @foreach($employees as $e)
                                    <option value="{{ $e->details->id }}" @if($e->details->id == $emp){{ 'selected' }}@endif>{{ $e->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="vechicle-select">
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">(Must Select One)</label>
                                <select class="form-control get-select-picker" name="duration" id="exampleFormControlSelect2" title="Duration Selection">
                                    <option value="d" @if($duration == 'd'){{ 'selected' }}@endif>Daily</option>
                                    <option value="w" @if($duration == 'w'){{ 'selected' }}@endif>Weekly</option>
                                    <option value="m" @if($duration == 'm'){{ 'selected' }}@endif>Monthly</option>
                                    <option value="y" @if($duration == 'y'){{ 'selected' }}@endif>Yearly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6 col-lg-offset-0 col-lg-4">
                        <div class="or-vechicle">OR</div>
                        <div class="vechicle-select optional-or">
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">(Optional)</label>
                                <div class="optional-private">
                                     <input type="text" name="sDate" id="sDate" class="form-control datepicker-d" placeholder="Form">
                                </div>
                               <div class="optional-private">
                                    <input type="text" name="eDate" id="eDate" class="form-control datepicker-d" placeholder="To">
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="employee-table-center clearfix">
                        <table id="example" class="table" style="width:100%">
                            <thead>
                            <tr>
                                <th>Serial</th>
                                <th>ID</th>
                                <th>Employee Name</th>
                                <th>Vehicle Registration</th>
                                <th>Ticket No.</th>
                                <th>Time</th>
                                <th>Collection</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($result as $r)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $r->employee_id }}</td>
                                <td>{{ $r->req_by->name }}</td>
                                <td>{{ $r->vehicle_reg }}</td>
                                <td>{{ $r->ticket_id }}</td>
                                <td>{{ date('d/m/Y H:i A', strtotime($r->created_at)) }}</td>
                                <td>BDT. {{ $r->fair }}</td>
                                <td>{{ date('d/m/Y', strtotime($r->created_at)) }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
