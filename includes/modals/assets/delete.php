<div class="modal custom-modal fade" id="delete_asset" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Asset</h3>
                    <p>Are you sure want to delete? <span hidden id="assets_id_to_delete"></span></p>
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
    function setAssetToDelete(asset) {

        console.log(asset, 'Recycle.Bin');
        $('#assets_id_to_delete').text(asset);
    }

    function confirmDelete() {
        window.location.href = 'assets.php?delid=' + $('#assets_id_to_delete').text();
    }
</script>