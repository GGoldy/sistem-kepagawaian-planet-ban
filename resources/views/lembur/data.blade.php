@extends('layouts.admin')

@section('title', 'Lembur')

@section('content')
    <div>
        <div class="row mb-0">
            <div class="col-lg-9 col-xl-6">
                <h1 class="h3 mb-4 text-gray-800">{{ $pageTitle }}</h1>
            </div>
            <div class="col-lg-3 col-xl-6">
                <ul class="list-inline mb-0 float-end">
                    <li class="list-inline-item">
                        <a href="{{ route('lemburs.approve') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Menyetujui Lembur
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <hr>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Form Lembur</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable" id="lemburTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>No.</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Karyawan</th>
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
                serverSide: true,
                processing: true,
                ajax: {
                    url: "/lemburs/getLemburAll",
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
                        data: "karyawan.nama",
                        name: "karyawan.nama"
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
