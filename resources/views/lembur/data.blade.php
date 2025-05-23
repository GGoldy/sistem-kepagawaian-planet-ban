@extends('layouts.admin')

@section('title', 'Lembur')

@section('content')
    <div>
        <div class="mb-3">
            <!-- Title -->
            <h1 class="h3 text-gray-800 mb-2">{{ $pageTitle }}</h1>

            <!-- Breadcrumbs full width -->
            <div class="mb-3">
                <x-breadcrumb :links="[
                    'Lembur' => route('lemburs.index'),
                    'Data' => '#',
                ]" />
            </div>

            <!-- Button floated right -->
            <div class="d-flex justify-content-end">
                <a href="{{ route('lemburs.approve') }}" class="btn btn-success" title="Setujui pengajuan lembur">
                    <i class="bi bi-check2-circle me-1"></i> Menyetujui Lembur
                </a>
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

        <div class="pb-5">
            <a href="{{ route('lemburs.index') }}" class="btn btn-outline-dark btn-lg w-100">
                <i class="bi bi-arrow-left me-1"></i> {{ $text ?? 'Kembali' }}
            </a>
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
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    },
                    {
                        text: 'Excel (All)',
                        className: 'btn btn-success',
                        action: function() {
                            window.location.href = "{{ route('lemburs.export.excel') }}";
                        }
                    }
                ],
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

            $('#lemburTable').on('init.dt', function() {
                $('.dt-buttons').addClass('mb-3'); // margin-bottom
            });
        });
    </script>
@endpush
