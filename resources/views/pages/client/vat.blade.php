@extends('layout')
@section('content')

    <!-- main-content area -->
    <div class="dashboard-main-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Settings <img src="{{ asset('public/assets/img/down-arrow.png') }}" alt=""></h2>
                    <h4 class="date">VAT</h4>
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
                    <div class="col-sm-6 col-md-offset-3 col-sm-offset-3 col-md-6">
                        <div class="exampted-time-area">
                            <form method="post" action="{{ url('/settings/vat') }}">
                                {{ csrf_field() }}
                                <div class="vechicle-select">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">VAT %</label>
                                        <input type="number" name="vat" class="form-control" min="0" max="100" onKeyUp="if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}"  placeholder="N/A" value="@if(!empty($vat)){{ $vat->vat }}@endif">
                                        <p style="margin-top:12px;"><strong>Note: </strong>Vat value will be 0 to 100 </p>
                                    </div>
                                </div>
                                <div class="submit-forget-password">
                                    @if(!empty($vat))
                                        <input type="hidden" name="vat_id" value="{{ $vat->id }}">
                                        <input type="hidden" name="action" value="edit">
                                        @else
                                        <input type="hidden" name="action" value="create">
                                        @endif
                                    <button type="submit" class="btn-info btn btn-login">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
