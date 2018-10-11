@foreach($ps as $p)

    <!--=====================
edit manager modal
=========================-->
    <div class="modal fade" id="edit-p-{{ $p->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div  class="modal-dialog" role="document">
            <div class="modal-content modal-form">
                <div class="modal-body text-center modal-padding">
                    <h3>Edit Assign Amount</h3>
                    <form method="post" id="edit-{{ $p->id }}" action="{{ url('/settings/assign-parking') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="user-name" class="usr-lock"><i class="fas fa-car"></i></label>
                            <input type="text" name="amount" placeholder="Name" class="form-control" value="{{ $p->amount }}">
                        </div>
                        <input type="hidden" name="setting_id" value="{{ $p->id }}">
                        <input type="hidden" name="action" value="edit">
                    </form>
                    <button type="submit" form="edit-{{ $p->id }}" class="btn btn-default">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

<!--
	delete modal 
	-->
<div class="modal fade" id="delete-{{ $p->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <form method="post" id="edit-{{ $p->id }}" action="{{ url('/settings/assign-parking') }}">
                {{ csrf_field() }}
            <div class="modal-body text-center modal-padding">
                <div class="icon-delete text-center"><i class="fas fa-trash"></i></div>
                <p>Are you sure you want to delete this?</p>
                <input type="hidden" name="setting_id" value="{{ $p->id }}">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-default">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
            </form>
        </div>
    </div>
</div>
    @endforeach