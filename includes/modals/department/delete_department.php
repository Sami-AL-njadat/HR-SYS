<div class="modal custom-modal fade" id="delete_department" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Department</h3>
                    <p>Are you sure want to delete? <span hidden id="dep_id_to_delete"></span></p>
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
function setDepToDelete(depr) {

    console.log(depr, 'Recycle.Bin');
    $('#dep_id_to_delete').text(depr);
}

function confirmDelete() {
    window.location.href = 'departments.php?delid=' + $('#dep_id_to_delete').text();
}
</script>