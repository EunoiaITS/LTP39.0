@extends('layout')
@section('content')

    <!-- main-content area -->
    <div class="click-loading-option">
		<img src="{{ asset('/public/assets/img/loading_icon.gif') }}" alt="">
	</div>
    <div class="dashboard-main-content clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Create Client</h2>
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
                        <form method="post" action="{{ url('/create-client') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="client_id" placeholder="ID" class="form-control" id="client-id">
                            <div class="vechicle-select">
                                <div class="form-group">
                                    <label for="client-type">Client Type</label>
                                    <select class="form-control get-select-picker" name="client_type" id="client-type" title="Cleint Category">
                                        <option value="park" @if(old('client_type') == 'park') {{ 'selected' }} @endif>Parking Client</option>
                                        <option value="ad" @if(old('client_type') == 'ad') {{ 'selected' }} @endif>Advertisement Client</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user-name" class="usr-lock"><i class="fas fa-user"></i></label>
                                <input type="text" name="name" placeholder="name" class="form-control" id="user-name" value="{{ old('name') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="user-email" class="usr-lock"><i class="far fa-envelope"></i></label>
                                <input type="email" name="email" placeholder="Email" class="form-control" id="user-email" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="user-password" class="usr-lock"><i class="fas fa-lock"></i></label>
                                <input type="password" name="password" placeholder="Password" class="form-control" id="user-password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm-password" class="usr-lock"><i class="fas fa-lock"></i></label>
                                <input type="password" name="repass" placeholder="Confirm Password" class="form-control" id="confirm-password" required>
                            </div>
                            <div class="form-group">
                                <label for="clint-phone" class="usr-lock"><i class="fas fa-phone"></i></label>
                                <input type="text" name="phone" placeholder="Phone" class="form-control" id="clint-phone" value="{{ old('phone') }}" required>
                            </div>

                            <div class="form-group clearfix">
                                <label for="payment-terms">Payment Terms</label>
                                <div class="clearfix"></div>
                                <div class="file btn btn-sm btn-primary">
                                    <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div><span class="custom-file-label">Browse File</span>
                                    <input type="file" class="input-upload file-upload" id="inputGroupFile02" name="file">
                                </div>
                            </div>

                            <input type="hidden" name="role" value="client">
                            <div class="submit-forget-password">
                                <button class="btn-info btn btn-login" type="submit">Create</button>
                                <button class="btn-info btn btn-login" type="button" onclick="window.location.reload();">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
