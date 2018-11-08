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
                            <th>Name</th>
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
                            <td>01</td>
                            <td>VIP001</td>
                            <td>Driver1</td>
                            <td>+01717</td>
                            <td>Shop Owner</td>
                            <td>GA11110</td>
                            <td>Emp 1</td>
                            <td>01/01/01</td>
                            <td>Manager 1</td>
                            <td>Not intersted</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection