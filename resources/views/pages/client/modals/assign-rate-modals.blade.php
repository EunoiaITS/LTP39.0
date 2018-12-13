<!--=====================
	create assign hour modal 
	=========================-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <h3>Add Parking Rate</h3>
                <form method="post" id="create-rate" action="{{ url('/settings/assign-rate') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="model-label" for="exampleFormControlSelect2">Vehicle Type</label>

                        <select class="form-control get-select-picker" name="vehicle_id" id="exampleFormControlSelect2" title="Vehicle Category">
                            @foreach($check as $v)
                            <option value="{{ $v->id }}">{{ $v->type_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-clock"></i></label>
                        <input type="number" placeholder="Base Hour" name="base_hour" class="form-control" value="{{ old('base_hour') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="far fa-clock"></i></label>
                        <input type="number" placeholder="Base Fare" name="base_rate" class="form-control" value="{{ old('base_rate') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-hourglass-half"></i></label>
                        <input type="number" placeholder="Subsequent Hour Rate" name="sub_rate" class="form-control" value="{{ old('sub_rate') }}" required>
                    </div>
                    <input type="hidden" name="action" value="create">
                </form>
                <button type="submit" form="create-rate" class="btn btn-default">Create</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

@foreach($pr as $p)

    <!--=====================
	edit assign hour modal
	=========================-->
    <div class="modal fade" id="edit-{{ $p->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div  class="modal-dialog" role="document">
            <div class="modal-content modal-form">
                <div class="modal-body text-center modal-padding">
                    <h3>Edit Parking Rate</h3>
                    <form method="post" id="edit-rate-{{ $p->id }}" action="{{ url('/settings/assign-rate') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="model-label" for="exampleFormControlSelect2">{{ $p->vehicle->type_name }}</label>
                        </div>
                        <div class="form-group">
                            <label for="user-name" class="usr-lock"><i class="fas fa-clock"></i></label>
                            <input type="text" placeholder="Base Hour" name="base_hour" class="form-control" value="{{ $p->base_hour }}">
                        </div>
                        <div class="form-group">
                            <label for="user-name" class="usr-lock"><i class="far fa-clock"></i></label>
                            <input type="text" placeholder="Base Fair" name="base_rate" class="form-control" value="{{ $p->base_rate }}">
                        </div>
                        <div class="form-group">
                            <label for="user-name" class="usr-lock"><i class="fas fa-hourglass-half"></i></label>
                            <input type="text" placeholder="Subsequent Hour Rate" name="sub_rate" class="form-control" value="{{ $p->sub_rate }}">
                        </div>
                        <input type="hidden" name="rate_id" value="{{ $p->id }}">
                        <input type="hidden" name="action" value="edit">
                    </form>
                    <button type="submit" form="edit-rate-{{ $p->id }}" class="btn btn-default">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

<!--
block/unblock modal
-->
<div class="modal fade" id="delete-{{ $p->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <form method="post" action="{{ url('/settings/assign-rate') }}">
                {{ csrf_field() }}
            <div class="modal-body text-center modal-padding">
                <div class="icon-delete text-center"><i class="fas fa-trash"></i></div>
                <p>Are you sure you want to delete this?</p>
                <input type="hidden" name="rate_id" value="{{ $p->id }}">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-default">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
            </form>
        </div>
    </div>
</div>
    @endforeach
