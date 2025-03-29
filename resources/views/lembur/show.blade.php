@extends('layouts.admin')

@section('title', 'Form Lembur')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center my-4">{{ $pageTitle }}</h1>
            <div class="card">
                <div class="card-header bg-primary text-white">Detail Lembur</div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
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
                        {{-- <div class="form-group">
                            <label>Total Jam Lembur:</label>
                            <input type="number" class="form-control"
                                value="{{ collect(json_decode($lembur->jam_lembur, true) ?? [])->sum() }}" readonly>
                        </div> --}}
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
