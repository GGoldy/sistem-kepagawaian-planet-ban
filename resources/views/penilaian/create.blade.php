@extends('layouts.admin')

@section('title', 'Mengajukan Ketidakhadiran')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center my-4">{{ $pageTitle }}</h1>
            <form action="{{ route('penilaians.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Penilaian</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="karyawan" class="form-label">Karyawan Yang Dinilai:</label>
                                <select name="karyawan" id="karyawan" class="form-control select2">
                                    <option value="">-- Select Karyawan --</option>
                                    @foreach ($karyawans as $karyawan)
                                        <option value="{{ $karyawan->id }}">
                                            {{ $karyawan->nama }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('karyawan')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="bulan_penilaian" class="form-label">Penilaian Periode Bulan:</label>
                                <select name="bulan_penilaian" id="bulan_penilaian" class="form-control">
                                    @php
                                        $months = [
                                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                        ];
                                    @endphp
                                    @foreach ($months as $month)
                                        <option value="{{ $month }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tahun_penilaian" class="form-label">Penilaian Periode Tahun:</label>
                                <select name="tahun_penilaian" id="tahun_penilaian" class="form-control">
                                    @php
                                        $currentYear = now()->year;
                                        $years = range($currentYear, $currentYear - 5);
                                    @endphp
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kinerja" class="form-label">Kinerja</label>
                                <select class="form-select @error('kinerja') is-invalid @enderror" name="kinerja"
                                    id="kinerja">
                                    <option value="">Select Nilai Kinerja</option>
                                    <option value="A" {{ old('kinerja') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('kinerja') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="C" {{ old('kinerja') == 'C' ? 'selected' : '' }}>C</option>
                                    <option value="D" {{ old('kinerja') == 'D' ? 'selected' : '' }}>D</option>
                                    <option value="E" {{ old('kinerja') == 'E' ? 'selected' : '' }}>E</option>
                                </select>
                                @error('kinerja')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kehadiran" class="form-label">Kehadiran</label>
                                <select class="form-select @error('kehadiran') is-invalid @enderror" name="kehadiran"
                                    id="kehadiran">
                                    <option value="">Select Nilai Kehadiran</option>
                                    <option value="A" {{ old('kehadiran') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('kehadiran') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="C" {{ old('kehadiran') == 'C' ? 'selected' : '' }}>C</option>
                                    <option value="D" {{ old('kehadiran') == 'D' ? 'selected' : '' }}>D</option>
                                    <option value="E" {{ old('kehadiran') == 'E' ? 'selected' : '' }}>E</option>
                                </select>
                                @error('kehadiran')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kerjasama_tim" class="form-label">Kerja Sama Tim</label>
                                <select class="form-select @error('kerjasama_tim') is-invalid @enderror" name="kerjasama_tim"
                                    id="kerjasama_tim">
                                    <option value="">Select Nilai Kerjasama Tim</option>
                                    <option value="A" {{ old('kerjasama_tim') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('kerjasama_tim') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="C" {{ old('kerjasama_tim') == 'C' ? 'selected' : '' }}>C</option>
                                    <option value="D" {{ old('kerjasama_tim') == 'D' ? 'selected' : '' }}>D</option>
                                    <option value="E" {{ old('kerjasama_tim') == 'E' ? 'selected' : '' }}>E</option>
                                </select>
                                @error('kerjasama_tim')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>
                        </div>
                    </div>
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
@endsection

@push('scripts')
    <script>
        (function($) {
            if (typeof $ === 'undefined' || typeof $.fn.select2 === 'undefined') {
                console.error('jQuery or Select2 is not loaded properly!');
                return;
            }

            console.log('jQuery version:', $.fn.jquery);
            console.log('Select2 available:', !!$.fn.select2);

            $(function() {
                try {
                    $('#karyawan').select2({
                        placeholder: "Search for an employee...",
                        allowClear: true,
                        width: "100%"
                    });
                    console.log("Select2 initialized successfully");
                } catch (e) {
                    console.error("Error initializing Select2:", e);
                }
            });
        })(jQuery);
    </script>
@endpush
