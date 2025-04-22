@extends('layouts.admin')

@section('title', 'User')

@section('content')
    <div>
        <div class="row mb-3 align-items-center">
            <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                <h1 class="h3 text-gray-800">{{ $pageTitle }}</h1>
                <x-breadcrumb :links="[
                    'User' => '#',
                ]" />
            </div>
            <div class="col-12 col-lg-6">
                <div class="d-flex flex-wrap justify-content-lg-end gap-2">
                    <a href="{{ route('users.create') }}" class="btn btn-info text-white" title="Tambah pengguna baru">
                        <i class="bi bi-person-plus me-1"></i> Tambah Pengguna
                    </a>
                </div>
            </div>
        </div>


        <hr>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Pengguna</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable" id="userTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>No.</th>
                                <th>NIK</th>
                                <th>Nama Pengguna</th>
                                <th>Peran</th>
                                <th></th>
                            </tr>
                        </thead>
                        {{-- <tbody>
                        @foreach ($karyawans as $karyawan)
                            <tr>
                                <td>{{ $karyawan->id }}</td>
                                <td>{{ $karyawan->nama }}</td>
                                <td>{{ $karyawan->nik }}</td>
                                <td>{{ $karyawan->jabatan }}</td>
                                <td>{{ $karyawan->jenis_kelamin }}</td>
                                <td>{{ $karyawan->email }}</td>
                                <td>

                                    <div class="d-flex">
                                        <a href="{{ route('karyawans.show', ['karyawan' => $karyawan->id]) }}"
                                            class="btn btn-outline-dark btn-sm me-2"><i class="fas fa-fw fa-book"></i></a>
                                        <a href="{{ route('karyawans.edit', ['karyawan' => $karyawan->id]) }}"
                                            class="btn btn-outline-dark btn-sm me-2"><i class="fas fa-fw fa-pencil-alt"></i></a>
                                        <div>
                                            <form action="{{ route('karyawans.destroy', ['karyawan' => $karyawan->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-outline-dark btn-sm me-2"><i class="fas fa-fw fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody> --}}
                    </table>
                </div>
            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $("#userTable").DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                dom: 'Blfrtip',
                buttons: [{
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
                            window.location.href = "{{ route('users.export.excel') }}";
                        }
                    }
                ],
                ajax: "/users/getUsers",
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
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "karyawan.nama",
                        name: "karyawan.nama"
                    },
                    {
                        data: "roles",
                        name: "roles",
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
                    title: "Are you sure you want to delete\n" + name + "?",
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

            $('#userTable').on('init.dt', function() {
                $('.dt-buttons').addClass('mb-3'); // margin-bottom
            });
        });
    </script>
@endpush
