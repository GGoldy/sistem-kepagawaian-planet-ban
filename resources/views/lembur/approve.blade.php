@extends('layouts.admin')

@section('title', 'Penyetujuan Lembur')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-11">
            <h1 class="text-center my-3">{{ $pageTitle }}</h1>
            <x-breadcrumb :links="[
                            'Lembur' => route('lemburs.index'),
                            'Approve' => '#',
                        ]" />
            <div class="row no-gutters justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <div class="card shadow-sm">
                        <div class="card-header py-2">
                            <h6 class="m-0 font-weight-bold text-primary">Izin Lembur</h6>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable"
                                    id="lemburTable1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>No.</th>
                                            <th>Nama Karyawan</th>
                                            <th>Perintah Atasan</th>
                                            <th>Tanggal Pengajuan</th>
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
                                <h6 class="m-0 font-weight-bold text-primary">Izin Ketidakhadiran (Khusus HCM)</h6>
                            </div>
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable"
                                        id="lemburTable2">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>No.</th>
                                            <th>Nama Karyawan</th>
                                            <th>Perintah Atasan</th>
                                            <th>Tanggal Pengajuan</th>
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

            <div class="pb-5">
                <a href="{{ route('lemburs.index') }}" class="btn btn-dark btn-lg w-100">
                    <i class="bi bi-arrow-left me-1"></i> {{ $text ?? 'Kembali' }}
                </a>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script defer>
        $(document).ready(function() {
            $("#lemburTable1").DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: "/lemburs/getLemburFiltered",
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
                        data: 'perintahatasan.nama',
                        title: 'Perintah Atasan',
                        defaultContent: 'N/A'
                    }, {
                        data: 'tanggal_pengajuan',
                        title: 'Tanggal Pengajuan'
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

            $("#lemburTable2").DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: "/lemburs/getLemburAllFiltered",
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
                        data: 'perintahatasan.nama',
                        title: 'Perintah Atasan',
                        defaultContent: 'N/A'
                    }, {
                        data: 'tanggal_pengajuan',
                        title: 'Tanggal Pengajuan'
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


        });
    </script>
@endpush
