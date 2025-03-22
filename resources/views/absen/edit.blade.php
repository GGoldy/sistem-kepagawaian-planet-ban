@extends('layouts.admin')

@section('title', 'Absen Edit')

@push('select2')
<!-- Ensure Select2 CSS is loaded properly -->
<style>
    /* Improve Select2 styling to match your Bootstrap theme */
    .select2-container--default .select2-selection--single {
        height: 38px !important;
        padding: 0.375rem 0.75rem !important;
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5 !important;
        padding-left: 0 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
    .select2-dropdown {
        z-index: 9999;
    }
</style>
@endpush

@section('content')
    <div>
        <h1 class="h3 mb-4 text-gray-800">{{ $pageTitle }}</h1>
        <form action="{{ route('absens.update', ['absen' => $absen->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')

            @foreach ($lokasi_kerjas as $lokasi_kerja)
                <input type="hidden" class="work-location" data-id="{{ $lokasi_kerja->id }}"
                    data-nama="{{ $lokasi_kerja->nama }}" data-lat="{{ $lokasi_kerja->latitude }}"
                    data-lng="{{ $lokasi_kerja->longitude }}">
            @endforeach

            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">


            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Absen Data Edit</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="absen_pulang" class="form-label">Absen / Pulang</label>
                            <select class="form-control @error('absen_pulang') is-invalid @enderror" name="absen_pulang"
                                id="absen_pulang">
                                @php
                                    $selectedGrade = old('absen_pulang', $absen->absen_pulang);
                                @endphp
                                <option value="">Select Absen/Pulang</option>
                                <option value=1 {{ $selectedGrade == 1 ? 'selected' : '' }}>Absen</option>
                                <option value=0 {{ $selectedGrade == 0 ? 'selected' : '' }}>Pulang</option>
                            </select>
                            @error('absen_pulang')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="waktu" class="form-label">Waktu Absen</label>
                            <input class="form-control @error('waktu') is-invalid @enderror" type="datetime-local"
                                name="waktu" id="waktu"
                                value="{{ $errors->any() ? old('waktu') : ($absen->waktu ? \Carbon\Carbon::parse($absen->waktu)->format('Y-m-d\TH:i') : '') }}">

                            @error('waktu')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="lokasi_kerja" class="form-label">Lokasi Kerja</label>
                            <select name="lokasi_kerja" id="lokasi_kerja" class="form-select">
                                @php
                                    $selected = '';
                                    if ($errors->any()) {
                                        $selected = old('lokasi_kerja');
                                    } else {
                                        $selected = $absen->lokasi_kerja_id;
                                    }
                                @endphp
                                @foreach ($lokasi_kerjas as $lokasi_kerja)
                                    <option value="{{ $lokasi_kerja->id }}"
                                        {{ $selected == $lokasi_kerja->id ? 'selected' : '' }}>
                                        {{ $lokasi_kerja->nama }}</option>
                                @endforeach
                            </select>

                            @error('lokasi_kerja')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="karyawan" class="form-label">Karyawan</label>
                            <select name="karyawan" id="karyawan" class="form-control select2">
                                <option value="">-- Select Karyawan --</option>
                                @php
                                    $selected = $errors->any() ? old('karyawan') : $absen->karyawan_id ?? '';
                                @endphp
                                @foreach ($karyawans as $karyawan)
                                    <option value="{{ $karyawan->id }}"
                                        {{ $selected == $karyawan->id ? 'selected' : '' }}>
                                        {{ $karyawan->nama }}
                                    </option>
                                @endforeach
                            </select>

                            @error('karyawan')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 d-grid">
                    <a href="{{ route('absens.data') }}" class="btn btn-outline-dark btn-lg mt-3"><i
                            class="bi-arrow-left-circle me-2"></i>
                        Cancel</a>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="submit" class="btn btn-dark btn-lg mt-3"><i class="bi-check-circle me-2"></i>
                        Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // First script for location handling
        document.addEventListener("DOMContentLoaded", function() {
            const lokasiKerjaSelect = document.getElementById("lokasi_kerja");
            const latitudeInput = document.getElementById("latitude");
            const longitudeInput = document.getElementById("longitude");
            const workLocations = document.querySelectorAll(".work-location");

            function setLocationValues() {
                const selectedId = lokasiKerjaSelect.value;
                workLocations.forEach((loc) => {
                    if (loc.dataset.id === selectedId) {
                        latitudeInput.value = loc.dataset.lat;
                        longitudeInput.value = loc.dataset.lng;
                    }
                });
            }

            // Run once on page load
            setLocationValues();

            // Update when user selects a different location
            lokasiKerjaSelect.addEventListener("change", setLocationValues);
        });
        
        // Separate script for Select2 initialization with jQuery check
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