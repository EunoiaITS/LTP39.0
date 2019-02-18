@extends('layout')
@section('content')

    <!-- main-content area -->
    <div class="dashboard-main-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Settings <img src="{{ url('public/assets/img/down-arrow.png') }}" alt=""></h2>
                    <h4 class="date">Additional</h4>
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
                            <form method="post" id="time" action="{{ url('/settings/additional') }}">
                                {{ csrf_field() }}
                                <div class="vechicle-select">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Set the report starting time for your mobile app. Default time is 12 AM.</label>
                                        <input type="text" name="report_starts_from" class="form-control form-exampted from" id="datetimepicker3"	placeholder="Starts From" value="@if($addSetti->isNotEmpty())
                                        @foreach($addSetti as $setti)
                                        @if($setti->key == 'report_starts_from'){{ $setti->value }}
                                        @endif
                                        @endforeach
                                        @elseif(old('report_starts_from')){{ old('report_starts_from') }}
                                        @else{{ '12:00 AM' }}
                                        @endif" required>
                                    </div>
                                </div>
                                <div class="clearfix" style="height: 20px"></div>
                                @if($addSetti->isNotEmpty())
                                    @foreach($addSetti as $setti)
                                        @if($setti->key == 'report_starts_from')
                                            <input type="hidden" name="action" value="ex-rsf">
                                            <input type="hidden" name="time_id" value="{{ $setti->id }}">
                                        @endif
                                    @endforeach
                                @else
                                    <input type="hidden" name="action" value="rsf">
                                @endif
                                <div class="submit-forget-password clearfix">
                                    <button type="submit" class="btn-info btn btn-login time">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="exampted-time-area">
                            <form method="post" id="duration" action="{{ url('/settings/exempted-setting') }}">
                                {{ csrf_field() }}
                                {{--<div class="vechicle-select">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label for="exampleFormControlSelect1">Exempted Duration</label>--}}
                                        {{--<input type="number" name="duration" class="form-control e-duration" placeholder="minutes" value="@if(!empty($exDuration)){{ $exDuration->duration }}@endif" required>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="form-group">--}}
                                    {{--<label class="checkbox-inline">--}}
                                        {{--<input type="checkbox" name="placement" class="form-control" data-toggle="toggle" value="@if(!empty($exDuration) && $exDuration->placement == 1){{ 'on' }}@else{{ 'off' }}@endif" @if(!empty($exDuration) && $exDuration->placement == 1){{ 'checked' }}@endif> Count after base hour--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                                {{--@if(!empty($exDuration))--}}
                                    {{--<input type="hidden" name="action" value="ex-duration">--}}
                                    {{--<input type="hidden" name="duration_id" value="{{ $exDuration->id }}">--}}
                                {{--@else--}}
                                    {{--<input type="hidden" name="action" value="duration">--}}
                                {{--@endif--}}
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
