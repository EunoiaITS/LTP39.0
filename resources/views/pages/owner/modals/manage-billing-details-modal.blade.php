@foreach($billing as $b)
<div class="modal fade model-that-hide" id="myModal-" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <form id="bill" action="{{ url('/payment') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="transaction-id">Transaction ID</label>
                        <input type="text" name="transaction_id" placeholder="20463485223" class="form-control" required>
                    </div>
                </form>
                <button type="button" class="btn btn-default" id="modal-hide" data-toggle="modal" data-target="#myModalCon-{{ $b->id }}">Okay</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($billing as $b)
<div class="modal fade" id="myModalCon-" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <p>Are you sure The Transaction is Done?</p>
                <button type="submit" form="bill" class="btn btn-default">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endforeach