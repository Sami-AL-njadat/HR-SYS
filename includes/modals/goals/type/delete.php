<div class="modal custom-modal fade" id="delete_type" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<div class="form-header">
					<h3>Delete Goal Type</h3>
					<p>Are you sure want to delete? <span hidden id="goal_type_id_to_delete"></span></p>
				</div>
				<div class="modal-btn delete-action">
					<div class="row">
						<div class="col-6">
							<a href="#" class="btn btn-primary continue-btn" onclick="confirmDelete()">Delete</a>
						</div>
						<div class="col-6">
							<button type="button" class="btn btn-primary cancel-btn" data-dismiss="modal">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function setGotyToDelete(goty) {
		$('#goal_type_id_to_delete').text(goty);
	}

	function confirmDelete() {
		window.location.href = 'goal-type.php?delid=' + $('#goal_type_id_to_delete').text();
	}
</script>