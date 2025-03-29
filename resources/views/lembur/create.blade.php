@extends('layouts.admin')

@section('title', 'Mengajukan Ketidakhadiran')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center my-4">{{ $pageTitle }}</h1>
            <form action="{{ route('lemburs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Ketidakhadiran</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="atasan" class="form-label">Tugas Atasan:</label>
                                <select name="atasan" id="atasan" class="form-control select2">
                                    <option value="">-- Select Karyawan --</option>
                                    @foreach ($karyawans as $karyawan)
                                        <option value="{{ $karyawan->id }}">
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

                            <div id="jam_lembur_container">
                                @if (!empty(old('jam_lembur', $jam_lembur ?? [])))
                                    @foreach (old('jam_lembur', $jam_lembur ?? []) as $tanggal => $jam)
                                        <div class="mb-2">
                                            <label class="form-label">Jam Lembur ({{ $tanggal }})</label>
                                            <input type="number" name="jam_lembur[{{ $tanggal }}]"
                                                class="form-control" value="{{ $jam }}" min="0" required>
                                        </div>
                                    @endforeach
                                @endif
                            </div>



                            <div class="col-md-12 mb-3">
                                <label for="tugas" class="form-label">Tugas</label>
                                <textarea class="form-control @error('tugas') is-invalid @enderror" name="tugas" id="tugas"
                                    placeholder="Jelaskan tugas lembur" rows="4">{{ old('tugas') }}</textarea>
                                @error('tugas')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>


                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 d-grid">
                        <a href="{{ route('lemburs.index') }}" class="btn btn-outline-dark btn-lg mt-3"><i
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

        // document.addEventListener("DOMContentLoaded", function() {
        //     const tanggalMulai = document.getElementById('tanggal_mulai');
        //     const tanggalBerakhir = document.getElementById('tanggal_berakhir');
        //     const jamLemburContainer = document.getElementById('jam_lembur_container');

        //     function generateInputs() {
        //         jamLemburContainer.innerHTML = ''; // Clear previous inputs

        //         const startDate = new Date(tanggalMulai.value);
        //         const endDate = new Date(tanggalBerakhir.value);

        //         if (isNaN(startDate) || isNaN(endDate)) {
        //             return; // Exit if dates are invalid
        //         }

        //         const timeDiff = endDate - startDate;
        //         const dayCount = Math.max(1, Math.floor(timeDiff / (1000 * 60 * 60 * 24)) +
        //             1); // Ensure at least 1 input

        //         for (let i = 0; i < dayCount; i++) {
        //             const inputGroup = document.createElement("div");

        //             inputGroup.innerHTML = `
    //             <label>Jam Lembur (Day ${i + 1}):</label>
    //             <input type="number" name="jam_lembur[]" min="0" required>
    //         `;

        //             jamLemburContainer.appendChild(inputGroup);
        //         }
        //     }

        //     // Trigger input generation when dates change
        //     tanggalMulai.addEventListener("change", generateInputs);
        //     tanggalBerakhir.addEventListener("change", generateInputs);
        // });

        document.addEventListener("DOMContentLoaded", function() {
            const tanggalMulai = document.getElementById('tanggal_mulai');
            const tanggalBerakhir = document.getElementById('tanggal_berakhir');
            const jamLemburContainer = document.getElementById('jam_lembur_container');

            // Retrieve old values safely
            const oldJamLembur = {!! json_encode(old('jam_lembur', $jam_lembur ?? [])) !!};

            function generateInputs() {
                jamLemburContainer.innerHTML = ''; // Clear previous inputs

                const startDate = new Date(tanggalMulai.value);
                const endDate = new Date(tanggalBerakhir.value);

                if (isNaN(startDate) || isNaN(endDate) || startDate > endDate) {
                    return;
                }

                let currentDate = new Date(startDate);

                while (currentDate <= endDate) {
                    const dateString = currentDate.toISOString().split("T")[0];

                    const inputGroup = document.createElement("div");
                    inputGroup.classList.add("mb-2");

                    const label = document.createElement("label");
                    label.classList.add("form-label");
                    label.innerText = `Jam Lembur (${dateString}):`;

                    const input = document.createElement("input");
                    input.type = "number";
                    input.name = `jam_lembur[${dateString}]`;
                    input.classList.add("form-control");
                    input.placeholder = "Jumlah jam lembur";
                    input.min = 0;
                    input.required = true;

                    // Set old value if available
                    if (oldJamLembur && oldJamLembur[dateString] !== undefined) {
                        input.value = oldJamLembur[dateString];
                    }

                    inputGroup.appendChild(label);
                    inputGroup.appendChild(input);
                    jamLemburContainer.appendChild(inputGroup);

                    currentDate.setDate(currentDate.getDate() + 1);
                }
            }

            // Run on page load
            generateInputs();

            // Listen for date changes
            tanggalMulai.addEventListener("change", generateInputs);
            tanggalBerakhir.addEventListener("change", generateInputs);
        });
    </script>
@endpush
