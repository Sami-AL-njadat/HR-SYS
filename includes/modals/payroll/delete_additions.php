<div class="modal custom-modal fade" id="delete_addition" role="dialog">
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
                            <a href="#" class="btn btn-primary continue-btn" onclick="confirmDeletse()">Delete</a>

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
    function setccToDelete(deles) {

        console.log(deles, 'dlete id');
        $('#id_to_delete').text(deles);
    }


    function confirmDeletse() {
        window.location.href = 'payroll-items.php?addes=' + $('#id_to_delete').text();
    }
</script>