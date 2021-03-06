@foreach($data as $d)

    <!--=====================
edit manager modal
=========================-->
    <div class="modal fade" id="edit-{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div  class="modal-dialog" role="document">
            <div class="modal-content modal-form">
                <div class="modal-body text-center modal-padding">
                    <h3>Edit Vehicle Category</h3>
                    <form method="post" id="edit-v-{{ $d->id }}" action="{{ url('/settings/vehicle-types') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="user-name" class="usr-lock"><i class="fas fa-id-badge"></i></label>
                            <input type="text" name="type_id" placeholder="ID" class="form-control" value="{{ $d->type_id }}">
                        </div>
                        <div class="form-group">
                            <label for="user-name" class="usr-lock"><i class="fas fa-car"></i></label>
                            <input type="text" name="type_name" placeholder="Name" class="form-control" value="{{ $d->type_name }}">
                        </div>
                        <input type="hidden" name="vehicle_id" value="{{ $d->id }}">
                        <input type="hidden" name="action" value="edit">
                    </form>
                    <button type="submit" form="edit-v-{{ $d->id }}" class="btn btn-default">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

<!--
	block/unblock modal 
	-->
<div class="modal fade" id="delete-{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <form method="post" action="{{ url('/settings/vehicle-types') }}">
                {{ csrf_field() }}
            <div class="modal-body text-center modal-padding">
                <div class="icon-delete text-center"><i class="fas fa-trash"></i></div>
                <p>Are you sure you want to delete this?</p>
                <input type="hidden" name="vehicle_id" value="{{ $d->id }}">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-default">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
            </form>
        </div>
    </div>
</div>
    @endforeach