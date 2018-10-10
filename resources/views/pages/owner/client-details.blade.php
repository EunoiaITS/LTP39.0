@extends('layout')
@section('content')

    <!-- main-content area -->
    <div class="dashboard-main-content clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Client Details <img src="{{ asset('public/assets/img/down-arrow.png') }}" alt=""></h2>
                    <h4 class="date">{{ $client->data->name }}</h4>
                    @include('includes.messages')
                </div>
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="employee-form form-employee-center clearfix">
                        <form method="post" action="{{ url('/client-details?client_id='.$client->client_id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="user-id">Email</label><br>
                                <span class="email">{{ $client->data->email }}</span>
                            </div>
                            <div class="form-group">
                                <label for="user-id" class="usr-lock"><i class="fas fa-phone"></i></label>
                                <input type="text" name="phone" placeholder="Phone" class="form-control" id="phone-no" value="{{ $client->phone }}" readonly>
                            </div>
                            <div class="form-group clearfix">
                                <label for="payment-terms">Payment Term</label>
                                <div class="clearfix"></div>
                                <div class="file-picutre">
                                    <img src="{{ asset('public/uploads/clients/payment_files/'.$client->payment_file) }}" alt="image">
                                </div>
                                <div class="file btn btn-sm btn-primary ">
                                    <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div><span>Browse File</span>
                                    <input type="file" class="input-upload" name="file" id="file-up" disabled>
                                </div>
                            </div>
                            <input type="hidden" name="action" value="edit-data">
                            <div class="submit-forget-password">
                                <button class="btn-info btn btn-login" type="button" data-toggle="modal" data-target="#myModalz">Reset Password</button>
                                <button class="btn-info btn btn-login" type="submit" id="btn-save" disabled>Save</button>
                            </div>
                        </form>
                        <!-- edit clients -->
                        <div class="edit-icon-absolute">
                            <i class="far fa-edit edit-icon-option" id="enable-edit"></i>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 dashboad-title">
                    <h2>Manager List <div class="plus-icon" data-toggle="modal" data-target="#myModal1"><i class="fas fa-plus-circle"></i></div></h2>
                    @if(session()->has('success_m'))
                        <div class="alert alert-success" role="alert">
                            {{ session()->get('success_m') }}
                        </div>
                    @endif

                    @if(session()->has('error_m'))
                        <div class="alert alert-danger" role="alert">
                            {{ session()->get('error_m') }}
                        </div>
                    @endif
                    @if(isset($errors))
                        @foreach($errors as $error)
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="employee-table-center clearfix">
                        <table id="example" class="table" style="width:100%">
                            <thead>
                            <tr>
                                <th>Serial</th>
                                <th>ID</th>
                                <th> Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($managers as $cm)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $cm->manager_id }}</td>
                                <td>{{ $cm->data->name }}</td>
                                <td>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#edit-manager-{{ $cm->id }}">Edit</button>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#delete-manager-{{ $cm->id }}">Delete</button>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#block-manager-{{ $cm->id }}">@if($cm->data->status == 'block') {{ 'Unblock' }} @else {{ 'Block' }} @endif</button>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 dashboad-title">
                    <h2>Device List <div class="plus-icon" data-toggle="modal" data-target="#myModaltable"><i class="fas fa-plus-circle"></i></div></h2>
                    <div class="alert alert-success" role="alert">
                        Devices Added
                    </div>
                </div>
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="employee-table-center clearfix">
                        <table id="example2" class="table" style="width:100%">
                            <thead>
                            <tr>
                                <th>Serial</th>
                                <th>ID</th>
                                <th>Factory Serial</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Dev0001</td>
                                <td>S/N04956679</td>
                                <td>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal5">Remove</button>
                                </td>
                            </tr>
                            <tr>
                                <td>02</td>
                                <td>Dev0002</td>
                                <td>S/N04956679</td>
                                <td>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal5">Remove</button>
                                </td>
                            </tr>
                            <tr>
                                <td>03</td>
                                <td>Dev0003</td>
                                <td>S/N04956679</td>
                                <td>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal5">Remove</button>
                                </td>
                            </tr>
                            <tr>
                                <td>04</td>
                                <td>Dev0004</td>
                                <td>S/N04956679</td>
                                <td>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal5">Remove</button>
                                </td>
                            </tr>
                            <tr>
                                <td>05</td>
                                <td>Dev0005</td>
                                <td>S/N04956679</td>
                                <td>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal5">Remove</button>
                                </td>
                            </tr>
                            <tr>
                                <td>06</td>
                                <td>Dev0006</td>
                                <td>S/N04956679</td>
                                <td>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal5">Remove</button>
                                </td>
                            </tr>
                            <tr>
                                <td>07</td>
                                <td>Dev0007</td>
                                <td>S/N04956679</td>
                                <td>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal5">Remove</button>
                                </td>
                            </tr>
                            <tr>
                                <td>08</td>
                                <td>Dev0008</td>
                                <td>S/N04956679</td>
                                <td>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal5">Remove</button>
                                </td>
                            </tr>
                            <tr>
                                <td>09</td>
                                <td>Dev0009</td>
                                <td>S/N04956679</td>
                                <td>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal5">Remove</button>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Dev0010</td>
                                <td>S/N04956679</td>
                                <td>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal5">Remove</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection