<div class="modal custom-modal fade" id="delete_designation" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Designation</h3>
                    <p>Are you sure want to delete? <span hidden id="desi_id_to_delete"></span></p>
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
function setDesiToDelete(desi) {

    console.log(desi, 'Recycle.Bin');
    $('#desi_id_to_delete').text(desi);
}

function confirmDelete() {
    window.location.href = 'designations.php?delid=' + $('#desi_id_to_delete').text();
}
</script>