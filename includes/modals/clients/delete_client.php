<div class="modal custom-modal fade" id="delete_client" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Client</h3>
                    <p>Are you sure want to delete? <span hidden id="client_id_to_delete"></span></p>
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
    function setClientsToDelete(client) {

        console.log(client, 'Recycle.Bin');
        $('#client_id_to_delete').text(client);
    }

    function confirmDelete() {
        window.location.href = 'clients.php?delid=' + $('#client_id_to_delete').text();
    }
</script>