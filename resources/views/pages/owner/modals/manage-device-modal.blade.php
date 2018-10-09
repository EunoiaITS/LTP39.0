@foreach($devices as $dv)
<div class="modal fade" id="myModal-{{ $dv->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form modal-device">
            <div class="modal-body text-center modal-padding">
                <h3>Edit Charger Serial</h3>
                <form action="{{ url('/manage-device') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="user-name">Charger Serial</label>
                        <input type="hidden" name="device_id" value="{{ $dv->id }}">
                        <input type="text" name="charger_id" value="{{ $dv->charger_id }}" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-default">Confirm</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($devices as $dv)
<div class="modal fade" id="myModaldel-{{ $dv->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <form action="{{ url('/delete-device') }}" method="post">
                {{ csrf_field() }}
                    <div class="modal-body text-center modal-padding">
                        <p>Are you sure?</p>
                        <input type="hidden" name="device_id" value="{{ $dv->id }}">
                        <button type="submit" class="btn btn-default">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
            </form>
        </div>
    </div>
</div>
@endforeach