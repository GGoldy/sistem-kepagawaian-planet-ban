@extends('layouts.admin')

@section('title', 'Form Penilaian')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center my-4">{{ $pageTitle }}</h1>
            <x-breadcrumb :links="[
                            'Penilaian' => route('penilaians.index'),
                            'Show' => '#',
                        ]" />
            <div class="card">
                <div class="card-header bg-primary text-white">Detail Penilaian</div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label>Nama Karyawan:</label>
                            <input type="text" class="form-control" value="{{ $penilaian->karyawan->nama }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama Penilai:</label>
                            <input type="text" class="form-control" value="{{ $penilaian->penilai->nama }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Penilaian Untuk Periode:</label>
                            <input type="text" class="form-control" value="{{ $penilaian->bulan_penilaian }} {{ $penilaian->tahun_penilaian }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Kinerja:</label>
                            <input type="text" class="form-control" value="{{ $penilaian->kinerja }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Kehadiran:</label>
                            <input type="text" class="form-control" value="{{ $penilaian->kehadiran }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Kerjasama Tim:</label>
                            <input type="text" class="form-control" value="{{ $penilaian->kerjasama_tim ?? '-' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Penilaian:</label>
                            <input type="text" class="form-control" value="{{ $penilaian->created_at ?? '-' }}" readonly>
                        </div>
                        {{-- <div class="form-group">
                            <label>Nama Karyawan:</label>
                            <input type="text" class="form-control" value="{{ $lembur->karyawan->nama }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Perintah Atasan:</label>
                            <input type="text" class="form-control"
                                value="{{ optional($lembur->perintahatasan)->nama ?? '---' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Mulai:</label>
                            <input type="date" class="form-control" value="{{ $lembur->tanggal_mulai }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Berakhir:</label>
                            <input type="date" class="form-control" value="{{ $lembur->tanggal_berakhir }}" readonly>
                        </div>

                        <div class="form-group">
                            <label>Total Jam Lembur:</label>
                            <input type="number" class="form-control"
                                value="{{ is_array($jamLembur = json_decode($lembur->jam_lembur, true)) ? array_sum($jamLembur) : 0 }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Tugas Lembur:</label>
                            <textarea class="form-control" readonly>{{ $lembur->tugas }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Status Pengajuan:</label>
                            <input type="text" class="form-control"
                                value="{{ $lembur->status_pengajuan ? 'Disetujui' : 'Pending' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="approved_by">Disetujui Oleh</label>
                            <input type="text" class="form-control"
                                value="{{ optional($lembur->approvedBy)->nama ?? 'Belum Disetujui' }}" readonly>

                        </div>

                        <div class="form-group">
                            <label for="approved_by_hcm">Disetujui Oleh HCM</label>
                            <input type="text" class="form-control"
                                value="{{ optional($lembur->approvedByHcm)->nama ?? 'Belum Disetujui' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pengajuan:</label>
                            <input type="datetime-local" class="form-control" value="{{ $lembur->tanggal_pengajuan }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Sah:</label>
                            <input type="{{ $lembur->tanggal_sah ? 'datetime-local' : 'text' }}"
                                   class="form-control"
                                   value="{{ $lembur->tanggal_sah ?? '-----' }}"
                                   readonly>
                        </div>--}}
                    </form>
                </div>
            </div>

            <x-back-button />


        </div>
    </div>
@endsection
