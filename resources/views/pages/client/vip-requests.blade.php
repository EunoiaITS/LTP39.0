@extends('layout')
@section('content')
<!-- main-content area -->
<div class="dashboard-main-content clearfix">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 dashboad-title">
                <h2>VIP <img src="{{ asset('public/assets/img/down-arrow.png') }}" alt=""></h2>
                <h4 class="date">New Request Notification</h4>
                @include('includes.messages')
                @if(isset($errors))
                    @foreach($errors as $error)
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="container-fluid fluid-padding ">
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
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $count = 0; @endphp
                        @foreach($users as $u)
                        @php $count++; @endphp
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $u->vipId }}</td>
                            <td>{{ $u->phone }}</td>
                            <td>{{ $u->purpose }}</td>
                            <td>{{ $u->car_reg }}</td>
                            <td>{{ $u->req_by->name }}</td>
                            <td>{{ date('Y-m-d', strtotime($u->created_at)) }}</td>
                            <td>
                                <button class="edit-icon btn btn-login approve" rel="{{ $u->id }}" data-toggle="modal" data-target="#myModal-{{ $u->id }}">Approve</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#reject{{ $u->id }}">Reject</button>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection