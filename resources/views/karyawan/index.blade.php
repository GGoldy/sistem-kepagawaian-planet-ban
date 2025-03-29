@extends('layouts.admin')

@section('title', 'Karyawan')

@section('content')
    <div>
        <div class="row mb-0">
            <div class="col-lg-9 col-xl-6">
                <h1 class="h3 mb-4 text-gray-800">{{ $pageTitle }}</h1>
            </div>
            <div class="col-lg-3 col-xl-6">
                <ul class="list-inline mb-0 float-end">
                    <li class="list-inline-item">
                        <a href="{{ route('karyawans.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Karyawan
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <hr>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Karyawan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable" id="karyawanTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Jabatan</th>
                                <th>Jenis Kelamin</th>
                                <th>Email</th>
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
            $("#karyawanTable").DataTable({
                serverSide: true,
                processing: true,
                ajax: "/karyawans/getKaryawans",
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
                        data: "nama",
                        name: "nama"
                    },
                    {
                        data: "nik",
                        name: "nik"
                    },
                    {
                        data: "jabatan",
                        name: "jabatan"
                    },
                    {
                        data: "jenis_kelamin",
                        name: "jenis_kelamin"
                    },
                    {
                        data: "email",
                        name: "email"
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

            $('.datatable').on("click", '.btn-delete', function(e){
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
        });
    </script>
@endpush
