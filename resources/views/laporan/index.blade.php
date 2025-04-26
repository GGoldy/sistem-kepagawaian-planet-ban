@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
    <div>
        <div class="row mb-0">
            <div class="col-lg-9 col-xl-6">
                <h1 class="h3 mb-4 text-gray-800">Laporan</h1>
            </div>

        </div>
        <hr>
        <div class="row mb-3 align-items-center">
            <div class="col-md-2">
                <select id="month" class="form-control">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ now()->month == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <select id="year" class="form-control">
                    @for ($i = now()->year; $i >= now()->year - 5; $i--)
                        <option value="{{ $i }}" {{ now()->year == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <button id="filterData" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
            <div class="col-md-6">
                <select name="karyawan" id="karyawan" class="form-control select2 w-100">
                    <option value="">-- Select Karyawan --</option>
                    @php
                        $selected = $errors->any() ? old('karyawan') : $absen->karyawan_id ?? '';
                    @endphp
                    @foreach ($karyawans as $karyawan)
                        <option value="{{ $karyawan->id }}" {{ $selected == $karyawan->id ? 'selected' : '' }}>
                            {{ $karyawan->nama }}
                        </option>
                    @endforeach
                </select>

                @error('karyawan')
                    <div class="text-danger"><small>{{ $message }}</small></div>
                @enderror
            </div>
            <input type="hidden" name="selectedKaryawan" id="selectedKaryawan">
        </div>




        <div class="container-fluid">
            <div class="row">
                <!-- Left Side: Summary Cards & Table -->
                <div class="col-md-6">
                    <div class="row">
                        <!-- Ketidakhadiran Card -->
                        <div class="col-md-4 mb-3">
                            <div class="small-box bg-danger card-clickable" style="cursor: pointer; min-height: 150px;" data-target="ketidakhadiran">
                                <div class="inner">
                                    <h3>{{ $ketidakhadirans->count() }}</h3>
                                    <p>Total Ketidakhadiran</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-times"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Absen Card -->
                        <div class="col-md-4 mb-3">
                            <div class="small-box bg-warning card-clickable" style="cursor: pointer; min-height: 150px;" data-target="absen">
                                <div class="inner">
                                    <h3>{{ $absens->count() }}</h3>
                                    <p>Total Absen</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Lembur Card -->
                        <div class="col-md-4 mb-3">
                            <div class="small-box bg-success card-clickable" style="cursor: pointer; min-height: 150px;" data-target="lembur">
                                <div class="inner">
                                    <h5>Total Lembur</h5>
                                    <h4></h4>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Table Section -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Detail</h5>
                        </div>
                        <div class="card-body">
                            <div id="table-container">
                                <p class="text-center text-muted">Klik salah satu kartu di atas untuk melihat detail.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Employee Info & Salary Card -->
                <div class="col-md-6">
                    <!-- Employee Info -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-header bg-primary text-white text-center">
                            <h5 class="card-title mb-0">Informasi Karyawan</h5>
                        </div>
                        <div class="card-body text-center" id="profilKaryawan">
                            <h3 class="font-weight-bold">{{ $karyawan->first()->nama ?? 'Nama Tidak Ditemukan' }}</h3>
                            <p>NIK Karyawan: {{ $karyawan->first()->nik ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Salary Details -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Gaji Karyawan</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr id="gajiPokokRow">
                                        <th>Gaji Pokok</th>
                                        <td>Rp.
                                            {{ isset($gaji) && isset($gaji->gaji_pokok) ? number_format($gaji->gaji_pokok, 0, ',', '.') : '-' }}
                                        </td>
                                    </tr>
                                    <tr id="tunjanganRow">
                                        <th>Tunjangan</th>
                                        <td>Rp.
                                            {{ isset($gaji) && isset($gaji->tunjangan_bpjs) ? number_format($gaji->tunjangan_bpjs, 0, ',', '.') : '-' }}
                                        </td>
                                    </tr>
                                    <tr id="lemburRow">
                                        <th>Lembur (0 Jam x Rp 175.000)</th> <!-- This will be updated dynamically -->
                                        <td>Rp. -</td> <!-- This will be updated dynamically -->
                                    </tr>
                                    <tr id="absenRow">
                                        <th>Absen (Total Absen x Uang Makan)</th>
                                        <td>Rp. -</td>
                                    </tr>
                                    <tr class="table-danger" id="ketidakhadiranRow">
                                        <th>Potongan (Ketidakhadiran Belum Disetujui)</th>
                                        <td>Rp. -</td>
                                    </tr>
                                    <tr class="table-success" id="totalRow">
                                        <th>Total Gaji</th>
                                        <td>Rp. -</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        // fetchData(currentMonth, currentYear, Auth::user()->karyawan_id);
        let authKaryawanId = "{{ Auth::user()->karyawan->id }}";
        console.log("CURRENT AUTHENTICATED USER" + authKaryawanId);

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
                    $('#karyawan').on('change', function() {
                        let selectedKaryawan = $(this).val();
                        $('#selectedKaryawan').val(selectedKaryawan);
                        console.log("FROM HIDDEN INPUT: " + $('#selectedKaryawan').val());
                        let karyawan_id = selectedKaryawan;
                        console.log("FROM KARYAWAN ID: " + karyawan_id);

                        if (!karyawan_id) {
                            let karyawan_id = "{{ Auth::user()->karyawan->id }}";
                        } else {
                            $('#karyawan').removeClass('is-invalid');
                            $('#karyawanError').remove();
                        }

                        let month = $('#month').val();
                        let year = $('#year').val();
                        // fetchData(currentMonth, currentYear, karyawan_id);

                        $.ajax({
                            url: "{{ route('laporans.filter') }}",
                            type: "GET",
                            data: {
                                month: month,
                                year: year,
                                karyawan_id: karyawan_id
                            },
                            success: function(response) {
                                console.log("SUCCCESS")
                                $('#profilKaryawan h3').text(response.karyawanNama ??
                                    'Nama Tidak Ditemukan');
                                $('#profilKaryawan p').text('NIK Karyawan: ' + (response
                                    .karyawanNik ?? '-'));
                                $('.card-clickable[data-target="ketidakhadiran"] .inner h3')
                                    .text(response
                                        .ketidakhadirans.length);
                                $('.card-clickable[data-target="absen"] .inner h3').text(
                                    response.absenCount);
                                // $('.card-clickable[data-target="lembur"] .inner h3').text(response.lemburs
                                //     .length);

                                // Update Total Lembur Hours
                                $('.card-clickable[data-target="lembur"] .inner h4').text(
                                    response
                                    .totalJamLembur + ' Jam');

                                // Store data for later use
                                $('.card-clickable').data('response', response);

                                // Reset detail table
                                $('#table-container').html(
                                    '<p class="text-center text-muted">Klik salah satu kartu di atas untuk melihat detail.</p>'
                                );

                                let totalJamLembur = response.totalApprovedJamLembur;
                                let absenCount = response.absenCount;
                                let lemburRate = 175000;
                                let totalLemburAmount = totalJamLembur * lemburRate;
                                let uangMakan = response.uangMakan;
                                let gajiPokok = response.gajiPokok;
                                let tunjanganBpjs = response.tunjanganBpjs;
                                let totalUangMakan = parseInt(response.absenCount) *
                                    uangMakan;
                                let falseKetidakhadiran = response.falseCutiCount + response
                                    .falseSakitCount +
                                    response.falsePenggantianHariCount;
                                let totalKetidakhadiranAmount = falseKetidakhadiran * 10000
                                let totalGaji = gajiPokok + totalUangMakan + tunjanganBpjs +
                                    totalLemburAmount -
                                    totalKetidakhadiranAmount

                                // Format currency (Rupiah)
                                // let formattedLemburAmount = totalLemburAmount.toLocaleString('id-ID', {
                                //     style: 'currency',
                                //     currency: 'IDR'
                                // });

                                let formattedGajiPokok = 'Rp. ' + gajiPokok
                                    .toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                let formattedTunjangan = 'Rp. ' + tunjanganBpjs
                                    .toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                let formattedLemburAmount = 'Rp. ' + totalLemburAmount
                                    .toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                let formattedUangMakanAmount = 'Rp. ' + totalUangMakan
                                    .toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                let formattedKetidakhadiranAmount = 'Rp. ' +
                                    totalKetidakhadiranAmount.toString().replace(
                                        /\B(?=(\d{3})+(?!\d))/g, '.');
                                let formattedTotalGaji = 'Rp. ' + totalGaji.toString()
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                                console.log("Gaji Pokok: " + gajiPokok)
                                console.log("BPJS: " + tunjanganBpjs)
                                console.log('Total Gaji: ' + totalGaji)

                                $('#gajiPokokRow td').text(formattedGajiPokok);
                                $('#tunjanganRow td').text(formattedTunjangan);
                                $('#lemburRow th').html(
                                    `Lembur (${totalJamLembur} Jam x Rp 175.000)`);
                                $('#lemburRow td').text(formattedLemburAmount);
                                $('#absenRow th').html(
                                    `Absen (${absenCount} x Uang Makan)`);
                                $('#absenRow td').text(formattedUangMakanAmount);
                                $('#ketidakhadiranRow td').text(
                                    formattedKetidakhadiranAmount);
                                $('#totalRow td').text(formattedTotalGaji);

                                $('.card-clickable').on('click', function() {
                                    let target = $(this).data('target');
                                    let response = $(this).data('response') ||
                                    {}; // Retrieve stored response
                                    let tableContent = '';

                                    if (target === 'ketidakhadiran') {
                                        tableContent = `
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Jenis Ketidakhadiran</th>
                                                        <th>Total</th>
                                                        <th>Belum Disetujui HCM</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Sakit</th>
                                                        <td>${response.sakitCount || 0}</td>
                                                        <td>${response.falseSakitCount || 0}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Cuti</th>
                                                        <td>${response.cutiCount || 0}</td>
                                                        <td>${response.falseCutiCount || 0}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Penggantian Hari</th>
                                                        <td>${response.penggantianHariCount || 0}</td>
                                                        <td>${response.falsePenggantianHariCount || 0}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <a href="{{ route('ketidakhadirans.index') }}" class="btn btn-primary">
                                                <i class="nav-icon fas fa-book-open"></i> Detail
                                            </a>
                                        `;
                                    } else if (target === 'absen') {
                                        tableContent = `
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Absen</th>
                                                        <td>${response.absenCount || 0}</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Pulang</th>
                                                        <td>${response.pulangCount || 0}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <a href="{{ route('absens.self') }}" class="btn btn-primary">
                                                <i class="nav-icon fas fa-book-open"></i> Detail
                                            </a>
                                        `;
                                    } else if (target === 'lembur') {
                                        tableContent = `
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Total Form Lembur</th>
                                                        <td>${response.lemburCount || 0}</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Belum Disetujui HCM</th>
                                                        <td>${response.falseLemburCount || 0}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <a href="{{ route('lemburs.index') }}" class="btn btn-primary">
                                                <i class="nav-icon fas fa-book-open"></i> Detail
                                            </a>
                                        `;
                                    }

                                    $('#table-container').html(tableContent);
                                });
                            }
                        });
                    });

                } catch (e) {
                    console.error("Error initializing Select2:", e);
                }
            });
        })(jQuery);

        $(document).ready(function() {
            function formatRupiah(amount) {
                return 'Rp. ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function fetchData(month, year, karyawan_id) {
                if (!karyawan_id) {
                    let karyawan_id = "{{ Auth::user()->karyawan->id }}";
                }
                $.ajax({
                    url: "{{ route('laporans.filter') }}",
                    type: "GET",
                    data: {
                        month: month,
                        year: year,
                        karyawan_id: karyawan_id
                    },
                    success: function(response) {
                        console.log("SUCCCESS")
                        $('#profilKaryawan h3').text(response.karyawanNama ??
                            'Nama Tidak Ditemukan');
                        $('#profilKaryawan p').text('NIK Karyawan: ' + (response
                            .karyawanNik ?? '-'));
                        $('.card-clickable[data-target="ketidakhadiran"] .inner h3')
                            .text(response
                                .ketidakhadirans.length);
                        $('.card-clickable[data-target="absen"] .inner h3').text(
                            response.absenCount);
                        // $('.card-clickable[data-target="lembur"] .inner h3').text(response.lemburs
                        //     .length);

                        // Update Total Lembur Hours
                        $('.card-clickable[data-target="lembur"] .inner h4').text(
                            response
                            .totalJamLembur + ' Jam');

                        // Store data for later use
                        $('.card-clickable').data('response', response);

                        // Reset detail table
                        $('#table-container').html(
                            '<p class="text-center text-muted">Klik salah satu kartu di atas untuk melihat detail.</p>'
                        );

                        let totalJamLembur = response.totalApprovedJamLembur;
                        let absenCount = response.absenCount;
                        let lemburRate = 175000;
                        let totalLemburAmount = totalJamLembur * lemburRate;
                        let uangMakan = response.uangMakan;
                        let gajiPokok = response.gajiPokok;
                        let tunjanganBpjs = response.tunjanganBpjs;
                        let totalUangMakan = parseInt(response.absenCount) *
                            uangMakan;
                        let falseKetidakhadiran = response.falseCutiCount + response
                            .falseSakitCount +
                            response.falsePenggantianHariCount;
                        let totalKetidakhadiranAmount = falseKetidakhadiran * 10000
                        let totalGaji = gajiPokok + totalUangMakan + tunjanganBpjs +
                            totalLemburAmount -
                            totalKetidakhadiranAmount

                        // Format currency (Rupiah)
                        // let formattedLemburAmount = totalLemburAmount.toLocaleString('id-ID', {
                        //     style: 'currency',
                        //     currency: 'IDR'
                        // });

                        let formattedGajiPokok = 'Rp. ' + gajiPokok
                            .toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        let formattedTunjangan = 'Rp. ' + tunjanganBpjs
                            .toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        let formattedLemburAmount = 'Rp. ' + totalLemburAmount
                            .toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        let formattedUangMakanAmount = 'Rp. ' + totalUangMakan
                            .toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        let formattedKetidakhadiranAmount = 'Rp. ' +
                            totalKetidakhadiranAmount.toString().replace(
                                /\B(?=(\d{3})+(?!\d))/g, '.');
                        let formattedTotalGaji = 'Rp. ' + totalGaji.toString()
                            .replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                        console.log("Gaji Pokok: " + gajiPokok)
                        console.log("BPJS: " + tunjanganBpjs)
                        console.log('Total Gaji: ' + totalGaji)

                        $('#gajiPokokRow td').text(formattedGajiPokok);
                        $('#tunjanganRow td').text(formattedTunjangan);
                        $('#lemburRow th').html(
                            `Lembur (${totalJamLembur} Jam x Rp 175.000)`);
                        $('#lemburRow td').text(formattedLemburAmount);
                        $('#absenRow th').html(
                            `Absen (${absenCount} x Uang Makan)`);
                        $('#absenRow td').text(formattedUangMakanAmount);
                        $('#ketidakhadiranRow td').text(
                            formattedKetidakhadiranAmount);
                        $('#totalRow td').text(formattedTotalGaji);

                        $('.card-clickable').on('click', function() {
                            let target = $(this).data('target');
                            let response = $(this).data('response') ||
                            {}; // Retrieve stored response
                            let tableContent = '';

                            if (target === 'ketidakhadiran') {
                                tableContent = `
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Jenis Ketidakhadiran</th>
                                                        <th>Total</th>
                                                        <th>Belum Disetujui HCM</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Sakit</th>
                                                        <td>${response.sakitCount || 0}</td>
                                                        <td>${response.falseSakitCount || 0}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Cuti</th>
                                                        <td>${response.cutiCount || 0}</td>
                                                        <td>${response.falseCutiCount || 0}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Penggantian Hari</th>
                                                        <td>${response.penggantianHariCount || 0}</td>
                                                        <td>${response.falsePenggantianHariCount || 0}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <a href="{{ route('ketidakhadirans.index') }}" class="btn btn-primary">
                                                <i class="nav-icon fas fa-book-open"></i> Detail
                                            </a>
                                        `;
                            } else if (target === 'absen') {
                                tableContent = `
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Absen</th>
                                                        <td>${response.absenCount || 0}</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Pulang</th>
                                                        <td>${response.pulangCount || 0}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <a href="{{ route('absens.self') }}" class="btn btn-primary">
                                                <i class="nav-icon fas fa-book-open"></i> Detail
                                            </a>
                                        `;
                            } else if (target === 'lembur') {
                                tableContent = `
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Total Form Lembur</th>
                                                        <td>${response.lemburCount || 0}</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Belum Disetujui HCM</th>
                                                        <td>${response.falseLemburCount || 0}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <a href="{{ route('lemburs.index') }}" class="btn btn-primary">
                                                <i class="nav-icon fas fa-book-open"></i> Detail
                                            </a>
                                        `;
                            }

                            $('#table-container').html(tableContent);
                        });
                    }
                });
            }

            let karyawan_id = $('#karyawan').val();
            let currentDate = new Date();
            let currentMonth = currentDate.getMonth() + 1; // JavaScript months are 0-indexed
            let currentYear = currentDate.getFullYear();
            $('#month').val(currentMonth);
            $('#year').val(currentYear);
            if (karyawan_id) {
                fetchData(currentMonth, currentYear, karyawan_id);
            } else {
                fetchData(currentMonth, currentYear, authKaryawanId);
            }

            $('#filterData').on('click', function() {
                let month = $('#month').val();
                let year = $('#year').val();
                let karyawan_id = $('#karyawan').val();

                if (!karyawan_id) {
                    // Remove existing error message if any
                    $('#karyawan').removeClass('is-invalid');
                    $('#karyawanError').remove();

                    // Add Bootstrap validation styling
                    $('#karyawan').addClass('is-invalid');

                    // Append error message
                    $('#karyawan').after(
                        '<div id="karyawanError" class="text-danger"><small>Please select a Karyawan.</small></div>'
                    );
                } else {
                    // Remove error message if field is valid
                    $('#karyawan').removeClass('is-invalid');
                    $('#karyawanError').remove();
                }

                fetchData(month, year, karyawan_id);
                console.log('BUTTON WORKS')
            });
        })
    </script>
@endpush
