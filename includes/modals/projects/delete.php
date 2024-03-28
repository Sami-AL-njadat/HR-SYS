<!-- Modal for delete confirmation -->
<div class="modal custom-modal fade" id="delete_project" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Project</h3>
                    <p>Are you sure you want to delete project <span hidden id="projId_to_delete"></span>?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <a href="#" class="btn btn-primary continue-btn" onclick="confirmDelete()">Delete</a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="btn btn-primary cancel-btn" data-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
function setProjToDelete(projId) {
    $('#projId_to_delete').text(projId);
}

function confirmDelete() {
    // You can perform additional actions here before deleting
    var projectId = $('#projId_to_delete').text();
    window.location.href = 'projects.php?delid=' + projectId;
}
</script>