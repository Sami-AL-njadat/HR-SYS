<div class="modal custom-modal fade" id="delete_overtime" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Goal Tracking List</h3>
                    <p>Are you sure want to delete? <span id="id_to_delete"></span></p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <a href="#" class="btn btn-primary continue-btn" onclick="confirmDeletsse()">Delete</a>

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
function setToDelete(delew) {

    console.log(delew, 'dlete id');
    $('#id_to_delete').text(delew);
}

function confirmDeletsse() {
    window.location.href = 'payroll-items.php?delids=' + $('#id_to_delete').text();
}
</script>