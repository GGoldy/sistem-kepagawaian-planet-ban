@extends('layouts.admin')

@section('title', 'Data Ketidakhadiran')

@section('content')
    <div>
        <div class="mb-3">
            <!-- Title -->
            <h1 class="h3 text-gray-800 mb-2">{{ $pageTitle }}</h1>

            <!-- Breadcrumbs full width -->
            <div class="mb-3">
                <x-breadcrumb :links="[
                    'Ketidakhadiran' => route('ketidakhadirans.index'),
                    'Data' => '#'
                ]" />
            </div>

            <!-- Button floated right -->
            <div class="d-flex justify-content-end">
                <a href="{{ route('ketidakhadirans.approve') }}" class="btn btn-success"
                    title="Setujui permintaan ketidakhadiran">
                    <i class="bi bi-check2-circle me-1"></i> Menyetujui Ketidakhadiran
                </a>
            </div>
        </div>


        <hr>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Izin Ketidakhadiran</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable"
                        id="ketidakhadiranTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>No.</th>
                                <th>Nama</th>
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

        <div class="pb-5">
            <a href="{{ route('ketidakhadirans.index') }}" class="btn btn-dark btn-lg w-100">
                <i class="bi bi-arrow-left me-1"></i> {{ $text ?? 'Kembali' }}
            </a>
        </div>
    </div>

@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module">
        $(document).ready(function() {
            $("#ketidakhadiranTable").DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                // ajax: "/ketidakhadirans/getKetidakhadiranSelf",
                dom: 'Blfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8] // exclude index 0 (id)
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
                            window.location.href = "{{ route('ketidakhadirans.export.excel') }}";
                        }
                    }
                ],
                ajax: {
                    url: "/ketidakhadirans/getKetidakhadiranAll",
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
                        data: "karyawan.nama",
                        name: "karyawan.nama"
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
                        name: "status_pengajuan"
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

            $('#ketidakhadiranTable').on('init.dt', function() {
                $('.dt-buttons').addClass('mb-3'); // margin-bottom
            });
        });
    </script>
@endpush
