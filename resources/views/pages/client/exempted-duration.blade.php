@extends('layout')
@section('content')

    <!-- main-content area -->
    <div class="dashboard-main-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Settings <img src="{{ url('public/assets/img/down-arrow.png') }}" alt=""></h2>
                    <h4 class="date">Exempted Time</h4>
                    @include('includes.messages')
                    @if(isset($errors))
                        @foreach($errors as $error)
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="col-sm-12 padding-0">
                    <div class="col-sm-6 col-md-6">
                        <div class="exampted-time-area">
                            <form method="post" id="time" action="{{ url('/settings/exempted-setting') }}">
                                {{ csrf_field() }}
                                <div class="vechicle-select">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Exemted Time</label>
                                        <input type="text" name="from" class="form-control form-exampted from" id="datetimepicker3"	placeholder="Form" value="@if(!empty($exTime)){{ $exTime->from }}@endif" required>
                                        <input type="text" name="to" class="form-control form-exampted to" id="datetimepicker4" placeholder="To" value="@if(!empty($exTime)){{ $exTime->to }}@endif" required>
                                    </div>
                                </div>
                                <div class="clearfix" style="height: 20px"></div>
                                @if(!empty($exTime))
                                    <input type="hidden" name="action" value="ex-time">
                                    <input type="hidden" name="time_id" value="{{ $exTime->id }}">
                                    @else
                                    <input type="hidden" name="action" value="time">
                                    @endif
                                <div class="submit-forget-password clearfix">
                                    <button type="button" class="btn-info btn btn-login time" data-toggle="modal" data-target="#myModal1">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="exampted-time-area">
                            <form method="post" id="duration" action="{{ url('/settings/exempted-setting') }}">
                                {{ csrf_field() }}
                                <div class="vechicle-select">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Exemted Duration</label>
                                        <input type="number" name="duration" class="form-control e-duration" placeholder="minutes" value="@if(!empty($exDuration)){{ $exDuration->duration }}@endif" required>
                                    </div>
                                </div>
                                @if(!empty($exDuration))
                                    <input type="hidden" name="action" value="ex-duration">
                                    <input type="hidden" name="duration_id" value="{{ $exDuration->id }}">
                                @else
                                    <input type="hidden" name="action" value="duration">
                                @endif
                                <div class="submit-forget-password">
                                    <button type="button" class="btn-info btn btn-login duration" data-toggle="modal" data-target="#myModal2">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
