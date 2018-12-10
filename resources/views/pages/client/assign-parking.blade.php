@extends('layout')
@section('content')

    <!-- main-content area -->
    <div class="dashboard-main-content clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Settings <img src="{{ asset('public/assets/img/down-arrow.png') }}" alt=""></h2>
                    <h4 class="date">Assign Parking</h4>
                </div>
                <div class="col-sm-12 padding-0">
                    <div class="col-sm-6 col-md-3 col-sm-6 col-md-offset-0 col-sm-offset-3">
                        <div class="total-parking-area">
                            <div class="total-date--icon">
                                <span>Total Parking</span>
                            </div>
                            <div class="date-timepicker">
                                <h4 class="date-span"><?php $total = 0; ?>@foreach($ps as $p) <?php $total+=$p->amount; ?> @endforeach{{ $total }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-offset-3 col-sm-offset-2 col-md-6">
                        @include('includes.messages')
                        @if(isset($errors))
                            @foreach($errors as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                        <div class="employee-form form-employee-center clearfix">
                            <form method="post" action="{{ url('/settings/assign-parking') }}">
                                {{ csrf_field() }}
                                <div class="assign-v-select vechicle-select">
                                    <div class="form-group">
                                        <select class="form-control get-select-picker" name="vehicle_id" id="exampleFormControlSelect1" title="Vehicle Category">
                                            @foreach($check as $v)
                                            <option value="{{ $v->id }}" @if(old('vehicle_id') == $v->id) {{ 'selected' }} @endif>{{ $v->type_name }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="user-crname" class="usr-lock"><i class="fas fa-car"></i></label>
                                    <input type="number" placeholder="Total Parking" name="amount" class="form-control" value="{{ old('amount') }}" required>
                                </div>
                                <div class="submit-forget-password">
                                    <input type="hidden" name="action" value="assign">
                                    <button type="submit" class="btn-info btn btn-login">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12 col-md-offset-2">
                    <div class="employee-table-center clearfix">
                        <table id="example" class="table" style="width:100%">
                            <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Vehicle Type Number</th>
                                <th>Total Number</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($ps as $p)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $p->vehicle->type_name }}</td>
                                    <td>{{ $p->amount }}</td>
                                    <td>
                                        <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#edit-p-{{ $p->id }}">Edit</button>
                                        <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#delete-{{ $p->id }}">Delete</button>
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
