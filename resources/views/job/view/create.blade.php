<div class="modal fade" id="form_create" data-bs-backdrop="static" tabindex="-1" aria-labelledby="formCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post" id="bt_submit_create">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="formCreateLabel">Tambah Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-bold">Nama <span class="text-danger">*</span></label>
                            <input type="text" id="nama" name="nama" class="form-control form-control-sm" placeholder="Nama" required>
                            <div id="namaError" class="text-danger"></div>
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
