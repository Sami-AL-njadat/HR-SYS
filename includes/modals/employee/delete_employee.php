<div class="modal custom-modal fade" id="delete_employee" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<div class="form-header">
					<h3>Delete Employee</h3>
					<p>Are you sure want to delete employee ID: <span id="employee_id_to_delete"></span>?</p>
				</div>
				<div class="modal-btn delete-action">
					<div class="row">
						<div class="col-6">
							<a href="#" class="btn btn-primary continue-btn" onclick="confirmDelete()">Delete</a>
						</div>
						<div class="col-6">
							<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function setEmployeeIdToDelete(employeeId) {
		$('#employee_id_to_delete').text(employeeId);
	}

	function confirmDelete() {
		// You can perform additional actions here before deleting
		window.location.href = 'employees.php?delid=' + $('#employee_id_to_delete').text();
	}
</script>