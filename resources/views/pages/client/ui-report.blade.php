@extends('layout')
@section('content')

    <!-- main-content area -->
    <div class="dashboard-main-content clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 dashboad-title">
                    <h2>Reports <img src="img/down-arrow.png" alt=""></h2>
                    <h4 class="date">Users income</h4>
                    <h4 class="total-strong"><strong>Total</strong></h4>
                </div>
                <div class="col-sm-12 total-area padding-0">
                    <div class="col-sm-6 col-md-3">
                        <div class="calender-area-date">
                            <div class="date-icon">
                                <span>D</span>
                            </div>
                            <div class="date-timepicker">
                                <h4 class="date-span">330</h4>
                                <div class="per">+5%</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="calender-area-date">
                            <div class="date-icon">
                                <span>W</span>
                            </div>
                            <div class="date-timepicker">
                                <h4 class="date-span">2310</h4>
                                <div class="per">+5%</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="calender-area-date">
                            <div class="date-icon">
                                <span>M</span>
                            </div>
                            <div class="date-timepicker">
                                <h4 class="date-span">69,300</h4>
                                <div class="per">+5%</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="calender-area-date">
                            <div class="date-icon">
                                <span>Y</span>
                            </div>
                            <div class="date-timepicker">
                                <h4 class="date-span">800,600</h4>
                                <div class="per">+5%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 vechicale-catagory padding-0">
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="vechicle-select">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">(Must Select One)</label>
                                <select class="form-control get-select-picker" id="exampleFormControlSelect1" title="Select Employee">
                                    <option value="">Ali</option>
                                    <option value="">Rahman</option>
                                    <option value="">Khan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="vechicle-select">
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">(Must Select One)</label>
                                <select class="form-control get-select-picker" id="exampleFormControlSelect2" title="Duration Selection">
                                    <option value="">Daily</option>
                                    <option value="">Weekly</option>
                                    <option value="">Monthly</option>
                                    <option value="">Yearly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6 col-lg-offset-0 col-lg-4">
                        <div class="or-vechicle">OR</div>
                        <div class="vechicle-select optional-or">
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">(Optional)</label>
                                <input type="text" class="form-control datepicker-f" placeholder="Form">
                                <input type="text" class="form-control datepicker-f" placeholder="To">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="employee-table-center clearfix">
                        <table id="example" class="table" style="width:100%">
                            <thead>
                            <tr>
                                <th>Serial</th>
                                <th>ID</th>
                                <th>Employee Name</th>
                                <th>Vehicle Registration</th>
                                <th>Ticket No.</th>
                                <th>Time</th>
                                <th>Collection</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>EMP001</td>
                                <td>Rahman</td>
                                <td>Da 0007</td>
                                <td>C00001</td>
                                <td>07:00 AM</td>
                                <td>BDT. 7777</td>
                                <td>16/09/18</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>EMP002</td>
                                <td>Rahman</td>
                                <td>Da 0007</td>
                                <td>C00001</td>
                                <td>07:00 AM</td>
                                <td>BDT. 7777</td>
                                <td>16/09/18</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>EMP003</td>
                                <td>Rahman</td>
                                <td>Da 0007</td>
                                <td>C00001</td>
                                <td>07:00 AM</td>
                                <td>BDT. 7777</td>
                                <td>16/09/18</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>EMP004</td>
                                <td>Rahman</td>
                                <td>Da 0007</td>
                                <td>C00001</td>
                                <td>07:00 AM</td>
                                <td>BDT. 7777</td>
                                <td>16/09/18</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>EMP005</td>
                                <td>Rahman</td>
                                <td>Da 0007</td>
                                <td>C00001</td>
                                <td>07:00 AM</td>
                                <td>BDT. 7777</td>
                                <td>16/09/18</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>EMP006</td>
                                <td>Rahman</td>
                                <td>Da 0007</td>
                                <td>C00001</td>
                                <td>07:00 AM</td>
                                <td>BDT. 7777</td>
                                <td>16/09/18</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>EMP007</td>
                                <td>Rahman</td>
                                <td>Da 0007</td>
                                <td>C00001</td>
                                <td>07:00 AM</td>
                                <td>BDT. 7777</td>
                                <td>16/09/18</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>EMP008</td>
                                <td>Rahman</td>
                                <td>Da 0007</td>
                                <td>C00001</td>
                                <td>07:00 AM</td>
                                <td>BDT. 7777</td>
                                <td>16/09/18</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>EMP009</td>
                                <td>Rahman</td>
                                <td>Da 0007</td>
                                <td>C00001</td>
                                <td>07:00 AM</td>
                                <td>BDT. 7777</td>
                                <td>16/09/18</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>EMP010</td>
                                <td>Rahman</td>
                                <td>Da 0007</td>
                                <td>C00001</td>
                                <td>07:00 AM</td>
                                <td>BDT. 7777</td>
                                <td>16/09/18</td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>EMP011</td>
                                <td>Rahman</td>
                                <td>Da 0007</td>
                                <td>C00001</td>
                                <td>07:00 AM</td>
                                <td>BDT. 7777</td>
                                <td>16/09/18</td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>EMP012</td>
                                <td>Rahman</td>
                                <td>Da 0007</td>
                                <td>C00001</td>
                                <td>07:00 AM</td>
                                <td>BDT. 7777</td>
                                <td>16/09/18</td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>EMP013</td>
                                <td>Rahman</td>
                                <td>Da 0007</td>
                                <td>C00001</td>
                                <td>07:00 AM</td>
                                <td>BDT. 7777</td>
                                <td>16/09/18</td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>EMP014</td>
                                <td>Rahman</td>
                                <td>Da 0007</td>
                                <td>C00001</td>
                                <td>07:00 AM</td>
                                <td>BDT. 7777</td>
                                <td>16/09/18</td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td>EMP015</td>
                                <td>Rahman</td>
                                <td>Da 0007</td>
                                <td>C00001</td>
                                <td>07:00 AM</td>
                                <td>BDT. 7777</td>
                                <td>16/09/18</td>
                            </tr>
                            <tr>
                                <td>16</td>
                                <td>EMP016</td>
                                <td>Rahman</td>
                                <td>Da 0007</td>
                                <td>C00001</td>
                                <td>07:00 AM</td>
                                <td>BDT. 7777</td>
                                <td>16/09/18</td>
                            </tr>
                            <tr>
                                <td>17</td>
                                <td>EMP017</td>
                                <td>Rahman</td>
                                <td>Da 0007</td>
                                <td>C00001</td>
                                <td>07:00 AM</td>
                                <td>BDT. 7777</td>
                                <td>16/09/18</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection