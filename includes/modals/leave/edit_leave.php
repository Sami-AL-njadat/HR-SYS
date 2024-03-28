<div id="edit_leave" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Leave</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post">
					<div class="form-group">
						<label>Leave Type <span class="text-danger">*</span></label>
						<select class="select">
							<option>Select Leave Type</option>
							<option>Casual Leave 12 Days</option>
						</select>
					</div>
					<div class="form-group">
						<label>From <span class="text-danger">*</span></label>
						<div class="">
							<input class="form-control " name="starting_at" id="starting_at" type="date">
						</div>
						<input class="form-control " name="id" id="" value="" type="hidden">

					</div>
					<div class="form-group">
						<label>To <span class="text-danger">*</span></label>
						<div class="">
							<input class="form-control " name="ends_on" id="ends_on" type="date">
						</div>
					</div>
					<div class="form-group">
						<label>Number of days <span class="text-danger">*</span></label>
						<input class="form-control" name="days_count" id='days_count' readonly="" type="text" value="2">
					</div>
					<div class="form-group">
						<label>Remaining Leaves <span class="text-danger">*</span></label>
						<input class="form-control" readonly="" value="12" type="text">
					</div>
					<div class="form-group">
						<label>Leave Reason <span class="text-danger">*</span></label>
						<textarea rows="4" name="reason" id="form-control reason">Going to hospital</textarea>
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn" name="edit_leave">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>