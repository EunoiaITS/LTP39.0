@extends('layout')
@section('content')
    <div class="dashboard-main-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Create Billing</h2>
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
                    <div class="employee-form form-employee-center">
                        <form id="create-billing" action="{{ url('/create-billing') }}" method="post">
                            {{ csrf_field() }}
                            <div class="vechicle-select">
                                <div class="form-group">
                                    <label for="client">Client's Name</label>
                                    <select class="form-control get-select-picker" id="client" title="Client's Category">
                                        @foreach($clients as $c)
                                            <option value="{{ $c->client_id }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user-id" class="usr-lock"><i class="fas fa-id-badge"></i></label>
                                <input name="client_id" type="text" placeholder="Client's ID" class="form-control" id="client-id" readonly>
                            </div>
                            <div class="vechicle-select">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Select Billing Term</label>
                                    <select name="billing_term" class="form-control get-select-picker" id="exampleFormControlSelect1" title="month(s)" multiple>
                                        <option value="1">01</option>
                                        <option value="2">02</option>
                                        <option value="3">03</option>
                                        <option value="4">04</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group bill-amount">
                                <label for="user-bdt">Amount According to Billing Term</label>
                                <input name="billing_amount" type="text" placeholder="BDT 0.00" class="form-control" id="user-bdt" required>
                            </div>
                            <div class="form-group">
                                <label for="user-email" class="usr-lock"><i class="fas fa-calendar-alt"></i></label>
                                <input name="bill_start_date" type="text" class="form-control datepicker-f" placeholder="Start Date">
                            </div>
                            <div class="form-check">
                                <input name="auto_renew" type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Auto Renew</label>
                            </div>

                            <div class="submit-forget-password">
                                <button type="button" class="btn-info btn btn-login" data-toggle="modal" data-target="#myModal">Save</button>
                                <button type="button" class="btn-info btn btn-login">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection