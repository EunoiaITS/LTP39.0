@extends('layout')
@section('content')
<!-- main-content area -->
<div class="dashboard-main-content clearfix">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 dashboad-title">
                <h2>Manage Device</h2>
            </div>
            <div class="col-sm-12">
                <div class="employee-table-center clearfix">
                    <table id="example" class="table" style="width:100%">
                        <thead>
                        <tr>
                            <th>Serial</th>
                            <th>ID</th>
                            <th>Factory Serial</th>
                            <th>Charger Serial</th>
                            <th>Client Name <i class="fas fa-arrow-alt-circle-down"></i></th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $count = 0; @endphp
                        @foreach($devices as $dv)
                            @php $count++; @endphp
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $dv->device_id }}</td>
                            <td>{{ $dv->factory_id }}</td>
                            <td>{{ $dv->charger_id }}</td>
                            <td></td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal-{{ $dv->id }}">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModaldel-{{ $dv->id }}">Delete</button>
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