@extends('layouts.layout-email')
@section('content')
    <div class="parking-kori clearfix">
        <div class="container">
            <div class="parking-kori-login clearfix">
                <div class="parking-kori-logo text-center">
                    <img src="{{ asset('/public/assets/img/pklogo.png') }}" alt="parking kori">
                </div>
                <form method="POST" class="parking-login clearfix" action="{{ route('password.update') }}">
                    @csrf
                    <div class="forget-passwrod-text text-center">
                        <h4>Reset Password</h4>
                    </div>
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group">
                        <label for="email" class="usr-lock"><i class="fas fa-envelope"></i></label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-lock"></i></label>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-lock"></i></label>
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="submit-forget-password">
                        <button class="btn-info btn btn-login" data-toggle="modal" data-target="#myModal">Confirm</button>
                        <button class="btn-info btn btn-login btn-cancel">Cancel</button>
                    </div>
                </form>
            </div>
            <div class="footer-content text-center">
                <p>A Product of <a href="#">DexHub</a></p>
                <p>Powered by <a href="#">Eunoia I.T Solutions</a></p>
            </div>
        </div>
    </div>
@endsection
