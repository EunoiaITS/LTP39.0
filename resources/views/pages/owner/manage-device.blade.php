@extends('layout')
@section('content')
<!-- main-content area -->
<div class="dashboard-main-content clearfix">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 dashboad-title">
                <h2>Manage Device</h2>
                <div class="alert alert-danger" role="alert">
                    Device Has Been Deleted
                </div>
            </div>
            <div class="col-sm-12">
                <div class="employee-table-center clearfix">
                    <table id="example" class="table" style="width:100%">
                        <thead>
                        <tr>
                            <th>Serial</th>
                            <th>ID</th>
                            <th>Factory Serial</th>
                            <th>Charger Serial</th>
                            <th>Client Name <i class="fas fa-arrow-alt-circle-down"></i></th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>01</td>
                            <td>DEV00001</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>Boshundhora City</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>02</td>
                            <td>DEV00002</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>Jomuna Park</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>03</td>
                            <td>DEV00003</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>Jomuna Park</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>04</td>
                            <td>DEV00004</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>N/A</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>05</td>
                            <td>DEV00005</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>N/A</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>06</td>
                            <td>DEV00006</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>N/A</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>07</td>
                            <td>DEV00007</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>N/A</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>08</td>
                            <td>DEV00008</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>N/A</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>09</td>
                            <td>DEV00009</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>N/A</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>DEV00010</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>N/A</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>DEV00004</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>N/A</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>DEV00004</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>N/A</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td>DEV00004</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>N/A</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>DEV00004</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>N/A</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td>DEV00004</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>N/A</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>16</td>
                            <td>DEV00004</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>N/A</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>17</td>
                            <td>DEV00004</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>N/A</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>18</td>
                            <td>DEV00004</td>
                            <td>S/N0293939</td>
                            <td>S/N8893993</td>
                            <td>N/A</td>
                            <td>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal2">Edit</button>
                                <button class="edit-icon btn btn-login" data-toggle="modal" data-target="#myModal3">Delete</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!--=====================
edit password modal
=========================-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form modal-device">
            <div class="modal-body text-center modal-padding">
                <h3>Edit Charger Serial</h3>
                <form action="#">
                    <div class="form-group">
                        <label for="user-name">Charger Serial</label>
                        <input type="text" placeholder="S/N8893993" class="form-control" required>
                    </div>
                </form>
                <button type="button" class="btn btn-default">Confirm</button>
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
                <p>Are you sure?</p>
                <button type="button" class="btn btn-default">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
@endsection