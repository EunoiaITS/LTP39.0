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
                                    <select class="form-control get-select-picker" id="exampleFormControlSelect1" title="Cleint Category">
                                        <option value="">Parking Client</option>
                                        <option value="">Advertisement Client</option>
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
                                <th> Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sn = 1; ?>
                            @foreach($clients as $client)
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>{{ $client->client_id }}</td>
                                <td>{{ $client->data->name }}</td>
                                <td>
                                    <a href="{{ url('/client-details?client_id='.$client->client_id) }}"><button class="edit-icon btn btn-login">View Details</button></a>
                                    <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal{{ $client->id }}">@if($client->data->status == 'block') {{ 'Unblock' }} @else {{ 'Block' }} @endif</button>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
	block modal
	-->
    @foreach($clients as $client)
    <div class="modal fade" id="myModal{{ $client->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div  class="modal-dialog" role="document">
            <div class="modal-content modal-form">
                <form method="post" action="{{ url('/clients-list') }}">
                    {{ csrf_field() }}
                <div class="modal-body text-center modal-padding">
                    <p>Are you sure you want to @if($client->data->status == 'block') {{ 'unblock' }} @else {{ 'block' }} @endif <strong>{{ $client->data->name }}</strong>?</p>
                    <input type="hidden" name="status" value="@if($client->data->status == 'block') {{ 'unblock' }} @else {{ 'block' }} @endif">
                    <input type="hidden" name="client_id" value="{{ $client->user_id }}">
                    <button type="submit" class="btn btn-default">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    @endsection