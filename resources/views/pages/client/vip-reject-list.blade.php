@extends('layout')
@section('content')
<!-- main-content area -->
<div class="dashboard-main-content clearfix">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 dashboad-title">
                <h2>VIP <img src="{{ asset('public/assets/img/down-arrow.png') }}" alt=""></h2>
                <h4 class="date">Rejected List</h4>
            </div>
        </div>
    </div>
    <div class="container-fluid fluid-padding">
        <div class="row">
            <div class="col-sm-12">
                <div class="employee-table-center clearfix">
                    <table id="example" class="table request-notification" style="width:100%">
                        <thead>
                        <tr>
                            <th>Serial</th>
                            <th>ID</th>
                            <th>Phone</th>
                            <th>Purpose</th>
                            <th>Car Reg.</th>
                            <th>Requested By</th>
                            <th>Requested On</th>
                            <th>Rejected By</th>
                            <th>Rejected Reason</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $count = 0; @endphp
                        @foreach($vips as $v)
                        @php $count++; @endphp
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $v->vipId }}</td>
                            <td>{{ $v->phone }}</td>
                            <td>{{ $v->purpose }}</td>
                            <td>{{ $v->car_reg }}</td>
                            <td>{{ $v->req_by->name }}</td>
                            <td>{{ date('d-M-Y', strtotime($v->created_at)) }}</td>
                            <td>@if(isset($v->s_by->name)){{ $v->s_by->name }}@endif</td>
                            <td>{{ $v->remark }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection