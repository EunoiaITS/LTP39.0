@extends('layout')
@section('content')

    <!-- main-content area -->
    <div class="dashboard-main-content clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Reports <img src="img/down-arrow.png" alt=""></h2>
                    <h4 class="date">Vechile Category</h4>
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
                                <select class="form-control get-select-picker" id="exampleFormControlSelect1" title="Vechile Category">
                                    @foreach($vc as $c)
                                    <option value="{{ $c->id }}" @if($vc_selected != null && $vc_selected == $c->id){{ 'selected' }}@endif>{{ $c->type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="vechicle-select">
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">(Optional)</label>
                                <select class="form-control get-select-picker" id="exampleFormControlSelect2" title="Report Category">
                                    <option value="1" @if($type != null && $type == 1){{ 'selected' }}@endif>Check In</option>
                                    <option value="2" @if($type != null && $type == 2){{ 'selected' }}@endif>Check Out</option>
                                    <option value="3" @if($type != null && $type == 3){{ 'selected' }}@endif>VIP Check In</option>
                                    <option value="4" @if($type != null && $type == 4){{ 'selected' }}@endif>VIP Check Out</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="vechicle-select">
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">(Must Select One)</label>
                                <select class="form-control get-select-picker" id="exampleFormControlSelect2" title="Duration Selection">
                                    <option value="">Daily</option>
                                    <option value="">Weekly</option>
                                    <option value="">Monthly</option>
                                    <option value="">Yearly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="or-vechicle">OR</div>
                        <div class="vechicle-select optional-or">
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">(Optional)</label>
                                <input type="text" class="form-control datepicker-f" placeholder="Form">
                                <input type="text" class="form-control datepicker-f" placeholder="To">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid fluid-padding">
            <div class="row">
                <div class="col-sm-12">
                    <div class="employee-table-center clearfix">
                        <table id="example" class="table" style="width:100%">
                            <thead>
                            <tr>
                                <th>Serial</th>
                                <th>ID</th>
                                <th>Vechicle Cat.</th>
                                <th>Report Cat.</th>
                                <th>Registration No.</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @if($result != null)
                                @foreach($result as $r)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $r->ticket_id }}</td>
                                <td>{{ $r->vehicle_type }}</td>
                                <td>@if($r->fair == null){{ 'Checked In' }}@else{{ 'Checked Out' }}@endif</td>
                                <td>{{ $r->vehicle_reg }}</td>
                                <td>{{ date('Y-m-d H:i A', strtotime($r->created_at)) }}</td>
                                <td>@if($r->fair != null){{ date('Y-m-d H:i A', strtotime($r->updated_at)) }}@endif</td>
                                <td>EMP 1</td>
                                <td></td>
                                <td>{{ date('d/m/Y', strtotime($r->created_at)) }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection