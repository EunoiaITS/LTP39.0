@extends('layout')
@section('content')
<!-- main-content area -->
<div class="dashboard-main-content clearfix">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 dashboad-title">
                <h2>VIP <img src="{{ asset('public/assets/img/down-arrow.png') }}" alt=""></h2>
                <h4 class="date">Accepted List</h4>
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
                            <th>Accepted By</th>
                            <th>Accepted On</th>
                            <th>Duration</th>
                            <th>QR</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $count = 0; @endphp
                        @foreach($vips as $v)
                        @php $count++; @endphp
                        <tr>
                            <td>{{ $count }}</td>
                            <td>VIP-{{ $v->id }}</td>
                            <td>Driver1</td>
                            <td>+01717012457</td>
                            <td>Shop Owner</td>
                            <td>GA11110</td>
                            <td>Emp 1</td>
                            <td>01/01/01</td>
                            <td>Manager 1</td>
                            <td>01/01/01</td>
                            <td>2 months</td>
                            <td>
                                <div class="qr-code-accepted">
                                    <img src="img/qr-code.png" class="qr-codeimg" alt="">
                                    <button class="download-btn"><i class="fas fa-arrow-alt-circle-down"></i></button>
                                </div>
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