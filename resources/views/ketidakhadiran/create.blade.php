@extends('layouts.admin')

@section('title', 'Mengajukan Ketidakhadiran')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center my-4">{{ $pageTitle }}</h1>
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
                                    <option value="Penggantian Hari" {{ old('jenis_ketidakhadiran') == 'Penggantian Hari' ? 'selected' : '' }}>
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
                                <label for="hari_pengganti" class="form-label">Hari Pengganti</label>
                                <input type="date" class="form-control @error('hari_pengganti') is-invalid @enderror"
                                    name="hari_pengganti" id="hari_pengganti" value="{{ old('hari_pengganti') }}">
                                @error('hari_pengganti')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
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
        document.addEventListener("DOMContentLoaded", function () {
            const jenisKetidakhadiran = document.getElementById("jenis_ketidakhadiran");
            const hariPenggantiContainer = document.getElementById("hari_pengganti_container");
            const hariPenggantiInput = document.getElementById("hari_pengganti");

            jenisKetidakhadiran.addEventListener("change", function () {
                if (this.value === "Penggantian Hari") {
                    hariPenggantiContainer.classList.remove("d-none");
                    hariPenggantiInput.setAttribute("required", "required");
                } else {
                    hariPenggantiContainer.classList.add("d-none");
                    hariPenggantiInput.removeAttribute("required");
                }
            });

            // Ensure correct state on page load (in case of validation errors)
            if (jenisKetidakhadiran.value === "Penggantian Hari") {
                hariPenggantiContainer.classList.remove("d-none");
                hariPenggantiInput.setAttribute("required", "required");
            }
        });

    </script>
@endpush
