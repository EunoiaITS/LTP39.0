<!--=====================
	create assign hour modal 
	=========================-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <h3>Add Parking Rate</h3>
                <form method="post" action="{{ url('/settings/assign-rate') }}">
                    <div class="form-group">
                        <label class="model-label" for="exampleFormControlSelect2">Vehicle Type</label>
                        @foreach($vt as $v)
                        <select class="form-control get-select-picker" id="exampleFormControlSelect2" title="Vehicle Category">
                            <option value="{{ $v->id }}">{{ $v->type_name }}</option>
                        </select>
                            @endforeach
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-clock"></i></label>
                        <input type="text" placeholder="Base Hour" name="base_hour" class="form-control" value="{{ old('base_hour') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="far fa-clock"></i></label>
                        <input type="text" placeholder="Base Fair" name="base_rate" class="form-control" value="{{ old('base_rate') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-hourglass-half"></i></label>
                        <input type="text" placeholder="Subsequent Hour Rate" name="sub_rate" class="form-control" value="{{ old('sub_rate') }}" required>
                    </div>
                </form>
                <button type="button" class="btn btn-default">Create</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>



<!--
block/unblock modal
-->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <div class="icon-delete text-center"><i class="fas fa-trash"></i></div>
                <p>Are you sure you want to delete this?</p>
                <button type="button" class="btn btn-default">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>