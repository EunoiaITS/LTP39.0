<!--
	block modal
	-->
@foreach($clients as $client)
    <div class="modal fade" id="myModal{{ $client->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div  class="modal-dialog" role="document">
            <div class="modal-content modal-form">
                <form method="post" action="{{ url('/clients-list') }}">
                    {{ csrf_field() }}
                    <div class="modal-body text-center modal-padding">
                        <p>Are you sure you want to @if(isset($client->data->status))@if($client->data->status == 'block') {{ 'unblock' }} @else {{ 'block' }} @endif @endif<strong>@if(isset($client->data->name)){{ $client->data->name }}@endif</strong>?</p>
                        <input type="hidden" name="status" value="@if(isset($client->data->status))@if($client->data->status == 'block') {{ 'unblock' }} @else {{ 'block' }} @endif @endif">
                        <input type="hidden" name="client_id" value="{{ $client->user_id }}">
                        <input type="hidden" name="action" value="blocking">
                        <button type="submit" class="btn btn-default">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<!--
	delete modal
	-->
@foreach($clients as $client)
    <div class="modal fade" id="myModalDel{{ $client->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div  class="modal-dialog" role="document">
            <div class="modal-content modal-form">
                <form method="post" action="{{ url('/clients-list') }}">
                    {{ csrf_field() }}
                    <div class="modal-body text-center modal-padding">
                        <p>Are you sure you want to delete <strong>@if(isset($client->data->name)){{ $client->data->name }}@endif</strong>?</p>
                        <input type="hidden" name="client_id" value="{{ $client->user_id }}">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit" class="btn btn-default">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach