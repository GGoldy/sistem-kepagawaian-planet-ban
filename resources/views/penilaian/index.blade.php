@extends('layouts.admin')

@section('title', 'Penilaian')

@section('content')
    <div>
        <div class="row mb-3 align-items-center">
            <div class="col-12 col-lg-6">
                <h1 class="h3 text-gray-800 mb-0">{{ $pageTitle }}</h1>
            </div>
            <div class="col-12 col-lg-6">
                <div class="d-flex justify-content-lg-end justify-content-start flex-wrap gap-2">
                    <a href="{{ route('penilaians.create') }}" class="btn btn-info text-white" title="Tambah penilaian baru">
                        <i class="bi bi-clipboard-plus me-1"></i> Tambah Penilaian
                    </a>
                    <a href="{{ route('penilaians.rekapexport.excel') }}" class="btn btn-success text-white" title="Export Rekap Penilaian">
                        <i class="bi bi-file-earmark-excel me-1"></i> Export Rekap
                    </a>
                </div>
            </div>
        </div>



        <hr>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Penilaian</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable"
                        id="penilaianTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>No.</th>
                                <th>Penilaian Karyawan</th>
                                <th>Dinilai Oleh</th>
                                <th>Penilaian Periode</th>
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
            $("#penilaianTable").DataTable({
                serverSide: true,
                processing: true,
                dom: 'Bfrtip',
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
                    {
                        text: 'Excel (All)',
                        className: 'btn btn-success',
                        action: function() {
                            window.location.href = "{{ route('penilaians.export.excel') }}";
                        }
                    }
                ],
                ajax: "/penilaians/getPenilaians",
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
                        data: "penilai.nama",
                        name: "penilai.nama"
                    },
                    {
                        data: null,
                        name: "tanggal_penilaian",
                        render: function(data, type, row) {
                            return row.bulan_penilaian + " " + row.tahun_penilaian;
                        }
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
                    title: "Are you sure you want to delete this data ?",
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
