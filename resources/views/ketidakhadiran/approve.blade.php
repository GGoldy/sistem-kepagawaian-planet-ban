@extends('layouts.admin')

@section('title', 'Penyetujuan Ketidakhadiran')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-11">
            <h1 class="text-center my-3">{{ $pageTitle }}</h1>
            <div class="row no-gutters justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <div class="card shadow-sm">
                        <div class="card-header py-2">
                            <h6 class="m-0 font-weight-bold text-primary">Izin Ketidakhadiran</h6>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable"
                                    id="ketidakhadiranTable1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>No.</th>
                                            <th>Nama Karyawan</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Jenis Ketidakhadiran</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->hasRole('admin'))
                    <div class="col-lg-6 pl-2">
                        <div class="card shadow-sm">
                            <div class="card-header py-2">
                                <h6 class="m-0 font-weight-bold text-primary">Izin Ketidakhadiran (Table 2)</h6>
                            </div>
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable"
                                        id="ketidakhadiranTable2">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>No.</th>
                                                <th>Nama Karyawan</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th>Jenis Ketidakhadiran</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#ketidakhadiranTable1").DataTable({
                serverSide: true,
                processing: true,
                ajax: "/ketidakhadirans/getKetidakhadiranFiltered",
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
                        data: 'karyawan.nama',
                        title: 'Nama Karyawan',
                        defaultContent: 'N/A'
                    }, {
                        data: 'tanggal_pengajuan',
                        title: 'Tanggal Pengajuan'
                    },
                    {
                        data: 'jenis_ketidakhadiran',
                        title: 'Jenis Ketidakhadiran'
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

            $("#ketidakhadiranTable2").DataTable({
                serverSide: true,
                processing: true,
                ajax: "/ketidakhadirans/getKetidakhadiranAllFiltered",
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
                        data: 'karyawan.nama',
                        title: 'Nama Karyawan',
                        defaultContent: 'N/A'
                    }, {
                        data: 'tanggal_pengajuan',
                        title: 'Tanggal Pengajuan'
                    },
                    {
                        data: 'jenis_ketidakhadiran',
                        title: 'Jenis Ketidakhadiran'
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

            $('.datatable').on("click", '.btn-approve', function(e) {
                e.preventDefault();

                var form = $(this).closest("form");
                var name = $(this).data('name');

                Swal.fire({
                    title: "Apakah yakin akan menyetujui ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'bg-primary',
                    confirmButtonText: "Confirm",
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            })


        });
        document.addEventListener("DOMContentLoaded", function() {
            let ketidakhadirans = @json($ketidakhadirans); // Convert PHP to JSON
            let all = @json($all);
            console.log("Filtered Ketidakhadiran with lower level:", ketidakhadirans);
            console.log("All Ketidakhadiran", all);

        });
    </script>
@endpush
