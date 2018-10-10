<!--=====================
	Reset password modal 
	=========================-->
<div class="modal fade" id="myModalz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <h3>Reset Password</h3>
                <form method="post" action="{{ url('/client-details?client_id='.$client->client_id) }}" id="reset-pass">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-lock"></i></label>
                        <input type="password" name="password" placeholder="Type new Password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-lock"></i></label>
                        <input type="password" name="repass" placeholder="Re-type new Password" class="form-control" required>
                    </div>
                    <input type="hidden" name="action" value="pass">
                </form>
                <button type="submit" form="reset-pass" class="btn btn-default">Confirm</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!--=====================
create manager modal
=========================-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <h3>Create Manager</h3>
                <form method="post" id="create-managers" action="{{ url('/client-details?client_id='.$client->client_id) }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-id-badge"></i></label>
                        <input type="text" name="manager_id" placeholder="ID" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-user"></i></label>
                        <input type="text" name="name" placeholder="Name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="far fa-envelope"></i></label>
                        <input type="email" name="email" placeholder="Email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-lock"></i></label>
                        <input type="password" name="password" placeholder="Password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-lock"></i></label>
                        <input type="password" name="repass" placeholder="Confirm Password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-phone"></i></label>
                        <input type="text" name="phone" placeholder="Phone" class="form-control" required>
                    </div>
                    <input type="hidden" name="role" value="manager">
                    <input type="hidden" name="action" value="crt-mngr">
                </form>
                <button type="submit" form="create-managers" class="btn btn-default">Create</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

@foreach($managers as $cm)
<!--=====================
edit manager modal
=========================-->
<div class="modal fade" id="edit-manager-{{ $cm->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <h3>Edit Manager</h3>
                <form method="post" id="edit-mngr-{{ $cm->id }}" action="{{ url('/client-details?client_id='.$client->client_id) }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-id-badge"></i></label>
                        <input type="text" name="manager_id" placeholder="ID" class="form-control" value="{{ $cm->manager_id }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-user"></i></label>
                        <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $cm->data->name }}">
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="far fa-envelope"></i></label>
                        <input type="email" name="email" placeholder="Email" class="form-control" value="{{ $cm->data->email }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-lock"></i></label>
                        <input type="password" name="password" placeholder="Password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-lock"></i></label>
                        <input type="password" name="repass" placeholder="Confirm Password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-phone"></i></label>
                        <input type="text" name="phone" placeholder="Phone" class="form-control" value="{{ $cm->phone }}">
                    </div>
                    <input type="hidden" name="manager_id" value="{{ $cm->id }}">
                    <input type="hidden" name="action" value="edit-mngr">
                </form>
                <button type="submit" form="edit-mngr-{{ $cm->id }}" class="btn btn-default">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!--
delete manager modal
-->
<div class="modal fade" id="delete-manager-{{ $cm->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <form method="post" action="{{ url('/client-details?client_id='.$client->client_id) }}">
            {{ csrf_field() }}
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <p>Are you sure you want to Delete <strong>{{ $cm->data->name }}</strong>?</p>
                <input type="hidden" name="action" value="delete-mngr">
                <input type="hidden" name="manager_id" value="{{ $cm->id }}">
                <button type="submit" class="btn btn-default">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
        </form>
    </div>
</div>

<!--
block modal
-->
<div class="modal fade" id="block-manager-{{ $cm->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <form method="post" action="{{ url('/client-details?client_id='.$client->client_id) }}">
                {{ csrf_field() }}
            <div class="modal-body text-center modal-padding">
                <p>Are you sure you want to @if($cm->data->status == 'block') {{ 'unblock' }} @else {{ 'block' }} @endif <strong>{{ $cm->data->name }}</strong>?</p>
                <input type="hidden" name="action" value="stat-mngr">
                <input type="hidden" name="manager_id" value="{{ $cm->id }}">
                <input type="hidden" name="status" value="@if($cm->data->status == 'block') {{ 'unblock' }} @else {{ 'block' }} @endif">
                <button type="submit" class="btn btn-default">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endforeach


<!--================
Assign device modal
=========================-->
<div class="modal fade model-that-hide" id="myModaltable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <table id="example3" class="table" style="width:100%">
                    <thead>
                    <tr>
                        <th>Serial</th>
                        <th>ID</th>
                        <th>Factory Serial</th>
                        <th>Select Device</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Dev0001</td>
                        <td>S/N04956679</td>
                        <td>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        </td>
                    </tr>
                    <tr>
                        <td>02</td>
                        <td>Dev0002</td>
                        <td>S/N04956679</td>
                        <td>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        </td>
                    </tr>
                    <tr>
                        <td>03</td>
                        <td>Dev0003</td>
                        <td>S/N04956679</td>
                        <td>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        </td>
                    </tr>
                    <tr>
                        <td>04</td>
                        <td>Dev0004</td>
                        <td>S/N04956679</td>
                        <td>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        </td>
                    </tr>
                    <tr>
                        <td>05</td>
                        <td>Dev0005</td>
                        <td>S/N04956679</td>
                        <td>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        </td>
                    </tr>
                    <tr>
                        <td>06</td>
                        <td>Dev0006</td>
                        <td>S/N04956679</td>
                        <td>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        </td>
                    </tr>
                    <tr>
                        <td>07</td>
                        <td>Dev0007</td>
                        <td>S/N04956679</td>
                        <td>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        </td>
                    </tr>
                    <tr>
                        <td>08</td>
                        <td>Dev0008</td>
                        <td>S/N04956679</td>
                        <td>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        </td>
                    </tr>
                </table>
                <button type="button" class="btn btn-default" id="modal-hide" data-toggle="modal" data-target="#assignmodal">Assign</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!--
assign device modal
-->
<div class="modal fade" id="assignmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <p>Are you sure you want to ADD
                <ol>
                    <li>Device 2</li>
                    <li>Device 3</li>
                </ol>
                </p>
                <button type="button" class="btn btn-default">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<!--
delete device modal
-->
<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <p>Are you sure you want to delete <strong>Device</strong> ?
                </p>
                <button type="button" class="btn btn-default">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>