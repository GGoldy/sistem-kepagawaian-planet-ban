@extends('layouts.admin')

@section('title', 'Data Lokasi Kerja')

@section('content')
<div>
    <div class="row mb-3 align-items-start">
        <div class="col-12 col-lg-6 mb-3 mb-lg-0">
            <div class="d-flex flex-column justify-content-center h-100">
                <h1 class="h3 text-gray-800 mb-2">{{ $pageTitle }}</h1>
                <div class="mt-n1">
                    <x-breadcrumb :links="[
                        'Absen' => route('absens.index'),
                        'Lokasi Kerja' => '#',
                    ]" />
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="d-flex flex-wrap justify-content-lg-end gap-2 align-items-start">
                <a href="{{ route('lokasikerjas.create') }}" class="btn btn-dark" title="Tambah lokasi kerja baru">
                    <i class="bi bi-geo-alt me-1"></i> Create Lokasi Kerja
                </a>
            </div>
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

    <x-back-button url="{{ route('absens.index') }}"/>
</div>
@endsection
@push('scripts')

    <script type="module">
        $(document).ready(function() {
            $("#lokasiKerjaTable").DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                ],
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

            $('#lokasiKerjaTable').on('init.dt', function() {
                $('.dt-buttons').addClass('mb-3'); // margin-bottom
            });
        });
    </script>
@endpush
