@extends('layouts.admin')

@section('title', 'Ketidakhadiran')

@section('content')
    <div>
        <div class="row mb-0">
            <div class="col-lg-9 col-xl-6">
                <h1 class="h3 mb-4 text-gray-800">{{ $pageTitle }}</h1>
            </div>
            <div class="col-lg-3 col-xl-6">
                <ul class="list-inline mb-0 float-end">
                    @if (Auth::user()->hasRole('admin'))
                        <li class="list-inline-item">
                            <a href="{{ route('ketidakhadirans.data') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Mengelola Ketidakhadiran
                            </a>
                        </li>
                    @endif
                    <li class="list-inline-item">
                        <a href="{{ route('ketidakhadirans.approve') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Menyetujui Ketidakhadiran
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="{{ route('ketidakhadirans.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Mengajukan Ketidakhadiran
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <hr>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Izin Ketidakhadiran Milik {{ Auth::user()->karyawan->nama }}
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable"
                        id="ketidakhadiranTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>No.</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Jenis Ketidakhadiran</th>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module">
        $(document).ready(function() {
            $("#ketidakhadiranTable").DataTable({
                serverSide: true,
                processing: true,
                // ajax: "/ketidakhadirans/getKetidakhadiranSelf",
                ajax: {
                    url: "/ketidakhadirans/getKetidakhadiranSelf",
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
                        data: "jenis_ketidakhadiran",
                        name: "jenis_ketidakhadiran"
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
                    // {
                    //     data: "approved_by.nama",
                    //     name: "approved_by.nama",
                    //     defaultContent: "-",
                    //     render: function(data, type, row) {
                    //         return data ? data : "-";
                    //     }
                    // },
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
        });
    </script>
@endpush
