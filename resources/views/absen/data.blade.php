@extends('layouts.admin')

@section('title', 'Absen Data')

@section('content')
    <div>
        <div class="row mb-0">
            <div class="col-lg-9 col-xl-6">
                <h1 class="h3 mb-4 text-gray-800">{{ $pageTitle }}</h1>
                <x-breadcrumb :links="[
                    'Absen' => route('absens.index'),
                    'Data' => '#',
                ]" />
            </div>

            <div class="col-lg-3 col-xl-6 text-right">
                <form action="{{ route('absens.export.excel') }}" method="GET" class="form-inline justify-content-end">
                    <select name="month" class="form-control mr-2">
                        @foreach (range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $m == now()->month ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                            </option>
                        @endforeach
                    </select>

                    <select name="year" class="form-control mr-2">
                        @for ($y = now()->year; $y >= now()->year - 5; $y--)
                            <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>

                    <button type="submit" class="btn btn-primary">Export Rekap</button>
                </form>
            </div>
        </div>
        <hr>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Absen</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable" id="absenTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Absen/Pulang</th>
                                <th>Waktu</th>
                                <th>Lokasi</th>
                                {{-- <th>Latitude</th>
                                <th>Longitude</th> --}}
                                <th></th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>

        <div class="pb-5">
            <a href="{{ route('absens.index') }}" class="btn btn-dark btn-lg w-100">
                <i class="bi bi-arrow-left me-1"></i> {{ $text ?? 'Kembali' }}
            </a>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $("#absenTable").DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                dom: 'Blfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6]
                        }
                    },
                ],
                ajax: "/absens/getAbsens",
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
                        data: "absen_pulang",
                        name: "absen_pulang",
                        render: function(data, type, row) {
                            return data == 1 ? "Absen" : "Pulang";
                        }
                    },
                    {
                        data: "waktu",
                        name: "waktu"
                    },
                    {
                        data: "lokasi_kerja.nama",
                        name: "lokasi_kerja.nama"
                    },
                    // {
                    //     data: "latitude",
                    //     name: "latitude"
                    // },
                    // {
                    //     data: "longitude",
                    //     name: "longitude"
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

            $('#absenTable').on('init.dt', function() {
                $('.dt-buttons').addClass('mb-3'); // margin-bottom
            });
        });
    </script>
@endpush
