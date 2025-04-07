@extends('layouts.admin')

@section('title', 'Form Penilaian')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center my-4">{{ $pageTitle }}</h1>
            <div class="card">
                <div class="card-header bg-primary text-white">Detail Penilaian</div>
                <div class="card-body">
                    <form action="{{ route('penilaians.update', ['penilaian' => $penilaian->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label>Nama Karyawan:</label>
                            <input type="text" class="form-control" value="{{ $penilaian->karyawan->nama }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama Penilai:</label>
                            <input type="text" class="form-control" value="{{ $penilaian->penilai->nama }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="bulan_penilaian" class="form-label">Bulan Penilaian</label>
                            <select class="form-select @error('bulan_penilaian') is-invalid @enderror"
                                name="bulan_penilaian" id="bulan_penilaian">
                                @php
                                    $selectedBulanPenilaian = old('bulan_penilaian', $penilaian->bulan_penilaian ?? '');
                                    $months = [
                                        'Januari',
                                        'Februari',
                                        'Maret',
                                        'April',
                                        'Mei',
                                        'Juni',
                                        'Juli',
                                        'Agustus',
                                        'September',
                                        'Oktober',
                                        'November',
                                        'Desember',
                                    ];
                                @endphp
                                @foreach ($months as $month)
                                    <option value="{{ $month }}"
                                        {{ $selectedBulanPenilaian == $month ? 'selected' : '' }}>
                                        {{ $month }}
                                    </option>
                                @endforeach
                            </select>

                            @error('bulan_penilaian')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tahun_penilaian" class="form-label">Tahun Penilaian</label>
                            <input class="form-control @error('tahun_penilaian') is-invalid @enderror" type="text"
                                name="tahun_penilaian" id="tahun_penilaian"
                                value="{{ $errors->any() ? old('tahun_penilaian') : $penilaian->tahun_penilaian }}">
                            @error('tahun_penilaian')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kinerja" class="form-label">Kinerja</label>
                            <select class="form-select @error('kinerja') is-invalid @enderror" name="kinerja"
                                id="kinerja">
                                @php
                                    $selectedKinerja = old('kinerja', $penilaian->kinerja);
                                @endphp
                                <option value="" {{ $selectedKinerja == '' ? 'selected' : '' }}>Select Nilai Kinerja
                                </option>
                                <option value="A" {{ $selectedKinerja == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ $selectedKinerja == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ $selectedKinerja == 'C' ? 'selected' : '' }}>C</option>
                                <option value="D" {{ $selectedKinerja == 'D' ? 'selected' : '' }}>D</option>
                                <option value="E" {{ $selectedKinerja == 'E' ? 'selected' : '' }}>E</option>
                            </select>
                            @error('kinerja')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kehadiran" class="form-label">Kehadiran</label>
                            <select class="form-select @error('kehadiran') is-invalid @enderror" name="kehadiran"
                                id="kehadiran">
                                @php
                                    $selectedKehadiran = old('kehadiran', $penilaian->kehadiran);
                                @endphp
                                <option value="" {{ $selectedKehadiran == '' ? 'selected' : '' }}>Select Nilai
                                    Kehadiran</option>
                                <option value="A" {{ $selectedKehadiran == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ $selectedKehadiran == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ $selectedKehadiran == 'C' ? 'selected' : '' }}>C</option>
                                <option value="D" {{ $selectedKehadiran == 'D' ? 'selected' : '' }}>D</option>
                                <option value="E" {{ $selectedKehadiran == 'E' ? 'selected' : '' }}>E</option>
                            </select>
                            @error('kehadiran')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kerjasama_tim" class="form-label">Kerja Sama Tim</label>
                            <select class="form-select @error('kerjasama_tim') is-invalid @enderror" name="kerjasama_tim"
                                id="kerjasama_tim">
                                @php
                                    $selectedKerjaSamaTim = old('kerjasama_tim', $penilaian->kerjasama_tim);
                                @endphp
                                <option value="" {{ $selectedKerjaSamaTim == '' ? 'selected' : '' }}>Select Nilai
                                    Kerjasama Tim</option>
                                <option value="A" {{ $selectedKerjaSamaTim == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ $selectedKerjaSamaTim == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ $selectedKerjaSamaTim == 'C' ? 'selected' : '' }}>C</option>
                                <option value="D" {{ $selectedKerjaSamaTim == 'D' ? 'selected' : '' }}>D</option>
                                <option value="E" {{ $selectedKerjaSamaTim == 'E' ? 'selected' : '' }}>E</option>
                            </select>
                            @error('kerjasama_tim')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tanggal Penilaian:</label>
                            <input type="text" class="form-control" value="{{ $penilaian->created_at ?? '-' }}"
                                readonly>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 d-grid">
                                <a href="{{ route('penilaians.index') }}" class="btn btn-outline-dark btn-lg mt-3"><i
                                        class="bi-arrow-left-circle me-2"></i>
                                    Batal</a>
                            </div>
                            <div class="col-md-6 d-grid">
                                <button type="submit" class="btn btn-dark btn-lg mt-3"><i class="bi-check-circle me-2"></i>
                                    Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
