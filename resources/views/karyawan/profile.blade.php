@extends('layouts.admin')

@section('title', 'Detail Karyawan')

@section('content')
    <div>
        <h1 class="text-center my-4">{{ $pageTitle }}</h1>

        {{-- <div class="row">
            <!-- Karyawan Card -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Karyawan Details</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Nama:</strong> {{ $karyawan->nama }}</p>
                        <p><strong>NIK:</strong> {{ $karyawan->nik }}</p>
                        <p><strong>Jabatan:</strong> {{ $karyawan->jabatan }}</p>
                    </div>
                </div>
            </div>

            <!-- Status Pegawai Card -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Status Pegawai</h6>
                    </div>
                    <div class="card-body">
                        @if ($karyawan->statuspegawai)
                            <p><strong>Status:</strong> {{ $karyawan->statuspegawai->status_kerja }}</p>
                            <p><strong>Mulai Kerja:</strong> {{ $karyawan->statuspegawai->mulai_kerja }} </p>
                        @else
                            <p>Status Pegawai tidak tersedia</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Penugasan Card -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">Penugasan</h6>
                    </div>
                    <div class="card-body">
                        @if ($karyawan->penugasan)
                            <p><strong>Perusahaan:</strong> {{ $karyawan->penugasan->perusahaan }}</p>
                            <p><strong>Area:</strong> {{ $karyawan->penugasan->area }}</p>
                        @else
                            <p>Tidak ada penugasan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <h3 class="profile-username text-center">{{ Auth::user()->karyawan->nama }}</h3>
                        <p class="text-muted text-center">{{ Auth::user()->karyawan->jabatan }}</p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>NIK</b> <a class="float-right">{{ Auth::user()->karyawan->nik }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right">{{ Auth::user()->karyawan->email }}</a>
                            </li>
                        </ul>

                        <a href="{{ route('karyawans.changepassword', ['id' => Auth::user()->karyawan->id]) }}" class="btn btn-outline-secondary mt-2">
                            Ganti Password
                        </a>

                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#tab1" data-toggle="tab">Personal
                                    Data</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab2" data-toggle="tab">Status Pegawai</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#tab3" data-toggle="tab">Penugasan</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab4" data-toggle="tab">Gaji</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="tab1">
                                <div class="row">
                                    <!-- First Column -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Karyawan:</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->karyawan->nama }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Lahir:</label>
                                            <input type="date" class="form-control"
                                                value="{{ Auth::user()->karyawan->tanggal_lahir }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Tempat Lahir:</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->karyawan->tempat_lahir }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Jenis Kelamin:</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->karyawan->jenis_kelamin }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Nomor Telepon Handphone:</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->karyawan->no_telepon_handphone }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Nomor Telepon Rumah:</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->karyawan->no_telepon_rumah }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat:</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->karyawan->alamat }}" readonly>
                                        </div>
                                    </div>

                                    <!-- Second Column -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kota:</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->karyawan->kota }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Provinsi:</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->karyawan->provinsi }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Negara:</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->karyawan->negara }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Kode Pos:</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->karyawan->kode_pos }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Status Pernikahan:</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->karyawan->status_pernikahan }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Agama:</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->karyawan->agama }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Pendidikan Terakhir:</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->karyawan->pendidikan_terakhir }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="tab2">
                                <div class="form-group">
                                    <label>Status Kerja:</label>
                                    <input type="text" class="form-control"
                                        value="{{ Auth::user()->karyawan->statuspegawai->status_kerja }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Mulai Kerja:</label>
                                    <input type="date" class="form-control"
                                        value="{{ Auth::user()->karyawan->statuspegawai->mulai_kerja }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Akhir Kerja:</label>
                                    <input type="date" id="akhirKerjaInput" class="form-control"
                                        value="{{ Auth::user()->karyawan->statuspegawai->akhir_kerja ?? '' }}" readonly>

                                </div>
                                <div class="form-group">
                                    <label>Alasan Berhenti:</label>
                                    <input type="text" class="form-control" id="alasanBerhentiInput"
                                        value="{{ Auth::user()->karyawan->statuspegawai->alasan_berhenti ?? '---' }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab3">
                                <div class="form-group">
                                    <label>Perusahaan:</label>
                                    <input type="text" class="form-control"
                                        value="{{ Auth::user()->karyawan->penugasan->perusahaan }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Area:</label>
                                    <input type="text" class="form-control"
                                        value="{{ Auth::user()->karyawan->penugasan->area }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Unit:</label>
                                    <input type="text" class="form-control"
                                        value="{{ Auth::user()->karyawan->penugasan->unit }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Level:</label>
                                    <input type="text" class="form-control"
                                        value="{{ Auth::user()->karyawan->penugasan->level }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Grade:</label>
                                    <input type="text" class="form-control"
                                        value="{{ Auth::user()->karyawan->penugasan->grade }}" readonly>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab4">
                                <div class="form-group">
                                    <label>Gaji Pokok:</label>
                                    <input type="text" class="form-control"
                                        value="{{ isset(Auth::user()->karyawan->gaji->gaji_pokok) ? 'Rp ' . number_format(Auth::user()->karyawan->gaji->gaji_pokok, 0, ',', '.') : '---' }}"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label>Uang Makan:</label>
                                    <input type="text" class="form-control"
                                        value="{{ isset(Auth::user()->karyawan->gaji->uang_makan) ? 'Rp ' . number_format(Auth::user()->karyawan->gaji->uang_makan, 0, ',', '.') : '---' }}"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tunjangan BPJS:</label>
                                    <input type="text" class="form-control"
                                        value="{{ isset(Auth::user()->karyawan->gaji->tunjangan_bpjs) ? 'Rp ' . number_format(Auth::user()->karyawan->gaji->tunjangan_bpjs, 0, ',', '.') : '---' }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-back-button />
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let inputField = document.getElementById("akhirKerjaInput");
            let akhirKerjaValue = inputField.value.trim(); // Get the value and trim spaces

            if (akhirKerjaValue) {
                inputField.type = "date"; // Set type to date if a value exists
            } else {
                inputField.type = "text"; // Default to text if null/empty
                inputField.value = "---"; // Display "---" if no date is available
            }
        });


    </script>
@endpush
