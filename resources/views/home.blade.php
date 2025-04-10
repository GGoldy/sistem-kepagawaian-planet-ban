@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div>
        <div class="row mb-0">
            <div class="col-lg-9 col-xl-6">
                <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
            </div>

        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-md-3">
                <select id="month" class="form-control">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ now()->month == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <select id="year" class="form-control">
                    @for ($i = now()->year; $i >= now()->year - 5; $i--)
                        <option value="{{ $i }}" {{ now()->year == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <button id="filterData" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </div>



        <div class="container-fluid">
            <div class="row">
                <!-- Left Side: Summary Cards & Table -->
                <div class="col-md-6">
                    <div class="row">
                        <!-- Ketidakhadiran Card -->
                        <div class="col-md-4 mb-3">
                            <div class="small-box bg-danger card-clickable" data-target="ketidakhadiran">
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
                            <div class="small-box bg-warning card-clickable" data-target="absen">
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
                            <div class="small-box bg-success card-clickable" data-target="lembur">
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
                        <div class="card-header bg-secondary text-white">
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
                        <div class="card-body text-center">
                            <h3 class="font-weight-bold">{{ $karyawan->first()->nama ?? 'Nama Tidak Ditemukan' }}</h3>
                            <p>NIK Karyawan: {{ $karyawan->first()->nik ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Salary Details -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Gaji Karyawan</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Gaji Pokok</th>
                                        <td>Rp.
                                            {{ isset($gaji) && isset($gaji->gaji_pokok) ? number_format($gaji->gaji_pokok, 0, ',', '.') : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tunjangan</th>
                                        <td>Rp.
                                            {{ isset($gaji) && isset($gaji->tunjangan_bpjs) ? number_format($gaji->tunjangan_bpjs, 0, ',', '.') : '-' }}
                                        </td>
                                    </tr>
                                    <tr id="lemburRow">
                                        <th>Lembur (0 Jam x Rp 175.000)</th> <!-- This will be updated dynamically -->
                                        <td>Rp. 0</td> <!-- This will be updated dynamically -->
                                    </tr>
                                    <tr id="absenRow">
                                        <th>Absen (Total Absen x Uang Makan)</th>
                                        <td>Rp. 1.000.999</td>
                                    </tr>
                                    <tr class="table-danger" id="ketidakhadiranRow">
                                        <th>Potongan (Ketidakhadiran Belum Disetujui)</th>
                                        <td>Rp. 1.000.999</td>
                                    </tr>
                                    <tr class="table-success" id="totalRow">
                                        <th>Total Gaji</th>
                                        <td>Rp. 1.000.999</td>
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
    <script type="module">
        $(document).ready(function() {
            let karyawan_id = "{{ Auth::user()->karyawan->id }}"; // Get karyawan_id from Blade

            function formatRupiah(amount) {
                return 'Rp. ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function fetchData(month, year) {
                $.ajax({
                    url: "{{ route('filter') }}",
                    type: "GET",
                    data: {
                        month: month,
                        year: year,
                        karyawan_id: karyawan_id
                    },
                    success: function(response) {
                        // Update counts dynamically
                        $('.card-clickable[data-target="ketidakhadiran"] .inner h3').text(response
                            .ketidakhadirans.length);
                        $('.card-clickable[data-target="absen"] .inner h3').text(response.absenCount);
                        // $('.card-clickable[data-target="lembur"] .inner h3').text(response.lemburs
                        //     .length);

                        // Update Total Lembur Hours
                        $('.card-clickable[data-target="lembur"] .inner h4').text(response
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
                        let totalUangMakan = parseInt(response.absenCount) * uangMakan;
                        let falseKetidakhadiran = response.falseCutiCount + response.falseSakitCount + response.falsePenggantianHariCount;
                        let totalKetidakhadiranAmount = falseKetidakhadiran * 10000
                        let totalGaji = gajiPokok + totalUangMakan + tunjanganBpjs + totalLemburAmount - totalKetidakhadiranAmount

                        // Format currency (Rupiah)
                        // let formattedLemburAmount = totalLemburAmount.toLocaleString('id-ID', {
                        //     style: 'currency',
                        //     currency: 'IDR'
                        // });

                        let formattedLemburAmount = formatRupiah(totalLemburAmount);
                        let formattedUangMakanAmount = formatRupiah(totalUangMakan)
                        let formattedKetidakhadiranAmount = formatRupiah(totalKetidakhadiranAmount)
                        let formattedTotalGaji = formatRupiah(totalGaji);

                        $('#lemburRow th').html(`Lembur (${totalJamLembur} Jam x Rp 175.000)`);
                        $('#lemburRow td').text(formattedLemburAmount);
                        $('#absenRow th').html(`Absen (${absenCount} x Uang Makan)`);
                        $('#absenRow td').text(formattedUangMakanAmount);
                        $('#ketidakhadiranRow td').text(formattedKetidakhadiranAmount);
                        $('#totalRow td').text(formattedTotalGaji);
                    }
                });
            }

            let currentDate = new Date();
            let currentMonth = currentDate.getMonth() + 1; // JavaScript months are 0-indexed
            let currentYear = currentDate.getFullYear();
            fetchData(currentMonth, currentYear);

            // Filter button click event
            $('#filterData').on('click', function() {
                let month = $('#month').val();
                let year = $('#year').val();
                fetchData(month, year);
            });

            // Card click event
            $('.card-clickable').on('click', function() {
                let target = $(this).data('target');
                let response = $(this).data('response') || {}; // Retrieve stored response
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
                <a href="{{ route('ketidakhadirans.index') }}" class="btn btn-secondary">
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
                <a href="{{ route('absens.self') }}" class="btn btn-secondary">
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
                <a href="{{ route('lemburs.index') }}" class="btn btn-secondary">
                    <i class="nav-icon fas fa-book-open"></i> Detail
                </a>
            `;
                }

                $('#table-container').html(tableContent);
            });
        });
    </script>
@endpush
