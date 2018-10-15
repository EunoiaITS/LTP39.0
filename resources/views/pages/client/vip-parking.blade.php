@extends('layout')
@section('content')

    <!-- main-content area -->
    <div class="dashboard-main-content clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Settings <img src="{{ asset('public/assets/img/down-arrow.png') }}" alt=""></h2>
                    <h4 class="date">Assign VIP Hour Rate</h4>
                    @include('includes.messages')
                    @if(isset($errors))
                        @foreach($errors as $error)
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="col-sm-12">
                    <div class="assign-create">
                        <button class="btn-info btn btn-login" data-toggle="modal" data-target="#myModal2">Create</button>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="employee-table-center clearfix">
                        <table id="example" class="table" style="width:100%">
                            <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Vehicle Type Number</th>
                                <th>Time (months)</th>
                                <th>Fair</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($vip as $v)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $v->category->type_name }}</td>
                                <td>{{ $v->duration }}</td>
                                <td>{{ $v->fair }}</td>
                                <td>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#edit-modal-{{ $v->id }}">Edit</button>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#delete-modal-{{ $v->id }}">Delete</button>
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