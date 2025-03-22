@extends('layouts.admin')

@section('title', 'Data Lokasi Kerja')

@section('content')
<div>
    <div class="row mb-0">
        <div class="col-lg-9 col-xl-6">
            <h1 class="h3 mb-4 text-gray-800">{{ $pageTitle }}</h1>
        </div>
        <div class="col-lg-3 col-xl-6">
            <ul class="list-inline mb-0 float-end">
                <li class="list-inline-item">
                    <a href="{{ route('lokasikerjas.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Create Lokasi Kerja
                    </a>
                </li>
            </ul>
        </div>

    </div>
    <hr>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Lokasi Kerja</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable" id="lokasiKerjaTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module">
        $(document).ready(function() {
            $("#lokasiKerjaTable").DataTable({
                serverSide: true,
                processing: true,
                ajax: "/getLokasiKerjas",
                columns: [{
                        data: "id",
                        name: "id",
                        visible: false
                    },
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "nama",
                        name: "nama"
                    },
                    {
                        data: "latitude",
                        name: "latitude"
                    },
                    {
                        data: "longitude",
                        name: "longitude"
                    },
                    {
                        data: "actions",
                        name: "actions",
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [0, "desc"]
                ],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"],
                ],
            });

            $('.datatable').on("click", '.btn-delete', function(e) {
                e.preventDefault();

                var form = $(this).closest("form");
                var name = $(this).data('name');

                Swal.fire({
                    title: "Are you sure you want to delete this ?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'bg-primary',
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            })
        });
    </script>
@endpush
