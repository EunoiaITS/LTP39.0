<!--=====================
	Approve VIP modal
	=========================-->
@foreach($users as $u)
<div class="modal fade" id="myModal-{{ $u->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <h3>Approve VIP</h3>
                <form action="{{ url('/vip-requests') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="far fa-id-badge"></i></label>
                        <input name="vip_id" id="vip-id{{ $u->id }}" type="text" class="form-control" value="{{ $u->vipId }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-phone"></i></label>
                        <input name="phone" id="phone{{ $u->id }}" type="text" class="form-control" value="{{ $u->phone }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-user"></i></label>
                        <input name="purpose" type="text" placeholder="Purpose" class="form-control" value="{{ $u->purpose }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-car"></i></label>
                        <input name="car_reg" type="text" placeholder="Car Registration" class="form-control" value="{{ $u->car_reg }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="model-label" for="exampleFormControlSelect2">Time Duration</label>
                        <input type="number" name="time_duration" class="form-control" placeholder="Set the package in days" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-dollar-sign"></i></label>
                        <input name="price" type="text" placeholder="Price" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="model-label" for="exampleFormControlSelect2">QR/BAR Code</label>
                        <button id="generate{{ $u->id }}" type="button" class="btn btn-default btn-genarate">Generate QR</button>
                        <div class="qr-code-option">
                            <div id="qr-code{{ $u->id }}"></div>
                        </div>
                    </div>
                <input type="hidden" name="req_id" value="{{ $u->id }}">
                    <input type="hidden" name="action" value="accept">
                <input type="hidden" id="qr-image{{ $u->id }}" name="qr_image">
                <button type="submit" class="btn btn-default">Confirm</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--
Reject VIP modal
-->
<div class="modal fade" id="reject{{ $u->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <form action="{{ url('/vip-requests') }}" id="reject-form{{ $u->id }}" method="post">
                    {{ csrf_field() }}
                    <h3>Remark</h3>
                    <textarea name="remark" class="remark-box" id="" cols="30" rows="6"></textarea>
                    <div class="clearfix"></div>
                    <input type="hidden" name="req_id" value="{{ $u->id }}">
                    <input type="hidden" name="action" value="reject">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#reject-confirm{{ $u->id }}">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--
Reject VIP confirm modal
-->
<div class="modal fade" id="reject-confirm{{ $u->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <p>Are you sure You want to Reject this User's Request ?</p>
                <button type="submit" form="reject-form{{ $u->id }}" class="btn btn-default">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
@endforeach