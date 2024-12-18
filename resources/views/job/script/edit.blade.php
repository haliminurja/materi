<script defer>
    // Ketika modal edit ditampilkan
    $("#form_edit").on("show.bs.modal", function(e) {
        $("#bt_submit_edit")[0].reset(); // Reset form
        const button = $(e.relatedTarget); // Tombol yang memicu modal
        id = button.data("id"); // Ambil ID dari tombol
        const detailUrl = '{{ route('job.show', [':id']) }}'.replace(':id', id);
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
                    $("#edit_data_nama").val(response.data.nama); // Isi input dengan data nama job
                } else {
                    Swal.fire('Oops...', 'Data tidak ditemukan', 'error');
                }
            },
            error: function() {
                Swal.close();
                Swal.fire('Oops...', 'Terjadi kesalahan pada server', 'error');
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
                    const updateUrl = '{{ route('job.update', [':id']) }}'.replace(':id', id);
                    const input = {
                        nama: $("#edit_data_nama").val(),
                        _token: "{{ csrf_token() }}" // Tambahkan CSRF token
                    };

                    $.ajax({
                        url: updateUrl,
                        type: 'PUT',
                        data: input,
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
                                Swal.fire('Berhasil', 'Data berhasil diperbarui',
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
                                        $('#edit_data_namaError').text(response.errors.nama);
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
