<!-- 
	exampted time modal 
	-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <p>No parking Fees Will be Charged Form <br>  <strong>9 PM</strong> to <strong>8 AM</strong></p>
                <button type="submit" form="time" class="btn btn-default">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Delete</button>
            </div>
        </div>
    </div>
</div>

<!--
Duration time modal
-->
<div class="modal fade model-that-hide" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <p>No parking Fees Will be Charged For First <br>  <strong>20 minutes</strong></p>
                <button type="submit" form="duration" class="btn btn-default">Save</button>
                <button type="button" class="btn btn-default modal-hide" data-toggle="modal" data-target="#myModal3">Delete</button>
            </div>
        </div>
    </div>
</div>

<!--
delete modal
-->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <div class="modal-body text-center modal-padding">
                <div class="icon-delete text-center"><i class="fas fa-trash"></i></div>
                <p>Are you sure you want to delete this?</p>
                <button type="button" class="btn btn-default">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>