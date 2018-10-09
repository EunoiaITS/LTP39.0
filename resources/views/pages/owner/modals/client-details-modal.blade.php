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
                <form action="#">
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-id-badge"></i></label>
                        <input type="text" placeholder="ID" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-user"></i></label>
                        <input type="text" placeholder="Name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="far fa-envelope"></i></label>
                        <input type="email" placeholder="Email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-lock"></i></label>
                        <input type="password" placeholder="Password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-lock"></i></label>
                        <input type="password" placeholder="Confirm Password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user-name" class="usr-lock"><i class="fas fa-phone"></i></label>
                        <input type="text" placeholder="Phone" class="form-control" required>
                    </div>
                </form>
                <button type="button" class="btn btn-default">Create</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<!--
delete manager modal
-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <p>Are you sure you want to Delete <strong>Employee Name</strong>?</p>
                <button type="button" class="btn btn-default">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<!--
block modal
-->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <p>Are you sure you want to block <strong>Manager 1</strong>?</p>
                <button type="button" class="btn btn-default">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<!--
unblock modal
-->
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <p>Are you sure you want to unblock <strong>Manager 1</strong>?</p>
                <button type="button" class="btn btn-default">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>


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