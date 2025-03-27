@extends('layouts.admin')

@section('title', 'Form Ketidakhadiran')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center my-4">{{ $pageTitle }}</h1>
            <div class="card">
                <div class="card-header bg-primary text-white">Detail Ketidakhadiran</div>
                <div class="card-body">
                    <form action="{{ route('ketidakhadirans.signApproval', ['id' => $ketidakhadiran->id]) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label>Nama Karyawan:</label>
                            <input type="text" class="form-control" value="{{ $ketidakhadiran->karyawan->nama }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Jenis Ketidakhadiran:</label>
                            <input type="text" class="form-control" value="{{ $ketidakhadiran->jenis_ketidakhadiran }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Mulai:</label>
                            <input type="date" class="form-control" value="{{ $ketidakhadiran->tanggal_mulai }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Berakhir:</label>
                            <input type="date" class="form-control" value="{{ $ketidakhadiran->tanggal_berakhir }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Tujuan:</label>
                            <textarea class="form-control" readonly>{{ $ketidakhadiran->tujuan }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Catatan:</label>
                            <textarea class="form-control" readonly>{{ $ketidakhadiran->catatan }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Status Pengajuan:</label>
                            <input type="text" class="form-control"
                                value="{{ $ketidakhadiran->status_pengajuan ? 'Disetujui' : 'Pending' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="approved_by">Disetujui Oleh</label>
                            <input type="text" class="form-control"
                                value="{{ optional($ketidakhadiran->approved_by)->nama ?? 'Belum Disetujui' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="approved_by_hcm">Disetujui Oleh HCM</label>
                            <input type="text" class="form-control"
                                value="{{ optional($ketidakhadiran->approved_by_hcm)->nama ?? 'Belum Disetujui' }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pengajuan:</label>
                            <input type="datetime-local" class="form-control"
                                value="{{ $ketidakhadiran->tanggal_pengajuan }}" readonly>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-6 d-grid">
                                <a href="{{ route('ketidakhadirans.approve') }}" class="btn btn-outline-dark btn-lg mt-3"><i
                                        class="bi-arrow-left-circle me-2"></i>
                                    Batal</a>
                            </div>
                            <div class="col-md-6 d-grid">
                                <button type="submit" class="btn btn-dark btn-lg mt-3"><i class="bi-check-circle me-2"></i>
                                    Setuju</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
