@extends('layouts.admin')

@section('title', 'Create Karyawan')

@section('content')
    <div>
        <h1 class="text-center my-4">{{ $pageTitle }}</h1>
        <x-breadcrumb :links="[
            'Karyawan' => route('karyawans.index'),
            'Create' => '#',
        ]" />

        <form action="{{ route('karyawans.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Personne Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input class="form-control @error('nama') is-invalid @enderror" type="text"
                                        name="nama" id="nama" value="{{ old('nama') }}" placeholder="Enter Nama">
                                    @error('nama')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input class="form-control @error('nik') is-invalid @enderror" type="text"
                                        name="nik" id="nik" value="{{ old('nik') }}" placeholder="Enter NIK">
                                    @error('nik')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <input class="form-control @error('jabatan') is-invalid @enderror" type="text"
                                        name="jabatan" id="jabatan" value="{{ old('jabatan') }}"
                                        placeholder="Enter Jabatan">
                                    @error('jabatan')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input class="form-control @error('tanggal_lahir') is-invalid @enderror" type="date"
                                        name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                    @error('tanggal_lahir')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input class="form-control @error('tempat_lahir') is-invalid @enderror" type="text"
                                        name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                        placeholder="Enter Tempat Lahir">
                                    @error('tempat_lahir')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                        name="jenis_kelamin" id="jenis_kelamin">
                                        <option value="">Select Jenis Kelamin</option>
                                        <option value="Laki-Laki"
                                            {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value="Perempuan"
                                            {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="status_pernikahan" class="form-label">Status Pernikahan</label>
                                    <select class="form-select @error('status_pernikahan') is-invalid @enderror"
                                        name="status_pernikahan" id="status_pernikahan">
                                        <option value="">Select Status Pernikahan</option>
                                        <option value="Belum Menikah"
                                            {{ old('status_pernikahan') == 'Belum Menikah' ? 'selected' : '' }}>Belum
                                            Menikah</option>
                                        <option value="Menikah"
                                            {{ old('status_pernikahan') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                    </select>
                                    @error('status_pernikahan')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="agama" class="form-label">Agama</label>
                                    <input class="form-control @error('agama') is-invalid @enderror" type="text"
                                        name="agama" id="agama" value="{{ old('agama') }}"
                                        placeholder="Enter Agama">
                                    @error('agama')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                                    <input class="form-control @error('pendidikan_terakhir') is-invalid @enderror"
                                        type="text" name="pendidikan_terakhir" id="pendidikan_terakhir"
                                        value="{{ old('pendidikan_terakhir') }}" placeholder="Enter Pendidikan Terakhir">
                                    @error('pendidikan_terakhir')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                        name="email" id="email" value="{{ old('email') }}"
                                        placeholder="Enter Email">
                                    @error('email')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input class="form-control @error('alamat') is-invalid @enderror" type="text"
                                        name="alamat" id="alamat" value="{{ old('alamat') }}"
                                        placeholder="Enter Alamat">
                                    @error('alamat')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="kota" class="form-label">Kota</label>
                                    <input class="form-control @error('kota') is-invalid @enderror" type="text"
                                        name="kota" id="kota" value="{{ old('kota') }}"
                                        placeholder="Enter Kota">
                                    @error('kota')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <input class="form-control @error('provinsi') is-invalid @enderror" type="text"
                                        name="provinsi" id="provinsi" value="{{ old('provinsi') }}"
                                        placeholder="Enter Provinsi">
                                    @error('provinsi')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="negara" class="form-label">Negara</label>
                                    <input class="form-control @error('negara') is-invalid @enderror" type="text"
                                        name="negara" id="negara" value="{{ old('negara') }}"
                                        placeholder="Enter Negara">
                                    @error('negara')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="kode_pos" class="form-label">Kode Pos</label>
                                    <input class="form-control @error('kode_pos') is-invalid @enderror" type="text"
                                        name="kode_pos" id="kode_pos" value="{{ old('kode_pos') }}"
                                        placeholder="Enter Kode Pos">
                                    @error('kode_pos')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="no_telepon_rumah" class="form-label">No. Telepon Rumah</label>
                                    <input class="form-control @error('no_telepon_rumah') is-invalid @enderror"
                                        type="text" name="no_telepon_rumah" id="no_telepon_rumah"
                                        value="{{ old('no_telepon_rumah') }}" placeholder="Enter No. Telepon Rumah">
                                    @error('no_telepon_rumah')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="no_telepon_handphone" class="form-label">No. Telepon Handphone</label>
                                    <input class="form-control @error('no_telepon_handphone') is-invalid @enderror"
                                        type="text" name="no_telepon_handphone" id="no_telepon_handphone"
                                        value="{{ old('no_telepon_handphone') }}"
                                        placeholder="Enter No. Telepon Handphone">
                                    @error('no_telepon_handphone')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Status Pegawai</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="status_kerja" class="form-label">Status Kerja</label>
                                    <select class="form-select @error('status_kerja') is-invalid @enderror"
                                        name="status_kerja" id="status_kerja">
                                        <option value="">Select Status Kerja</option>
                                        <option value="Kontrak" {{ old('status_kerja') == 'Kontrak' ? 'selected' : '' }}>
                                            Kontrak</option>
                                        <option value="Tetap" {{ old('status_kerja') == 'Tetap' ? 'selected' : '' }}>
                                            Tetap</option>
                                        <option value="Magang" {{ old('status_kerja') == 'Magang' ? 'selected' : '' }}>
                                            Magang</option>
                                    </select>
                                    @error('status_kerja')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="mulai_kerja" class="form-label">Mulai Kerja</label>
                                    <input class="form-control @error('mulai_kerja') is-invalid @enderror" type="date"
                                        name="mulai_kerja" id="mulai_kerja" value="{{ old('mulai_kerja') }}">
                                    @error('mulai_kerja')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="akhir_kerja" class="form-label">Akhir Kerja</label>
                                    <input class="form-control @error('akhir_kerja') is-invalid @enderror" type="date"
                                        name="akhir_kerja" id="akhir_kerja" value="{{ old('akhir_kerja') }}">
                                    @error('akhir_kerja')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="alasan_berhenti" class="form-label">Alasan Berhenti</label>
                                    <input class="form-control @error('alasan_berhenti') is-invalid @enderror"
                                        type="text" name="alasan_berhenti" id="alasan_berhenti"
                                        value="{{ old('alasan_berhenti') }}" placeholder="Enter Alasan Berhenti">
                                    @error('alasan_berhenti')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Penugasan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="perusahaan" class="form-label">Perusahaan</label>
                                    <input class="form-control @error('perusahaan') is-invalid @enderror" type="text"
                                        name="perusahaan" id="perusahaan" value="{{ old('perusahaan') }}"
                                        placeholder="Enter Perusahaan">
                                    @error('perusahaan')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="area" class="form-label">Area</label>
                                    <input class="form-control @error('area') is-invalid @enderror" type="text"
                                        name="area" id="area" value="{{ old('area') }}"
                                        placeholder="Enter Area">
                                    @error('area')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="unit" class="form-label">Unit</label>
                                    <input class="form-control @error('unit') is-invalid @enderror" type="text"
                                        name="unit" id="unit" value="{{ old('unit') }}"
                                        placeholder="Enter Unit">
                                    @error('unit')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="level" class="form-label">Level</label>
                                    <select class="form-select @error('level') is-invalid @enderror" name="level"
                                        id="level">
                                        <option value="">Select Level</option>
                                        <option value=1 {{ old('level') == 1 ? 'selected' : '' }}>1</option>
                                        <option value=2 {{ old('level') == 2 ? 'selected' : '' }}>2</option>
                                        <option value=3 {{ old('level') == 3 ? 'selected' : '' }}>3</option>
                                        <option value=4 {{ old('level') == 4 ? 'selected' : '' }}>4</option>
                                        <option value=5 {{ old('level') == 5 ? 'selected' : '' }}>5</option>
                                        <option value=6 {{ old('level') == 6 ? 'selected' : '' }}>6</option>
                                        <option value=7 {{ old('level') == 7 ? 'selected' : '' }}>7</option>
                                        <option value=8 {{ old('level') == 8 ? 'selected' : '' }}>8</option>
                                    </select>
                                    @error('level')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="grade" class="form-label">Grade</label>
                                    <select class="form-select @error('grade') is-invalid @enderror" name="grade"
                                        id="grade">
                                        <option value="">Select Grade</option>
                                        <option value="A" {{ old('grade') == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ old('grade') == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="C" {{ old('grade') == 'C' ? 'selected' : '' }}>C</option>
                                        <option value="D" {{ old('grade') == 'D' ? 'selected' : '' }}>D</option>
                                        <option value="E" {{ old('grade') == 'E' ? 'selected' : '' }}>E</option>
                                    </select>
                                    @error('grade')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Gaji</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="uang_makan" class="form-label">Uang Makan (Rupiah)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text"
                                            class="form-control @error('uang_makan') is-invalid @enderror"
                                            name="uang_makan" id="uang_makan"
                                            value="{{ number_format((float) old('uang_makan'), 0, ',', '.') }}"
                                            placeholder="Enter Amount">
                                    </div>

                                    @error('uang_makan')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="gaji_pokok" class="form-label">Gaji Pokok (Rupiah)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text"
                                            class="form-control @error('gaji_pokok') is-invalid @enderror"
                                            name="gaji_pokok" id="gaji_pokok"
                                            value="{{ number_format((float) old('gaji_pokok'), 0, ',', '.') }}"
                                            placeholder="Enter Amount">
                                    </div>

                                    @error('gaji_pokok')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tunjangan_bpjs" class="form-label">Tunjangan BPJS (Rupiah)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text"
                                            class="form-control @error('tunjangan_bpjs') is-invalid @enderror"
                                            name="tunjangan_bpjs" id="tunjangan_bpjs"
                                            value="{{ number_format((float) old('tunjangan_bpjs'), 0, ',', '.') }}"
                                            placeholder="Enter Amount">
                                    </div>

                                    @error('tunjangan_bpjs')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <hr>
            <div class="row pb-5">
                <div class="col-md-6 pb-5 d-grid">
                    <a href="{{ route('karyawans.index') }}" class="btn btn-outline-dark btn-lg mt-3"><i
                            class="bi-arrow-left-circle me-2"></i>
                        Batal</a>
                </div>
                <div class="col-md-6 pb-5 d-grid">
                    <button type="submit" class="btn btn-dark btn-lg mt-3"><i class="bi-check-circle me-2"></i>
                        Simpan</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let uangMakanInput = document.getElementById("uang_makan");
            let gajiPokokInput = document.getElementById('gaji_pokok');
            let tunjanganBPJSInput = document.getElementById('tunjangan_bpjs');

            uangMakanInput.addEventListener("input", function(e) {
                let value = this.value.replace(/[^0-9]/g, ""); // Remove non-numeric characters
                if (value) {
                    this.value = new Intl.NumberFormat('id-ID').format(value);
                } else {
                    this.value = "";
                }
            });
            gajiPokokInput.addEventListener("input", function(e) {
                let value = this.value.replace(/[^0-9]/g, ""); // Remove non-numeric characters
                if (value) {
                    this.value = new Intl.NumberFormat('id-ID').format(value);
                } else {
                    this.value = "";
                }
            });
            tunjanganBPJSInput.addEventListener("input", function(e) {
                let value = this.value.replace(/[^0-9]/g, ""); // Remove non-numeric characters
                if (value) {
                    this.value = new Intl.NumberFormat('id-ID').format(value);
                } else {
                    this.value = "";
                }
            });
        });
    </script>
@endpush
