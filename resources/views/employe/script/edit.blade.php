<script defer>
    // Ketika modal edit ditampilkan
    $("#form_edit").on("show.bs.modal", function(e) {
        $("#bt_submit_edit")[0].reset(); // Reset form
        const button = $(e.relatedTarget); // Tombol yang memicu modal
        id = button.data("id"); // Ambil ID dari tombol

        const detailUrl = '{{ route('employe.show', [':id']) }}'.replace(':id', id);
        $.ajax({
            url: detailUrl,
            type: 'GET',
            beforeSend: function() {
                Swal.fire({
                    title: 'Memuat data...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                Swal.close();
                if (response.success) {
                    // Isi form dengan data yang didapatkan dari server
                    $("#edit_data_nama").val(response.data.nama);
                    $("#edit_data_alamat").val(response.data.alamat);
                    $("#edit_data_telepon").val(response.data.telepon);
                    fetchDataDropdown("{{ route('job.job') }}","#edit_data_id_job", "id_job", "nama",()=>{
                        $("#edit_data_id_job").val(response.data.id_job);
                    });
                    fetchDataDropdown("{{ route('wilayah.provinsi') }}","#edit_data_id_prov", "id_prov", "nama",() =>{
                        $("#edit_data_id_prov").val(response.data.id_prov);
                        fetchDataDropdown("{{ route('wilayah.kabupaten', ':id') }}".replace(':id', response.data.id_prov),"#edit_data_id_kab", "id_kab", "nama", () =>{
                            $("#edit_data_id_kab").val(response.data.id_kab);
                            fetchDataDropdown("{{ route('wilayah.kecamatan', ':id') }}".replace(':id', response.data.id_kab), "#edit_data_id_kec", "id_kec", "nama", () =>{
                                $("#edit_data_id_kec").val(response.data.id_kec);
                                fetchDataDropdown("{{ route('wilayah.kelurahan', ':id') }}".replace(':id', response.data.id_kec),"#edit_data_id_kel", "id_kel", "nama", () =>{
                                    $("#edit_data_id_kel").val(response.data.id_kel);
                                });
                            });
                        });
                    });
                    const preview = '{{ route('foto', [':url']) }}'.replace(':url', response.data.foto);

                    $("#edit_data_preview").attr("src", preview); // Atur URL gambar
                } else {
                    Swal.fire('Oops...', 'Data tidak ditemukan', 'error');
                }
            },
            error: function() {
                Swal.close();
                Swal.fire('Oops...', 'Terjadi kesalahan pada server', 'error');
            }
        });

        $("#edit_data_id_prov").on("change", function() {
            const $id = $(this).find("option:selected").val();
            if ($id) {
                fetchDataDropdown("{{ route('wilayah.kabupaten', ':id') }}".replace(':id', $id),"#edit_data_id_kab", "id_kab", "nama");
            } else {
                resetDropdown("#edit_data_id_kab");
                resetDropdown("#edit_data_id_kec");
                resetDropdown("#edit_data_id_kel");
            }
        });

        // Ketika dropdown Kabupaten berubah
        $("#edit_data_id_kab").on("change", function() {
            const $id = $(this).find("option:selected").val();
            if ($id) {
                fetchDataDropdown("{{ route('wilayah.kecamatan', ':id') }}".replace(':id', $id), "#edit_data_id_kec", "id_kec", "nama");
            } else {
                resetDropdown("#edit_data_id_kec");
                resetDropdown("#edit_data_id_kel");
            }
        });

        // Ketika dropdown Kecamatan berubah
        $("#edit_data_id_kec").on("change", function() {
            const $id = $(this).find("option:selected").val();
            if ($id) {
                fetchDataDropdown("{{ route('wilayah.kelurahan', ':id') }}".replace(':id', $id),"#edit_data_id_kel", "id_kel", "nama");
            } else {
                resetDropdown("#edit_data_id_kel");
            }
        });

        // Ketika form edit disubmit
        $("#bt_submit_edit").on("submit", function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Apa kamu yakin?',
                text: "Apakah data Anda sudah benar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const updateUrl = '{{ route('employe.update', [':id']) }}'.replace(':id', id); // Ganti dengan ID dinamis
                    let formData = new FormData();
                    formData.append('nama', $("#edit_data_nama").val());
                    formData.append('telepon', $("#edit_data_telepon").val());
                    formData.append('id_job', $("#edit_data_id_job").val());
                    formData.append('alamat', $("#edit_data_alamat").val());
                    formData.append('id_prov', $("#edit_data_id_prov").val());
                    formData.append('id_kab', $("#edit_data_id_kab").val());
                    formData.append('id_kec', $("#edit_data_id_kec").val());
                    formData.append('id_kel', $("#edit_data_id_kel").val());
                    formData.append('foto', $("#edit_data_foto")[0].files[0]);
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('_method', 'PUT');

                    $.ajax({
                        url: updateUrl,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Menyimpan data...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: function(response) {
                            Swal.close(); // Tutup loading
                            if (response.success) {
                                Swal.fire('Berhasil!', 'Data berhasil diperbarui.', 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Gagal!', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            let code = xhr.status;
                            let response = xhr.responseJSON;
                            if (code === 422) {
                                Swal.close();
                                if (response && response.errors) {
                                    if (response.errors.nama) {
                                        $('#edit_data_namaError').text(response.errors.nama);
                                    }
                                    if (response.errors.alamat) {
                                        $('#edit_data_alamatError').text(response.errors.alamat);
                                    }
                                    if (response.errors.id_job) {
                                        $('#edit_data_id_jobError').text(response.errors.id_job);
                                    }
                                    if (response.errors.alamat) {
                                        $('#edit_data_alamatError').text(response.errors.alamat);
                                    }
                                    if (response.errors.id_prov) {
                                        $('#edit_data_id_provError').text(response.errors.id_prov);
                                    }
                                    if (response.errors.id_kab) {
                                        $('#edit_data_id_kabError').text(response.errors.id_kab);
                                    }
                                    if (response.errors.id_kec) {
                                        $('#edit_data_id_kecError').text(response.errors.id_kec);
                                    }
                                    if (response.errors.id_kel) {
                                        $('#edit_data_id_kelError').text(response.errors.id_kel);
                                    }
                                    if (response.errors.foto) {
                                        $('#edit_data_fotoError').text(response.errors.foto);
                                    }
                                }

                            } else if (code === 500) {
                                Swal.close();
                                Swal.fire('Oops...', 'Terjadi kesalahan pada server.', 'error');
                            }
                        }
                    });
                }
            });
        });

    });
</script>
