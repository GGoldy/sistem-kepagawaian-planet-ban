@extends('layouts.admin')

@section('title', 'Gaji')

@section('content')
    <div>
        <div class="row mb-0">
            <div class="col-lg-9 col-xl-6">
                <h1 class="h3 mb-4 text-gray-800">{{ $pageTitle }}</h1>
            </div>

        </div>
        <hr>
        {{-- @php
            $sakitCount = $ketidakhadirans->where('jenis_ketidakhadiran', 'Sakit')->count();
            $cutiCount = $ketidakhadirans->where('jenis_ketidakhadiran', 'Cuti')->count();
            $penggantianHariCount = $ketidakhadirans->where('jenis_ketidakhadiran', 'Penggantian Hari')->count();
            $falseSakitCount = $ketidakhadirans
                ->where('jenis_ketidakhadiran', 'Sakit')
                ->whereNull('approved_by_hcm')
                ->count();
            $falseCutiCount = $ketidakhadirans
                ->where('jenis_ketidakhadiran', 'Cuti')
                ->whereNull('approved_by_hcm')
                ->count();
            $falsePenggantianHariCount = $ketidakhadirans
                ->where('jenis_ketidakhadiran', 'Penggantian Hari')
                ->whereNull('approved_by_hcm')
                ->count();
            $absenCount = $absens->where('absen_pulang', true)->count();
            $pulangCount = $absens->where('absen_pulang', false)->count();
            $totalJamLembur = $lemburs->sum(function ($lembur) {
                return collect(json_decode($lembur->jam_lembur, true))->sum();
            });

        @endphp --}}

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
                <!-- Left Side: Summary Cards -->
                <div class="col-md-8">
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

                                    <h4>Total Lembur</h4>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Table Section -->
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="card-title">Detail</h5>
                        </div>
                        <div class="card-body">
                            <div id="table-container">
                                <p class="text-center text-muted">Klik salah satu kartu di atas untuk melihat detail.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Employee Card -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title">Informasi Karyawan</h5>
                        </div>
                        <div class="card-body text-center">
                            <h3 class="font-weight-bold">{{ $karyawan->first()->nama ?? 'Nama Tidak Ditemukan' }}</h3>
                            <p>NIK Karyawan: {{ $karyawan->first()->nik ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Gaji Karyawan</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Gaji Pokok</th>
                                        {{-- <td>Rp {{ number_format($gaji_pokok, 0, ',', '.') }}</td> --}}
                                        <td>Rp. 1.000.999</td>
                                    </tr>
                                    <tr>
                                        <th>Tunjangan</th>
                                        {{-- <td>Rp {{ number_format($tunjangan, 0, ',', '.') }}</td> --}}
                                        <td>Rp. 1.000.999</td>
                                    </tr>
                                    <tr>
                                        {{-- <th>Lembur ({{ $lembur_jam }} Jam x Rp {{ number_format($lembur_tarif, 0, ',', '.') }})</th> --}}
                                        {{-- <td>Rp {{ number_format($lembur_total, 0, ',', '.') }}</td> --}}
                                        <th>Lembur (10 Jam x Rp 175.000)</th>
                                        <td>Rp. 1.000.999</td>
                                    </tr>
                                    <tr>
                                        <th>Potongan (Absen & Ketidakhadiran)</th>
                                        {{-- <td>- Rp {{ number_format($potongan, 0, ',', '.') }}</td> --}}
                                        <td>Rp. 1.000.999</td>
                                    </tr>
                                    <tr class="table-success">
                                        <th>Total Gaji</th>
                                        {{-- <td><strong>Rp {{ number_format($total_gaji, 0, ',', '.') }}</strong></td> --}}
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

            function fetchData(month, year) {
                $.ajax({
                    url: "{{ route('gajis.filter') }}",
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
                        $('.card-clickable[data-target="absen"] .inner h3').text(response.absens
                            .length);
                        // $('.card-clickable[data-target="lembur"] .inner h3').text(response.lemburs
                        //     .length);

                        // Update Total Lembur Hours
                        $('.card-clickable[data-target="lembur"] .inner h4').text('Total Lembur: ' +
                            response.totalJamLembur + ' Jam');

                        // Store data for later use
                        $('.card-clickable').data('response', response);

                        // Reset detail table
                        $('#table-container').html(
                            '<p class="text-center text-muted">Klik salah satu kartu di atas untuk melihat detail.</p>'
                        );
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
