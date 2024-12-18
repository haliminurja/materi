<div class="modal fade" id="form_edit" data-bs-backdrop="static" tabindex="-1" aria-labelledby="formEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post" id="bt_submit_edit">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="formEditLabel">Pebaruan Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <!-- Nama Field -->
                        <div class=" mb-3">
                            <label for="edit_data_nama" class="form-label fw-bold">Nama <span class="text-danger">*</span></label>
                            <input type="text" id="edit_data_nama" name="edit_data_nama" class="form-control form-control-sm" placeholder="Nama" required>
                            <div id="edit_data_namaError" class="text-danger"></div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
