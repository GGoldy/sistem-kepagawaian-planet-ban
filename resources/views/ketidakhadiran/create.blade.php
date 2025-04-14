@extends('layouts.admin')

@section('title', 'Mengajukan Ketidakhadiran')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center my-4">{{ $pageTitle }}</h1>
            <x-breadcrumb :links="[
                            'Ketidakhadiran' => route('ketidakhadirans.index'),
                            'Create' => '#'
                        ]" />
            <form action="{{ route('ketidakhadirans.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Ketidakhadiran</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jenis_ketidakhadiran" class="form-label">Jenis Ketidakhadiran</label>
                                <select class="form-select @error('jenis_ketidakhadiran') is-invalid @enderror"
                                    name="jenis_ketidakhadiran" id="jenis_ketidakhadiran">
                                    <option value="">Pilih Jenis Ketidakhadiran</option>
                                    <option value="Sakit" {{ old('jenis_ketidakhadiran') == 'Sakit' ? 'selected' : '' }}>
                                        Sakit</option>
                                    <option value="Cuti" {{ old('jenis_ketidakhadiran') == 'Cuti' ? 'selected' : '' }}>
                                        Cuti</option>
                                    <option value="Penggantian Hari"
                                        {{ old('jenis_ketidakhadiran') == 'Penggantian Hari' ? 'selected' : '' }}>
                                        Penggantian Hari</option>
                                </select>
                                @error('jenis_ketidakhadiran')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>

                            <!-- Tanggal Mulai -->
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input class="form-control @error('tanggal_mulai') is-invalid @enderror" type="date"
                                    name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
                                @error('tanggal_mulai')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>

                            <!-- Tanggal Berakhir -->
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                                <input class="form-control @error('tanggal_berakhir') is-invalid @enderror" type="date"
                                    name="tanggal_berakhir" id="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}">
                                @error('tanggal_berakhir')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tujuan" class="form-label">Tujuan</label>
                                <input class="form-control @error('tujuan') is-invalid @enderror" type="text"
                                    name="tujuan" id="tujuan" value="{{ old('tujuan') }}" placeholder="Enter Tujuan">
                                @error('tujuan')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3 d-none" id="hari_pengganti_container">
                                <label class="form-label">Hari Pengganti</label>
                                <div id="hari_pengganti_wrapper">
                                    <!-- Dynamic Inputs will be inserted here -->
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="catatan" class="form-label">Catatan</label>
                                <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan" id="catatan"
                                    placeholder="Tambahkan catatan" rows="4">{{ old('catatan') }}</textarea>
                                @error('catatan')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>


                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 d-grid">
                        <a href="{{ route('ketidakhadirans.index') }}" class="btn btn-outline-dark btn-lg mt-3"><i
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
        document.addEventListener("DOMContentLoaded", function() {
            const jenisKetidakhadiran = document.getElementById("jenis_ketidakhadiran");
            const tanggalMulai = document.getElementById("tanggal_mulai");
            const tanggalBerakhir = document.getElementById("tanggal_berakhir");
            const hariPenggantiContainer = document.getElementById("hari_pengganti_container");
            const hariPenggantiWrapper = document.getElementById("hari_pengganti_wrapper");

            function generateDateInputs() {
                hariPenggantiWrapper.innerHTML = ""; // Clear previous inputs

                let startDate = new Date(tanggalMulai.value);
                let endDate = new Date(tanggalBerakhir.value);

                if (
                    jenisKetidakhadiran.value !== "Penggantian Hari" || // Check if "Penggantian Hari" is selected
                    isNaN(startDate) || isNaN(endDate) || startDate > endDate
                ) {
                    hariPenggantiContainer.classList.add("d-none");
                    return;
                }

                let daysBetween = (endDate - startDate) / (1000 * 60 * 60 * 24) + 1; // Including start date
                hariPenggantiContainer.classList.remove("d-none");

                for (let i = 0; i < daysBetween; i++) {
                    let inputDate = new Date(startDate);
                    inputDate.setDate(startDate.getDate() + i);

                    let inputElement = document.createElement("input");
                    inputElement.type = "date";
                    inputElement.name = "tanggal_pengganti[]"; // Store as array
                    inputElement.classList.add("form-control", "mb-2");
                    inputElement.value = inputDate.toISOString().split("T")[0]; // Default to same date

                    hariPenggantiWrapper.appendChild(inputElement);
                }
            }

            // Listen for changes in inputs
            jenisKetidakhadiran.addEventListener("change", generateDateInputs);
            tanggalMulai.addEventListener("change", generateDateInputs);
            tanggalBerakhir.addEventListener("change", generateDateInputs);
        });
    </script>
@endpush
