<!--=====================
	Approve VIP modal
	=========================-->
@foreach($users as $u)
<div class="modal fade" id="myModal-{{ $u->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <h3>Approve VIP</h3>
                <form action="{{ url('/create-vip') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="far fa-id-badge"></i></label>
                        <input name="vip_id" id="vip-id" type="text" class="form-control" value="{{ 'VIP-' .$u->id }}" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-user"></i></label>
                        <input name="name" id="name" type="text" class="form-control" value="{{ $u->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-phone"></i></label>
                        <input name="phone" id="phone" type="text" class="form-control" value="{{ $u->phone }}" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-user"></i></label>
                        <input name="purpose" type="text" placeholder="Purpose" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-car"></i></label>
                        <input name="car_reg" type="text" placeholder="Car Registration" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-car"></i></label>
                        <input name="vehicle_type" type="text" placeholder="Vehicle Type" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="model-label" for="exampleFormControlSelect2">Time Duration</label>
                        <select name="time_duration" class="form-control get-select-picker" id="exampleFormControlSelect2" title="Duration Selection">
                            <option value="Daily">Daily</option>
                            <option value="Weekly">Weekly</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Yearly">Yearly</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-dollar-sign"></i></label>
                        <input name="price" type="text" placeholder="Price" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="model-label" for="exampleFormControlSelect2">QR/BAR Code</label>
                        <button id="generate" type="button" class="btn btn-default btn-genarate">Generate QR</button>
                        <div class="qr-code-option">
                            <div id="qr-code"></div>
                        </div>
                    </div>
                <input type="hidden" name="client_id" value="{{ $u->client_id }}">
                <input type="hidden" id="qr-image" name="qr_image" value="">
                <button type="submit" class="btn btn-default">Confirm</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<!--
Reject VIP modal
-->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <h3>Remark</h3>
                <textarea name="" class="remark-box" id="" cols="30" rows="6"></textarea>
                <div class="clearfix"></div>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal4">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!--
Reject VIP confirm modal
-->
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <p>Are you sure You want to Reject this User's Request ?</p>
                <button type="button" class="btn btn-default">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>