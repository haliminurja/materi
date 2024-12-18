<script defer>
    $("#form_create").on("show.bs.modal", function() {
        $("#bt_submit_create")[0].reset();
        $("#error-list").empty(); // Kosongkan daftar error

        // Proses submit form dengan AJAX
        $("#bt_submit_create").on("submit", function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Apakah data sudah benar dan sesuai keinginan?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const action = "{{ route('job.store') }}";
                    const input = {
                        nama: $("#nama").val(),
                        _token: "{{ csrf_token() }}"
                    };

                    $.ajax({
                        url: action,
                        type: 'POST',
                        data: input,
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Sedang menyimpan...',
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
