<!--=====================
	create assign hour modal 
	=========================-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <h3>Add Parking Rate</h3>
                <form method="post" id="create" action="{{ url('/settings/vip-parking') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="model-label" for="exampleFormControlSelect2">Vehicle Type</label>
                        <select class="form-control get-select-picker" name="vehicle_id" id="exampleFormControlSelect2" title="Vehicle Category">
                            @foreach($vc as $v)
                            <option value="{{ $v->id }}" @if(old('vehicle_id') == $v->id) {{ 'selected' }} @endif>{{ $v->type_name }}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-clock"></i></label>
                        <input type="text" placeholder="Time" name="duration" class="form-control" value="{{ old('duration') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="far fa-clock"></i></label>
                        <input type="text" placeholder="Fair" name="fair" class="form-control" value="{{ old('fair') }}" required>
                    </div>
                    <input type="hidden" name="action" value="create">
                </form>
                <button type="submit" form="create" class="btn btn-default">Create</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


@foreach($vip as $v)

    <!--=====================
	edit assign hour modal
	=========================-->
    <div class="modal fade" id="edit-modal-{{ $v->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div  class="modal-dialog" role="document">
            <div class="modal-content modal-form">
                <div class="modal-body text-center modal-padding">
                    <h3>Edit Parking Rate</h3>
                    <form method="post" id="edit-{{ $v->id }}" action="{{ url('/settings/vip-parking') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="model-label" for="exampleFormControlSelect2">{{ $v->category->type_name }}</label>
                        </div>
                        <div class="form-group">
                            <label for="user-name" class="usr-lock"><i class="fas fa-clock"></i></label>
                            <input type="text" placeholder="Time" name="duration" class="form-control" value="{{ $v->duration }}">
                        </div>
                        <div class="form-group">
                            <label for="user-name" class="usr-lock"><i class="far fa-clock"></i></label>
                            <input type="text" placeholder="Fair" name="fair" class="form-control" value="{{ $v->fair }}">
                        </div>
                        <input type="hidden" name="vip_id" value="{{ $v->id }}">
                        <input type="hidden" name="action" value="edit">
                    </form>
                    <button type="submit" form="edit-{{ $v->id }}" class="btn btn-default">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
<!--
block/unblock modal
-->
<div class="modal fade" id="delete-modal-{{ $v->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <form method="post" action="{{ url('/settings/vip-parking') }}">
                {{ csrf_field() }}
            <div class="modal-body text-center modal-padding">
                <div class="icon-delete text-center"><i class="fas fa-trash"></i></div>
                <p>Are you sure you want to delete this?</p>
                <input type="hidden" name="vip_id" value="{{ $v->id }}">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-default">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
            </form>
        </div>
    </div>
</div>
    @endforeach