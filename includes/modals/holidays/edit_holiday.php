<div class="modal custom-modal fade" id="edit_holiday" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Holiday</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="editHolidayForm">
					<div class="form-group">
						<label for="editHolidayName">Holiday Name <span class="text-danger">*</span></label>
						<input id="editHolidayName" class="form-control" name="holiday_name" type="text">
					</div>
					<input id="" class="form-control" name="holiday_id" type="hidden">
					<div class="form-group">
						<label for="editHolidayDate">Holiday Date <span class="text-danger">*</span></label>
						<div class="">
							<input id="editHolidayDate" name="holiday_date" class="form-control " type="date">
						</div>
					</div>
					<div class="submit-section">
						<button type="submit" class="btn btn-primary submit-btn">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>