@extends('layouts.admin')

@section('title', 'Mengajukan Ketidakhadiran')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center my-4">{{ $pageTitle }}</h1>
            <form action="{{ route('lemburs.update', ['lembur' => $lembur->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Lembur</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="atasan" class="form-label">Perintah Atasan</label>
                                <select name="atasan" id="atasan" class="form-control select2">
                                    <option value="">-- Select Karyawan --</option>
                                    @php
                                        $selected = $errors->any() ? old('atasan') : $lembur->atasan ?? '';
                                    @endphp
                                    @foreach ($karyawans as $karyawan)
                                        <option value="{{ $karyawan->id }}"
                                            {{ $selected == $karyawan->id ? 'selected' : '' }}>
                                            {{ $karyawan->nama }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('atasan')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>

                            <!-- Tanggal Mulai -->
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input class="form-control @error('tanggal_mulai') is-invalid @enderror" type="date"
                                    name="tanggal_mulai" id="tanggal_mulai"
                                    value="{{ $errors->any() ? old('tanggal_mulai') : $lembur->tanggal_mulai }}">
                                @error('tanggal_mulai')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>

                            <!-- Tanggal Berakhir -->
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                                <input class="form-control @error('tanggal_berakhir') is-invalid @enderror" type="date"
                                    name="tanggal_berakhir" id="tanggal_berakhir"
                                    value="{{ $errors->any() ? old('tanggal_berakhir') : $lembur->tanggal_berakhir }}">
                                @error('tanggal_berakhir')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_sah" class="form-label">Tanggal Sah</label>
                                <input class="form-control @error('tanggal_sah') is-invalid @enderror" type="date"
                                    name="tanggal_sah" id="tanggal_sah"
                                    value="{{ $errors->any() ? old('tanggal_sah') : $lembur->tanggal_sah }}">
                                @error('tanggal_sah')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jam_lembur_container" class="form-label">Jam Lembur</label>
                                <div id="jam_lembur_wrapper">
                                    @if (!empty($jam_lembur))
                                        @foreach ($jam_lembur as $tanggal => $jam)
                                            <div class="mb-2">
                                                <label class="form-label">{{ $tanggal }}</label>
                                                <input type="number" name="jam_lembur[{{ $tanggal }}]"
                                                    class="form-control" value="{{ $jam }}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="tugas" class="form-label">Tugas Lembur</label>
                                <textarea class="form-control @error('tugas') is-invalid @enderror" name="tugas" id="tugas"
                                    placeholder="Tambahkan tugas" rows="4">{{ $errors->any() ? old('tugas') : $lembur->tugas }}</textarea>
                                @error('tugas')
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
                                            : $lembur->approved_by ?? '';
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
                                            : $lembur->approved_by_hcm ?? '';
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
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 d-grid">
                        <a href="{{ route('lemburs.data') }}" class="btn btn-outline-dark btn-lg mt-3"><i
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
                    $('#atasan').select2({
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

        document.addEventListener("DOMContentLoaded", function() {
            const tanggalMulai = document.getElementById("tanggal_mulai");
            const tanggalBerakhir = document.getElementById("tanggal_berakhir");
            const jamLemburWrapper = document.getElementById("jam_lembur_wrapper");

            // Get old values from Blade and store in JS
            const oldJamLembur = @json(old('jam_lembur', $jam_lembur ?? []));

            function generateLemburInputs() {
                jamLemburWrapper.innerHTML = ""; // Clear previous inputs

                let startDate = new Date(tanggalMulai.value);
                let endDate = new Date(tanggalBerakhir.value);

                if (isNaN(startDate) || isNaN(endDate) || startDate > endDate) {
                    return;
                }

                let currentDate = new Date(startDate);

                while (currentDate <= endDate) {
                    let dateString = currentDate.toISOString().split("T")[0];

                    let inputContainer = document.createElement("div");
                    inputContainer.classList.add("mb-2");

                    let label = document.createElement("label");
                    label.classList.add("form-label");
                    label.innerText = dateString;

                    let inputElement = document.createElement("input");
                    inputElement.type = "number";
                    inputElement.name = `jam_lembur[${dateString}]`; // Store values as an array
                    inputElement.classList.add("form-control");
                    inputElement.placeholder = "Jam lembur";

                    // Set old value if available
                    if (oldJamLembur[dateString] !== undefined) {
                        inputElement.value = oldJamLembur[dateString];
                    }

                    inputContainer.appendChild(label);
                    inputContainer.appendChild(inputElement);
                    jamLemburWrapper.appendChild(inputContainer);

                    // Move to the next day
                    currentDate.setDate(currentDate.getDate() + 1);
                }
            }

            // Run once on page load
            generateLemburInputs();

            // Listen for changes in date inputs
            tanggalMulai.addEventListener("change", generateLemburInputs);
            tanggalBerakhir.addEventListener("change", generateLemburInputs);
        });
    </script>
@endpush
