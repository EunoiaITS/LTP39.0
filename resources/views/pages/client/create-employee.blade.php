@extends('layout')
@section('content')

<div class="dashboard-main-content clearfix">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 dashboad-title">
                <h2>Create Employee</h2>
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
                    <form action="{{ url('/create-employee') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="user-id" class="usr-lock"><i class="fas fa-id-badge"></i></label>
                            <input name="employee_id" type="text" placeholder="ID" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="user-crname" class="usr-lock"><i class="fas fa-user"></i></label>
                            <input name="name" type="text" placeholder="Name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="user-crname" class="usr-lock"><i class="fas fa-user"></i></label>
                            <input name="email" type="text" placeholder="Email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="user-crpassword" class="usr-lock"><i class="fas fa-lock"></i></label>
                            <input name="password" type="password" placeholder="Password *" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="user-crretype" class="usr-lock"><i class="fas fa-lock"></i></label>
                            <input name="repass" type="password" placeholder="Re-Type Password *" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="user-crphone" class="usr-lock"><i class="fas fa-phone"></i></label>
                            <input name="phone" type="text" placeholder="Phone" class="form-control" required>
                        </div>
                        <div class="submit-forget-password">
                            <input type="hidden" name="role" value="emp">
                            <input type="hidden" name="status" value="dev">
                            <button type="submit" class="btn-info btn btn-login">Create</button>
                            <button type="button" class="btn-info btn btn-login">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection