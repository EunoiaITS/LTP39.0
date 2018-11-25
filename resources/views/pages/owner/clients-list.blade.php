@extends('layout')
@section('content')

    <!-- main-content area -->
    <div class="dashboard-main-content clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Client <img src="{{ asset('public/assets/img/down-arrow.png') }}" alt=""></h2>
                    <h4 class="date">Manage Client</h4>
                    @include('includes.messages')
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
                        <div class="col-sm-4">
                            <div class="vechicle-select">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Client Type</label>
                                    <select class="form-control get-select-picker" id="client-select" title="Client Category">
                                        <option value="pc" @if($type == 'park') {{ 'selected' }} @endif>Parking Client</option>
                                        <option value="ac" @if($type == 'ad') {{ 'selected' }} @endif>Advertisement Client</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <table id="example" class="table" style="width:100%">
                            <thead>
                            <tr>
                                <th>Serial</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sn = 1; ?>
                            @foreach($clients as $client)
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>{{ $client->client_id }}</td>
                                <td>@if(isset($client->data->name)){{ $client->data->name }}@endif</td>
                                <td>
                                    <a href="{{ url('/client-details?client_id='.$client->client_id) }}"><button class="edit-icon btn btn-login">View Details</button></a>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal{{ $client->id }}">@if(isset($client->data->status))@if($client->data->status == 'block') {{ 'Unblock' }} @else {{ 'Block' }} @endif @endif</button>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModalDel{{ $client->id }}">Delete</button>
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