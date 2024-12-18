@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/dataTables/dataTables.dataTables.min.css') }}">
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card border-primary shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Job </h3>
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#form_create">
                    Tambah
                </button>
            </div>

            <div class="card-body">
                <!-- Wrapper table dengan responsivitas -->
                <div class="table-responsive">
                    <!-- Tabel untuk menampilkan data -->
                    <table id="example" class="table table-striped table-bordered table-hover dt-responsive nowrap">
                        <thead class="table-light">
                            <th scope="col" class="text-center" style="width: 50px;">#</th>
                            <th scope="col" class="text-center" style="width: 200px;">Actions</th>
                            <th scope="col" class="text-start">Job</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('job.view.create')
    @include('job.view.edit')
@endsection

@section('javascript')
    <script src="{{ asset('assets/dataTables/dataTables.min.js') }}"></script>
    @include('job.script.list')
    @include('job.script.create')
    @include('job.script.edit')
    @include('job.script.destory')
@endsection
