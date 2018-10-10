@extends('layout')
@section('content')
    <div class="dashboard-main-content clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Manage Billing</h2>

                    <div class="employee-form form-employee-center clearfix">
                        <h3 class="manage-bill-name">Client :<br><span>{{ $data->name }}</span></h3>
                        <h3 class="manage-bill-name">Billing Time :<br><span>Every {{ $data->time }} Months</span></h3>
                        <h3 class="manage-bill-name">Amount : <br><span>BDT {{ $data->amount }}</span></h3>
                    </div>
                </div>
                <div class="col-sm-12 dashboad-title">
                    <h2>Due</h2>
                    <div class="col-sm-8 col-sm-offset-2 col-xs-12">
                        <div class="employee-table-center clearfix">
                            <table id="example" class="table" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Bill ID</th>
                                    <th>Due Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $count = 0; @endphp
                                @foreach($billing as $b)
                                    @if(isset($b->check) && $b->check == 'yes')
                                @php $count++; @endphp
                                <tr>
                                    <td>{{ $count }}</td>
                                    <td>{{ $b->billing_id }}</td>
                                    <td>{{ date('Y-m-d',strtotime($b->bill_start_date)) }}</td>
                                    <td>
                                        <button class="edit-icon btn btn-login"  data-toggle="modal" data-target="#myModal-{{ $b->id }}">Paid</button>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 dashboad-title">
                    <h2>Paid</h2>
                    <div class="col-sm-8 col-sm-offset-2 col-xs-12">
                        <div class="employee-table-center clearfix">
                            <table id="example2" class="table" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Bill ID</th>
                                    <th>Transaction ID</th>
                                    <th>Paid Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>BL00001</td>
                                    <td>232458723642</td>
                                    <td>02/12/2018</td>
                                </tr>
                                <tr>
                                    <td>02</td>
                                    <td>BL00001</td>
                                    <td>232458723642</td>
                                    <td>02/12/2018</td>
                                </tr>
                                <tr>
                                    <td>03</td>
                                    <td>BL00001</td>
                                    <td>232458723642</td>
                                    <td>02/12/2018</td>
                                </tr>
                                <tr>
                                    <td>04</td>
                                    <td>BL00001</td>
                                    <td>232458723642</td>
                                    <td>02/12/2018</td>
                                </tr>
                                <tr>
                                    <td>05</td>
                                    <td>BL00001</td>
                                    <td>232458723642</td>
                                    <td>02/12/2018</td>
                                </tr>
                                <tr>
                                    <td>06</td>
                                    <td>BL00001</td>
                                    <td>232458723642</td>
                                    <td>02/12/2018</td>
                                </tr>
                                <tr>
                                    <td>07</td>
                                    <td>BL00001</td>
                                    <td>232458723642</td>
                                    <td>02/12/2018</td>
                                </tr>
                                <tr>
                                    <td>08</td>
                                    <td>BL00001</td>
                                    <td>232458723642</td>
                                    <td>02/12/2018</td>
                                </tr>
                                <tr>
                                    <td>09</td>
                                    <td>BL00001</td>
                                    <td>232458723642</td>
                                    <td>02/12/2018</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>BL00001</td>
                                    <td>232458723642</td>
                                    <td>02/12/2018</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection