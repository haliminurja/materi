@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/dataTables/dataTables.dataTables.min.css') }}">
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card border-primary shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Employe</h3>
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#form_create">
                    Tambah Employe
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered table-hover dt-responsive nowrap">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th class="text-center" style="width: 200px;">Actions</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Job</th>
                                <th>Kelurahan</th>
                                <th>Kecamatan</th>
                                <th>Kabupaten</th>
                                <th>Provinsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('employe.view.create')
    @include('employe.view.edit')
@endsection

@section('javascript')
    <script src="{{ asset('assets/dataTables/dataTables.min.js') }}"></script>
    <script>
        function fetchDataDropdown(url, id, key, name, callback) {
            // Kirim request AJAX ke URL yang diberikan
            $.ajax({
                url: url,
                method: "GET",
                dataType: "json",
                beforeSend: function () {
                    $(id).html('<option value="" disabled selected>Loading...</option>');
                },
                success: function(response) {
                    let options = '<option value="" disabled selected>Pilih</option>';
                    $.each(response.data, function (index, item) {
                        options += `<option value="${item[key]}">${item[name]}</option>`;
                    });
                    $(id).html(options).prop('disabled', false);

                    if (callback) {
                        callback();
                    }
                },
                error: function() {
                    $(id).html('<option value="" disabled selected>Pilih</option>').prop('disabled', true);
                }
            });
        }
        function resetDropdown(id) {
            $(id).html('<option value="" disabled selected>Pilih</option>').prop('disabled', true);
        }
    </script>
    @include('employe.script.list')
    @include('employe.script.create')
    @include('employe.script.edit')
    @include('employe.script.destory')
@endsection
