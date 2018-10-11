@extends('layout')
@section('content')

    <!-- main-content area -->
    <div class="dashboard-main-content clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Settings <img src="{{ asset('public/assets/img/down-arrow.png') }}" alt=""></h2>
                    <h4 class="date">Assign Hour Rate</h4>
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
                                <th>ID</th>
                                <th>Vehicle Type Number</th>
                                <th>Base Hour</th>
                                <th>Base Fair</th>
                                <th>Subsequent Hour Rate</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>01</td>
                                <td>R001</td>
                                <td>Car</td>
                                <td>4</td>
                                <td>50</td>
                                <td>20</td>
                                <td>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>02</td>
                                <td>R001</td>
                                <td>Car</td>
                                <td>4</td>
                                <td>50</td>
                                <td>20</td>
                                <td>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>03</td>
                                <td>R001</td>
                                <td>Car</td>
                                <td>4</td>
                                <td>50</td>
                                <td>20</td>
                                <td>
                                    <button class="edit-icon btn btn-login">Edit</button>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>04</td>
                                <td>R001</td>
                                <td>Car</td>
                                <td>4</td>
                                <td>50</td>
                                <td>20</td>
                                <td>
                                    <button class="edit-icon btn btn-login">Edit</button>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection