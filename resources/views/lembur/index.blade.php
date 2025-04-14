@extends('layouts.admin')

@section('title', 'Lembur')

@section('content')
    <div>
        <div class="row mb-3 align-items-start">
            <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                <div class="d-flex flex-column justify-content-center h-100">
                    <h1 class="h3 text-gray-800 mb-2">{{ $pageTitle }}</h1>
                    <div class="mt-n1">
                        <x-breadcrumb :links="[
                            'Lembur' => '#',
                        ]" />
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="d-flex flex-wrap justify-content-lg-end gap-2 align-items-start">
                    @if (Auth::user()->hasRole('admin'))
                        <a href="{{ route('lemburs.data') }}" class="btn btn-dark" title="Kelola semua data lembur">
                            <i class="bi bi-folder2-open me-1"></i> Mengelola Lembur
                        </a>
                    @endif

                    <a href="{{ route('lemburs.approve') }}" class="btn btn-success" title="Setujui pengajuan lembur">
                        <i class="bi bi-check2-circle me-1"></i> Menyetujui Lembur
                    </a>

                    <a href="{{ route('lemburs.create') }}" class="btn btn-warning text-dark" title="Ajukan lembur baru">
                        <i class="bi bi-pencil-square me-1"></i> Mengajukan Lembur
                    </a>
                </div>
            </div>
        </div>


        <hr>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Lembur Milik {{ Auth::user()->karyawan->nama }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable" id="lemburTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>No.</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Atasan</th>
                                <th>Tugas</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Berakhir</th>
                                <th>Status Pengajuan</th>
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
    <script type="module">
        $(document).ready(function() {
            $("#lemburTable").DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                dom: 'Blfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                    {
                        text: 'Excel (All)',
                        className: 'btn btn-success',
                        action: function() {
                            window.location.href = "{{ route('lemburs.selfexport.excel') }}";
                        }
                    }
                ],
                ajax: {
                    url: "/lemburs/getLemburSelf",
                    data: function(d) {
                        d.karyawan_id = {{ auth()->user()->karyawan_id }};
                    }
                },
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
                        data: "tanggal_pengajuan",
                        name: "tanggal_pengajuan"
                    },
                    {
                        data: "perintahatasan.nama",
                        name: "perintahatasan.nama"
                    },
                    {
                        data: "tugas",
                        name: "tugas"
                    },
                    {
                        data: "tanggal_mulai",
                        name: "tanggal_mulai"
                    },
                    {
                        data: "tanggal_berakhir",
                        name: "tanggal_berakhir"
                    },
                    {
                        data: "status_pengajuan",
                        name: "status_pengajuan",
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
            $('#lemburTable').on('init.dt', function() {
                $('.dt-buttons').addClass('mb-3'); // margin-bottom
            });
        });
    </script>
@endpush
