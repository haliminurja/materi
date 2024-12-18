<div class="modal fade" id="form_create" data-bs-backdrop="static" tabindex="-1" aria-labelledby="formCreateLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post" id="bt_submit_create" enctype="multipart/form-data">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="formCreateLabel">Tambah Employe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <!-- Nama -->
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" id="nama" name="nama" class="form-control"
                                placeholder="Nama Employe" required>
                            <div id="namaError" class="text-danger"></div>
                        </div>

                        <!-- Telepon -->
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" id="telepon" name="telepon" class="form-control"
                                placeholder="Nomor Telepon" required>
                            <div id="teleponError" class="text-danger"></div>
                        </div>

                        <!-- Job -->
                        <div class="col-md-6 mb-3">
                            <label for="id_job" class="form-label">Job</label>
                            <select id="id_job" name="id_job" class=" form-select" data-live-search="true" required>
                                <option value="" disabled selected>Pilih Job</option>
                                <!-- Data job diisi secara dinamis -->
                            </select>
                            <div id="id_jobError" class="text-danger"></div>
                        </div>

                        <!-- Alamat -->
                        <div class="col-md-6 mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" id="alamat" name="alamat" class="form-control"
                                placeholder="Alamat" required>
                            <div id="alamatError" class="text-danger"></div>
                        </div>

                        <!-- Provinsi -->
                        <div class="col-md-6 mb-3">
                            <label for="id_prov" class="form-label">Provinsi</label>
                            <select id="id_prov" name="id_prov" class=" form-select" data-live-search="true" required>
                            </select>
                            <div id="id_provError" class="text-danger"></div>
                        </div>

                        <!-- Kabupaten -->
                        <div class="col-md-6 mb-3">
                            <label for="id_kab" class="form-label">Kabupaten</label>
                            <select id="id_kab" name="id_kab" class=" form-select" data-live-search="true" required>
                            </select>
                            <div id="id_kabError" class="text-danger"></div>
                        </div>

                        <!-- Kecamatan -->
                        <div class="col-md-6 mb-3">
                            <label for="id_kec" class="form-label">Kecamatan</label>
                            <select id="id_kec" name="id_kec" class=" form-select" data-live-search="true" required>
                            </select>
                            <div id="id_kecError" class="text-danger"></div>
                        </div>

                        <!-- Kelurahan -->
                        <div class="col-md-6 mb-3">
                            <label for="id_kel" class="form-label">Kelurahan</label>
                            <select id="id_kel" name="id_kel" class=" form-select" data-live-search="true" required>
                            </select>
                            <div id="id_kelError" class="text-danger"></div>
                        </div>

                        <!-- Foto -->
                        <div class="col-md-6 mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" id="foto" name="foto" class="form-control"
                                accept="image/*" required>
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
