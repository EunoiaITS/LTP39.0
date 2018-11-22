@extends('layout')
@section('content')

    <!-- main-content area -->
    <div class="dashboard-main-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Report <img src="{{ asset('public/assets/img/down-arrow.png') }}" alt=""></h2>
                    <h4 class="date">Parking Sale Total</h4>
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
                <div class="col-sm-12 dashboad-title report-advert-sale">
                    <h4 class="date">Advert Sale Total</h4>
                </div>
                <div class="col-sm-12 total-area padding-0">
                    <div class="col-sm-6 col-md-3">
                        <div class="calender-area-date">
                            <div class="date-icon">
                                <span>D</span>
                            </div>
                            <div class="date-timepicker">
                                <h4 class="date-span">330</h4>
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
                                <h4 class="date-span">2310</h4>
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
                                <h4 class="date-span">69,300</h4>
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
                                <h4 class="date-span">800,600</h4>
                                <div class="per">+5%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 vechicale-catagory padding-0 report-advert-sale">
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="vechicle-select">
                            <div class="form-group">
                                <select class="form-control get-select-picker" name="vc" id="exampleFormControlSelect1" title="Client Category">
                                    @foreach($clients as $c)
                                    <option value="{{ $c->id }}" @if(isset($vc) && $vc == $c->id){{ 'selected' }}@endif>{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="vechicle-select">
                            <div class="form-group">
                                <select class="form-control get-select-picker" name="type" id="exampleFormControlSelect2" title="Sales Category">
                                    <option value="ad" @if(isset($type) && $type == 'ad'){{ 'selected' }}@endif>Advert</option>
                                    <option value="park" @if(isset($type) && $type == 'park'){{ 'selected' }}@endif>Parking</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="vechicle-select optional-or">
                            <div class="form-group">
                                <input type="text" name="sDate" id="sDate" class="form-control datepicker-f" placeholder="Form">
                                <input type="text" name="eDate" id="eDate" class="form-control datepicker-f" placeholder="To">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="employee-table-center clearfix">
                        <table id="example" class="table" style="width:100%">
                            <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Client ID</th>
                                <th>Daily</th>
                                <th>Weekly</th>
                                <th>Monthly</th>
                                <th>Yearly</th>
                                <th>Form - To</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($result as $r)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $r->details->client_id }}</td>
                                <td>{{ $r->daily }}</td>
                                <td>{{ $r->weekly }}</td>
                                <td>{{ $r->monthly }}</td>
                                <td>{{ $r->yearly }}</td>
                                <td>{{ $r->from_to }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection