@extends('layout')
@section('content')
<div class="dashboard-main-content clearfix">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 dashboad-title">
                <h2>Manage Billing</h2>
            </div>
            <div class="col-sm-12">
                <div class="employee-table-center clearfix">
                    <table id="example" class="table" style="width:100%">
                        <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Bill ID</th>
                            <th>Client ID</th>
                            <th>Client Name</th>
                            <th>Bill Term</th>
                            <th>Amount</th>
                            <th>Due Date</th>
                            <th>Details</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $count = 0; @endphp
                        @foreach($billing as $b)
                        @php $count++; @endphp
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $b->billing_id }}</td>
                            <th>{{ $b->client_id }}</th>
                            <td>{{ $b->client }}</td>
                            <td>{{ $b->billing_term }}</td>
                            <td>{{ $b->billing_amount }}</td>
                            <td>{{ date('Y-m-d',strtotime($b->bill_start_date)) }}</td>
                            <td>
                                <a href="{{ url('/manage-billing-details?client_id='.$b->client_id) }}"><button class="edit-icon btn btn-login">Details</button></a>
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