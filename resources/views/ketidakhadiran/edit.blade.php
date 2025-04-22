@extends('layouts.admin')

@section('title', 'Mengajukan Ketidakhadiran')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center my-4">{{ $pageTitle }}</h1>
            <x-breadcrumb :links="[
                            'Ketidakhadiran' => route('ketidakhadirans.index'),
                            'Data' => route('ketidakhadirans.data'),
                            'Edit' => '#'
                        ]" />
            <form action="{{ route('ketidakhadirans.update', ['ketidakhadiran' => $ketidakhadiran->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('put')
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
                                    @php
                                        $selectedJenis = old(
                                            'jenis_ketidakhadiran',
                                            $ketidakhadiran->jenis_ketidakhadiran,
                                        );
                                    @endphp
                                    <option value="" {{ $selectedJenis == '' ? 'selected' : '' }}>Pilih Jenis
                                        Ketidakhadiran</option>
                                    <option value="Sakit" {{ $selectedJenis == 'Sakit' ? 'selected' : '' }}>
                                        Sakit</option>
                                    <option value="Cuti" {{ $selectedJenis == 'Cuti' ? 'selected' : '' }}>
                                        Cuti</option>
                                    <option value="Penggantian Hari"
                                        {{ $selectedJenis == 'Penggantian Hari' ? 'selected' : '' }}>
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
                                    name="tanggal_mulai" id="tanggal_mulai"
                                    value="{{ $errors->any() ? old('tanggal_mulai') : $ketidakhadiran->tanggal_mulai }}">
                                @error('tanggal_mulai')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>

                            <!-- Tanggal Berakhir -->
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                                <input class="form-control @error('tanggal_berakhir') is-invalid @enderror" type="date"
                                    name="tanggal_berakhir" id="tanggal_berakhir"
                                    value="{{ $errors->any() ? old('tanggal_berakhir') : $ketidakhadiran->tanggal_berakhir }}">
                                @error('tanggal_berakhir')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tujuan" class="form-label">Tujuan</label>
                                <input class="form-control @error('tujuan') is-invalid @enderror" type="text"
                                    name="tujuan" id="tujuan"
                                    value="{{ $errors->any() ? old('tujuan') : $ketidakhadiran->tujuan }}"
                                    placeholder="Enter Tujuan">
                                @error('tujuan')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_sah" class="form-label">Tanggal Sah</label>
                                <input class="form-control @error('tanggal_sah') is-invalid @enderror" type="date"
                                    name="tanggal_sah" id="tanggal_sah"
                                    value="{{ $errors->any() ? old('tanggal_sah') : $ketidakhadiran->tanggal_sah }}">
                                @error('tanggal_sah')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_aktif" class="form-label">Tanggal Aktif</label>
                                <input class="form-control @error('tanggal_aktif') is-invalid @enderror" type="date"
                                    name="tanggal_aktif" id="tanggal_aktif"
                                    value="{{ $errors->any() ? old('tanggal_aktif') : $ketidakhadiran->tanggal_aktif }}">
                                @error('tanggal_aktif')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="approved_by" class="form-label">Disetujui Oleh (Atasan)</label>
                                <select name="approved_by" id="approved_by" class="form-control select2" disabled>
                                    <option value="">-- Select Karyawan --</option>
                                    @php
                                        $selected = $errors->any()
                                            ? old('approved_by')
                                            : $ketidakhadiran->approved_by ?? '';
                                    @endphp
                                    @foreach ($karyawans as $karyawan)
                                        <option value="{{ $karyawan->id }}"
                                            {{ $selected == $karyawan->id ? 'selected' : '' }}>
                                            {{ $karyawan->nama }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('approved_by')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="approved_by_hcm" class="form-label">Disetujui Oleh (HCM)</label>
                                <select name="approved_by_hcm" id="approved_by_hcm" class="form-control select2" disabled>
                                    <option value="">-- Select Karyawan --</option>
                                    @php
                                        $selected = $errors->any()
                                            ? old('approved_by_hcm')
                                            : $ketidakhadiran->approved_by_hcm ?? '';
                                    @endphp
                                    @foreach ($karyawans as $karyawan)
                                        <option value="{{ $karyawan->id }}"
                                            {{ $selected == $karyawan->id ? 'selected' : '' }}>
                                            {{ $karyawan->nama }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('approved_by_hcm')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3 {{ old('jenis_ketidakhadiran', $ketidakhadiran->jenis_ketidakhadiran) == 'Penggantian Hari' ? '' : 'd-none' }}"
                                id="hari_pengganti_container">
                                <label class="form-label">Hari Pengganti</label>
                                <div id="hari_pengganti_wrapper">
                                    @if (!empty($tanggal_pengganti))
                                        @foreach ($tanggal_pengganti as $tanggal)
                                            <input type="date" name="tanggal_pengganti[]" class="form-control mb-2"
                                                value="{{ $tanggal }}">
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            {{-- <div class="col-md-6 mb-3">
                                <label for="status_pengajuan" class="form-label">Status Pengajuan</label>
                                <div class="form-check form-switch mx-4">
                                    <!-- Hidden input to ensure 0 is always sent -->
                                    <input type="hidden" name="status_pengajuan" value="0">

                                    <!-- Checkbox input -->
                                    <input class="form-check-input @error('status_pengajuan') is-invalid @enderror"
                                        type="checkbox" id="status_pengajuan" name="status_pengajuan" value="1"
                                        {{ ($errors->any() ? old('status_pengajuan') : $ketidakhadiran->status_pengajuan ?? false) ? 'checked' : '' }}
                                        onchange="updateStatusLabel()">

                                    <!-- Label text changes dynamically -->
                                    <label class="form-check-label" for="status_pengajuan" id="status_label">
                                        {{ ($errors->any() ? old('status_pengajuan') : $ketidakhadiran->status_pengajuan ?? false) ? 'Disetujui' : 'Tidak Disetujui' }}
                                    </label>
                                </div>

                                @error('status_pengajuan')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div> --}}




                            <div class="col-md-12 mb-3">
                                <label for="catatan" class="form-label">Catatan</label>
                                <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan" id="catatan"
                                    placeholder="Tambahkan catatan" rows="4">{{ $errors->any() ? old('catatan') : $ketidakhadiran->catatan }}</textarea>
                                @error('catatan')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>


                        </div>
                    </div>
                </div>
                <hr>
                <div class="row pb-5">
                    <div class="col-md-6 d-grid">
                        <a href="{{ route('ketidakhadirans.data') }}" class="btn btn-outline-dark btn-lg mt-3"><i
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

            // Auto-show if "Penggantian Hari" was previously selected
            if (jenisKetidakhadiran.value === "Penggantian Hari") {
                hariPenggantiContainer.classList.remove("d-none");
            }

            // Listen for changes
            jenisKetidakhadiran.addEventListener("change", generateDateInputs);
            tanggalMulai.addEventListener("change", generateDateInputs);
            tanggalBerakhir.addEventListener("change", generateDateInputs);
        });

        // (function($) {
        //     if (typeof $ === 'undefined' || typeof $.fn.select2 === 'undefined') {
        //         console.error('jQuery or Select2 is not loaded properly!');
        //         return;
        //     }

        //     console.log('jQuery version:', $.fn.jquery);
        //     console.log('Select2 available:', !!$.fn.select2);

        //     $(function() {
        //         try {
        //             $('#approved_by').select2({
        //                 placeholder: "Search for an employee...",
        //                 allowClear: true,
        //                 width: "100%"
        //             });
        //             $('#approved_by_hcm').select2({
        //                 placeholder: "Search for an employee...",
        //                 allowClear: true,
        //                 width: "100%"
        //             });
        //             console.log("Select2 initialized successfully");
        //         } catch (e) {
        //             console.error("Error initializing Select2:", e);
        //         }
        //     });
        // })(jQuery);


        // function updateStatusLabel() {
        //     let checkbox = document.getElementById('status_pengajuan');
        //     let label = document.getElementById('status_label');

        //     if (checkbox.checked) {
        //         label.textContent = 'Disetujui';
        //     } else {
        //         label.textContent = 'Tidak Disetujui';
        //     }
        // }

        // // Ensure label updates correctly when the page loads
        // document.addEventListener("DOMContentLoaded", function() {
        //     updateStatusLabel();
        // });
    </script>
@endpush
