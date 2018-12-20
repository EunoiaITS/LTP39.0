@foreach($employees as $e)
    <div class="modal fade" id="myModalEmp-{{ $e->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div  class="modal-dialog" role="document">
            <div class="modal-content modal-form">
                <div class="modal-body text-center modal-padding">
                    <h3>Edit Employee</h3>
                    <form action="{{ url('/edit-employee') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="user-name" class="usr-lock"><i class="fas fa-user"></i></label>
                            <input name="name" type="text" placeholder="Employee Name" class="form-control" value="{{ $e->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="user-name" class="usr-lock"><i class="fas fa-phone"></i></label>
                            <input name="phone" type="text" placeholder="Phone" class="form-control" value="{{ $e->phone }}" required>
                        </div>
                        <input type="hidden" name="emp_id" value="{{ $e->id }}">
                        <button type="submit" class="btn btn-default">Confirm</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach




<!--=====================
edit password modal
=========================-->
@foreach($employees as $e)
    <div class="modal fade" id="myModalPass-{{ $e->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div  class="modal-dialog" role="document">
            <div class="modal-content modal-form">
                <div class="modal-body text-center modal-padding">
                    <h3>Edit Password</h3>
                    <form action="{{ url('/edit-password') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group clearfix">
                            <label for="user-name" class="usr-name-lock"><i class="fas fa-user"></i></label>
                            <span class="emp-name">{{ $e->name }}</span>
                        </div>
                        <!--<div class="form-group">
                            <label for="user-name" class="usr-lock"><i class="fas fa-lock"></i></label>
                            <input name="old_password" type="password" placeholder="Old Password" class="form-control" required>
                        </div>-->
                        <div class="form-group">
                            <label for="user-name" class="usr-lock"><i class="fas fa-lock"></i></label>
                            <input name="password" type="password" placeholder="Password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="user-name" class="usr-lock"><i class="fas fa-lock"></i></label>
                            <input name="repass" type="password" placeholder="Re-type Password" class="form-control" required>
                        </div>
                        <input type="hidden" name="emp_id" value="{{ $e->id }}">
                        <button type="submit" class="btn btn-default">Confirm</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!--
block/unblock modal
-->
@foreach($employees as $e)
    <div class="modal fade" id="myModalBlock-{{ $e->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div  class="modal-dialog" role="document">
            <div class="modal-content modal-form">
                <form action="{{ url('/blocking') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body text-center modal-padding">
                        <p>Are you sure you want to block <strong>{{ $e->name }}</strong>?</p>
                        <input type="hidden" name="emp_id" value="{{ $e->id }}">
                        <input type="hidden" name="status" value="@if($e->status == 'block') {{ 'unblock' }} @else {{ 'block' }} @endif">
                        <button type="submit" class="btn btn-default">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@foreach($employees as $e)
    <div class="modal fade" id="myModalDel-{{ $e->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div  class="modal-dialog" role="document">
            <div class="modal-content modal-form">
                <form action="{{ url('/delete-employee') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body text-center modal-padding">
                        <p>Are you sure you want to Delete <strong>{{ $e->name }}</strong> ?</p>
                        <input type="hidden" name="emp_id" value="{{ $e->id }}">
                        <button type="submit" class="btn btn-default">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach