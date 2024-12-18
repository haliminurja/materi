<!-- Modal Edit Job -->
<div class="modal fade" id="form_edit" data-bs-backdrop="static" tabindex="-1" aria-labelledby="formEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post" id="bt_submit_edit">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="formEditLabel">Perbarui Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Nama -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_data_nama" class="form-label">Nama</label>
                            <input type="text" id="edit_data_nama" name="edit_data_nama" class="form-control"
                                placeholder="Nama Employe" required>
                            <div id="namaError" class="text-danger"></div>
                        </div>

                        <!-- Telepon -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_data_telepon" class="form-label">Telepon</label>
                            <input type="text" id="edit_data_telepon" name="edit_data_telepon" class="form-control"
                                placeholder="Nomor Telepon" required>
                            <div id="teleponError" class="text-danger"></div>
                        </div>

                        <!-- Job -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_data_id_job" class="form-label">Job</label>
                            <select id="edit_data_id_job" name="edit_data_id_job" class=" form-select" data-live-search="true" required>
                                <option value="" disabled selected>Pilih Job</option>
                                <!-- Data job diisi secara dinamis -->
                            </select>
                            <div id="id_jobError" class="text-danger"></div>
                        </div>

                        <!-- Alamat -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_data_alamat" class="form-label">Alamat</label>
                            <input type="text" id="edit_data_alamat" name="edit_data_alamat" class="form-control"
                                placeholder="Alamat" required>
                            <div id="alamatError" class="text-danger"></div>
                        </div>

                        <!-- Provinsi -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_data_id_prov" class="form-label">Provinsi</label>
                            <select id="edit_data_id_prov" name="edit_data_id_prov" class=" form-select" data-live-search="true" required>
                            </select>
                            <div id="id_provError" class="text-danger"></div>
                        </div>

                        <!-- Kabupaten -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_data_id_kab" class="form-label">Kabupaten</label>
                            <select id="edit_data_id_kab" name="edit_data_id_kab" class=" form-select" data-live-search="true" required>
                            </select>
                            <div id="id_kabError" class="text-danger"></div>
                        </div>

                        <!-- Kecamatan -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_data_id_kec" class="form-label">Kecamatan</label>
                            <select id="edit_data_id_kec" name="edit_data_id_kec" class=" form-select" data-live-search="true" required>
                            </select>
                            <div id="id_kecError" class="text-danger"></div>
                        </div>

                        <!-- Kelurahan -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_data_id_kel" class="form-label">Kelurahan</label>
                            <select id="edit_data_id_kel" name="edit_data_id_kel" class=" form-select" data-live-search="true" required>
                            </select>
                            <div id="id_kelError" class="text-danger"></div>
                        </div>

                        <!-- Foto -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_data_foto" class="form-label">Foto</label>
                            <input type="file" id="edit_data_foto" name="edit_data_foto" class="form-control mb-4"  accept="image/*">
                            <img src="" id="edit_data_preview" class="img-fluid">
                            <div id="fotoError" class="text-danger"></div>

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
