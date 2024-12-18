<script defer>
    $("#form_create").on("show.bs.modal", function() {
        $('#bt_submit_create')[0].reset();
        fetchDataDropdown("{{ route('job.job') }}","#id_job", "id_job", "nama");

        fetchDataDropdown("{{ route('wilayah.provinsi') }}","#id_prov", "id_prov", "nama");

        $("#id_prov").on("change", function() {
            const $id = $(this).find("option:selected").val();
            if ($id) {
                fetchDataDropdown("{{ route('wilayah.kabupaten', ':id') }}".replace(':id', $id),"#id_kab", "id_kab", "nama");
            } else {
                resetDropdown("#id_kab");
                resetDropdown("#id_kec");
                resetDropdown("#id_kel");
            }
        });

        // Ketika dropdown Kabupaten berubah
        $("#id_kab").on("change", function() {
            const $id = $(this).find("option:selected").val();
            if ($id) {
                fetchDataDropdown("{{ route('wilayah.kecamatan', ':id') }}".replace(':id', $id), "#id_kec", "id_kec", "nama");
            } else {
                resetDropdown("#id_kec");
                resetDropdown("#id_kel");
            }
        });

        // Ketika dropdown Kecamatan berubah
        $("#id_kec").on("change", function() {
            const $id = $(this).find("option:selected").val();
            if ($id) {
                fetchDataDropdown("{{ route('wilayah.kelurahan', ':id') }}".replace(':id', $id),"#id_kel", "id_kel", "nama");
            } else {
                resetDropdown("#id_kel");
            }
        });

        $('#bt_submit_create').on('submit', function(e) {
            e.preventDefault(); // Mencegah form refresh halaman
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Apakah data sudah benar dan sesuai keinginan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData();
                    formData.append('nama', $("#nama").val());
                    formData.append('telepon', $("#telepon").val());
                    formData.append('id_job', $("#id_job").val());
                    formData.append('alamat', $("#alamat").val());
                    formData.append('id_prov', $("#id_prov").val());
                    formData.append('id_kab', $("#id_kab").val());
                    formData.append('id_kec', $("#id_kec").val());
                    formData.append('id_kel', $("#id_kel").val());
                    formData.append('foto', $("#foto")[0].files[0]);
                    formData.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        url: '{{ route('employe.store') }}', // Sesuaikan dengan route penyimpanan data
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
                            Swal.close();
                            if (response.success) {
                                Swal.fire('Berhasil', 'Data berhasil disimpan',
                                    'success');
                                setTimeout(() => location.reload(), 2000);
                            } else {
                                Swal.fire('Gagal', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            let code = xhr.status;
                            let response = xhr.responseJSON;
                            if (code === 422) {
                                Swal.close();
                                if (response && response.errors) {
                                    if (response.errors.nama) {
                                        $('#namaError').text(response.errors.nama);
                                    }
                                    if (response.errors.alamat) {
                                        $('#alamatError').text(response.errors.alamat);
                                    }
                                    if (response.errors.id_job) {
                                        $('#id_jobError').text(response.errors.id_job);
                                    }
                                    if (response.errors.alamat) {
                                        $('#alamatError').text(response.errors.alamat);
                                    }
                                    if (response.errors.id_prov) {
                                        $('#id_provError').text(response.errors.id_prov);
                                    }
                                    if (response.errors.id_kab) {
                                        $('#id_kabError').text(response.errors.id_kab);
                                    }
                                    if (response.errors.id_kec) {
                                        $('#id_kecError').text(response.errors.id_kec);
                                    }
                                    if (response.errors.id_kel) {
                                        $('#id_kelError').text(response.errors.id_kel);
                                    }
                                    if (response.errors.foto) {
                                        $('#fotoError').text(response.errors.foto);
                                    }
                                }
                            } else if (code === 500) {
                                Swal.close();
                                Swal.fire('Oops...','Terjadi kesalahan pada server', 'error');
                            }
                        }
                    });
                }
            });
        });
    });
</script>
