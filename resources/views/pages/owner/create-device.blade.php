@extends('layout')
@section('content')
<!-- main-content area -->
<div class="dashboard-main-content clearfix">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 dashboad-title">
                <h2>Create Device</h2>
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
                    <form action="">
                        <div class="form-group">
                            <label for="device-id" class="usr-lock"><i class="fas fa-id-badge"></i></label>
                            <input type="text" name="device_id" placeholder="ID" class="form-control" id="device-id" required>
                        </div>
                        <div class="form-group">
                            <label for="factory-serial">Factory Serial</label>
                            <input type="text" name="factory_id" placeholder="S/N002948928393289" class="form-control" id="factory-serial" required>
                        </div>
                        <div class="form-group">
                            <label for="charger-serial">Charger Serial</label>
                            <input type="text" name="charger_id" placeholder="S/N849484859389484" class="form-control" id="charger-serial" required>
                        </div>
                        <div class="submit-forget-password">
                            <button class="btn-info btn btn-login" data-toggle="modal" data-target="#myModal">Create</button>
                            <button class="btn-info btn btn-login">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection