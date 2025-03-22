@extends('layouts.admin')

@section('title', 'Detail Karyawan')

@section('content')
    <div>
        <h1 class="text-center my-4">{{ $pageTitle }}</h1>

        <div class="row">
            <!-- Karyawan Card -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Karyawan Details</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Nama:</strong> {{ $karyawan->nama }}</p>
                        <p><strong>NIK:</strong> {{ $karyawan->nik }}</p>
                        <p><strong>Jabatan:</strong> {{ $karyawan->jabatan }}</p>
                    </div>
                </div>
            </div>

            <!-- Status Pegawai Card -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Status Pegawai</h6>
                    </div>
                    <div class="card-body">
                        @if ($karyawan->statuspegawai)
                            <p><strong>Status:</strong> {{ $karyawan->statuspegawai->status_kerja }}</p>
                            <p><strong>Mulai Kerja:</strong> {{ $karyawan->statuspegawai->mulai_kerja }} </p>
                        @else
                            <p>Status Pegawai tidak tersedia</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Penugasan Card -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">Penugasan</h6>
                    </div>
                    <div class="card-body">
                        @if ($karyawan->penugasan)
                            <p><strong>Perusahaan:</strong> {{ $karyawan->penugasan->perusahaan }}</p>
                            <p><strong>Area:</strong> {{ $karyawan->penugasan->area }}</p>
                        @else
                            <p>Tidak ada penugasan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
