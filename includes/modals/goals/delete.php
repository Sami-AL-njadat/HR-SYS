<div class="modal custom-modal fade" id="delete_goal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Goal Tracking List</h3>
                    <p>Are you sure want to delete? <span hidden id="id_to_delete"></span></p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <a href="#" class="btn btn-primary continue-btn" onclick="confirmDelete()">Delete</a>

                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0);" data-dismiss="modal"
                                class="btn btn-primary cancel-btn">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function setToDelete(dele) {

    console.log(dele, 'dlete id');
    $('#id_to_delete').text(dele);
}

function confirmDelete() {
    window.location.href = 'goal-tracking.php?delid=' + $('#id_to_delete').text();
}
</script>