@extends('layout')
@section('content')

    <!-- main-content area -->
    <div class="dashboard-main-content clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Settings <img src="{{ asset('public/assets/img/down-arrow.png') }}" alt=""></h2>
                    <h4 class="date">Vehicle Category</h4>
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
                    <div class="employee-form form-employee-center clearfix">
                        <form method="post" action="{{ url('/settings/vehicle-types') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="user-id" class="usr-lock"><i class="fas fa-id-badge"></i></label>
                                <input type="text" name="type_id" placeholder="ID" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="user-crname" class="usr-lock"><i class="fas fa-car"></i></label>
                                <input type="text" name="type_name" placeholder="Vehicle Type" class="form-control" required>
                            </div>
                            <div class="submit-forget-password">
                                <input type="hidden" name="action" value="create">
                                <button class="btn-info btn btn-login">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12 col-md-offset-2">
                    <div class="employee-table-center clearfix">
                        <table id="example" class="table" style="width:100%">
                            <thead>
                            <tr>
                                <th>Serial</th>
                                <th>ID</th>
                                <th>Vehicle Type Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($data as $d)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $d->type_id }}</td>
                                <td>{{ $d->type_name }}</td>
                                <td>
                                    <button class="edit-icon btn btn-login">Edit</button>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#delete-{{ $d->id }}">Delete</button>
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