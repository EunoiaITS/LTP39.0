@extends('layouts.layout-email')
@section('content')
    <div class="parking-kori clearfix">
        <div class="container">
            <div class="parking-kori-login clearfix">
                <div class="parking-kori-logo text-center">
                    <img src="{{ asset('/public/assets/img/pklogo.png') }}" alt="parking kori">
                </div>
                <form method="POST" class="parking-login clearfix" action="{{ route('password.email') }}">
                    @csrf
                    <div class="forget-passwrod-text text-center">
                        <h4>Forgot Password</h4>
                        <p>Simply Enter Your Email to Resend your Password</p>
                    </div>
                    @if (session('status'))
                        <div class="form-group alert alert-success" role="alert">
                            <p>Password Reset link has been sent to your Email.</p>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="far fa-envelope"></i></label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                    </div>
                    @if ($errors->has('email'))
                        <div class="alert alert-danger alert-simple" role="alert">
                            We couldn't find this Email Address. <br> Please use your registered Email Address.
                        </div>
                    @endif
                    <div class="clearfix"></div>
                    <div class="submit-forget-password">
                        <button class="btn-info btn btn-login">Submit</button>
                        <button class="btn-info btn btn-login btn-cancel">Cancel</button>
                    </div>
                </form>
            </div>
            <div class="footer-content text-center">
                <p>A Product of <a target="_blank" href="https://www.dexhub.org/">DexHub</a></p>
                <p>Powered by <a target="_blank" href="http://www.eunoiaits.com/">Eunoia I.T Solutions</a></p>
            </div>
        </div>
    </div>
@endsection
