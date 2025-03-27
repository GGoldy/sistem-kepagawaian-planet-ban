@extends('layouts.admin')

@section('title', 'Karyawan Edit')

@section('content')
    <div>
        <h1 class="h3 mb-4 text-gray-800">{{ $pageTitle }}</h1>
        <form action="{{ route('karyawans.update', ['karyawan' => $karyawan->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
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
                                        name="nama" id="nama"
                                        value="{{ $errors->any() ? old('nama') : $karyawan->nama }}"
                                        placeholder="Enter Nama">
                                    @error('nama')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input class="form-control @error('nik') is-invalid @enderror" type="text"
                                        name="nik" id="nik"
                                        value="{{ $errors->any() ? old('nik') : $karyawan->nik }}" placeholder="Enter NIK">
                                    @error('nik')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <input class="form-control @error('jabatan') is-invalid @enderror" type="text"
                                        name="jabatan" id="jabatan"
                                        value="{{ $errors->any() ? old('jabatan') : $karyawan->jabatan }}"
                                        placeholder="Enter Jabatan">
                                    @error('jabatan')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input class="form-control @error('tanggal_lahir') is-invalid @enderror" type="date"
                                        name="tanggal_lahir" id="tanggal_lahir"
                                        value="{{ $errors->any() ? old('tanggal_lahir') : $karyawan->tanggal_lahir }}">
                                    @error('tanggal_lahir')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input class="form-control @error('tempat_lahir') is-invalid @enderror" type="text"
                                        name="tempat_lahir" id="tempat_lahir"
                                        value="{{ $errors->any() ? old('tempat_lahir') : $karyawan->tempat_lahir }}"
                                        placeholder="Enter Tempat Lahir">
                                    @error('tempat_lahir')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                        name="jenis_kelamin" id="jenis_kelamin">
                                        @php
                                            $selectedKelamin = old('jenis_kelamin', $karyawan->jenis_kelamin);
                                        @endphp
                                        <option value="">Select Jenis Kelamin</option>
                                        <option value="Laki-Laki" {{ $selectedKelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value="Perempuan" {{ $selectedKelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>

                                    @error('jenis_kelamin')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="status_pernikahan" class="form-label">Status Pernikahan</label>
                                    <select class="form-control @error('status_pernikahan') is-invalid @enderror"
                                        name="status_pernikahan" id="status_pernikahan">
                                        @php
                                            $selectedPernikahan = old('status_pernikahan', $karyawan->status_pernikahan);
                                        @endphp
                                        <option value="">Select Status Pernikahan</option>
                                        <option value="Belum Menikah" {{ in_array($selectedPernikahan, ['Single', 'Belum Menikah']) ? 'selected' : '' }}>Belum Menikah</option>
                                        <option value="Menikah" {{ $selectedPernikahan == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                    </select>
                                    @error('status_pernikahan')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="agama" class="form-label">Agama</label>
                                    <input class="form-control @error('agama') is-invalid @enderror" type="text"
                                        name="agama" id="agama" value="{{ $errors->any() ? old('agama') : $karyawan->agama }}"
                                        placeholder="Enter Agama">
                                    @error('agama')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                                    <input class="form-control @error('pendidikan_terakhir') is-invalid @enderror"
                                        type="text" name="pendidikan_terakhir" id="pendidikan_terakhir"
                                        value="{{ $errors->any() ? old('pendidikan_terakhir') : $karyawan->pendidikan_terakhir }}" placeholder="Enter Pendidikan Terakhir">
                                    @error('pendidikan_terakhir')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                        name="email" id="email" value="{{ $errors->any() ? old('email') : $karyawan->email }}"
                                        placeholder="Enter Email">
                                    @error('email')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input class="form-control @error('alamat') is-invalid @enderror" type="text"
                                        name="alamat" id="alamat" value="{{ $errors->any() ? old('alamat') : $karyawan->alamat }}"
                                        placeholder="Enter Alamat">
                                    @error('alamat')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="kota" class="form-label">Kota</label>
                                    <input class="form-control @error('kota') is-invalid @enderror" type="text"
                                        name="kota" id="kota" value="{{ $errors->any() ? old('kota') : $karyawan->kota }}"
                                        placeholder="Enter Kota">
                                    @error('kota')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <input class="form-control @error('provinsi') is-invalid @enderror" type="text"
                                        name="provinsi" id="provinsi" value="{{ $errors->any() ? old('provinsi') : $karyawan->provinsi }}"
                                        placeholder="Enter Provinsi">
                                    @error('provinsi')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="negara" class="form-label">Negara</label>
                                    <input class="form-control @error('negara') is-invalid @enderror" type="text"
                                        name="negara" id="negara" value="{{ $errors->any() ? old('negara') : $karyawan->negara }}"
                                        placeholder="Enter Negara">
                                    @error('negara')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="kode_pos" class="form-label">Kode Pos</label>
                                    <input class="form-control @error('kode_pos') is-invalid @enderror" type="text"
                                        name="kode_pos" id="kode_pos" value="{{ $errors->any() ? old('kode_pos') : $karyawan->kode_pos }}"
                                        placeholder="Enter Kode Pos">
                                    @error('kode_pos')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="no_telepon_rumah" class="form-label">No. Telepon Rumah</label>
                                    <input class="form-control @error('no_telepon_rumah') is-invalid @enderror"
                                        type="text" name="no_telepon_rumah" id="no_telepon_rumah"
                                        value="{{ $errors->any() ? old('no_telepon_rumah') : $karyawan->no_telepon_rumah }}" placeholder="Enter No. Telepon Rumah">
                                    @error('no_telepon_rumah')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="no_telepon_handphone" class="form-label">No. Telepon Handphone</label>
                                    <input class="form-control @error('no_telepon_handphone') is-invalid @enderror"
                                        type="text" name="no_telepon_handphone" id="no_telepon_handphone"
                                        value="{{ $errors->any() ? old('no_telepon_handphone') : $karyawan->no_telepon_handphone }}"
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
                                    <select class="form-control @error('status_kerja') is-invalid @enderror"
                                        name="status_kerja" id="status_kerja">
                                        @php
                                            $selectedStatusKerja = old('status_kerja', $status_pegawai->status_kerja);
                                        @endphp
                                        <option value="" {{ $selectedStatusKerja == '' ? 'selected' : '' }}>Select Status Kerja</option>
                                        <option value="Kontrak" {{ $selectedStatusKerja == 'Kontrak' ? 'selected' : '' }}>
                                            Kontrak</option>
                                        <option value="Tetap" {{ $selectedStatusKerja == 'Tetap' ? 'selected' : '' }}>
                                            Tetap</option>
                                        <option value="Magang" {{ $selectedStatusKerja == 'Magang' ? 'selected' : '' }}>
                                            Magang</option>
                                    </select>
                                    @error('status_kerja')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="mulai_kerja" class="form-label">Mulai Kerja</label>
                                    <input class="form-control @error('mulai_kerja') is-invalid @enderror" type="date"
                                        name="mulai_kerja" id="mulai_kerja" value="{{ $errors->any() ? old('mulai_kerja') : $status_pegawai->mulai_kerja }}">
                                    @error('mulai_kerja')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="akhir_kerja" class="form-label">Akhir Kerja</label>
                                    <input class="form-control @error('akhir_kerja') is-invalid @enderror" type="date"
                                        name="akhir_kerja" id="akhir_kerja" value="{{ $errors->any() ? old('akhir_kerja') : $status_pegawai->akhir_kerja }}">
                                    @error('akhir_kerja')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="alasan_berhenti" class="form-label">Alasan Berhenti</label>
                                    <input class="form-control @error('alasan_berhenti') is-invalid @enderror"
                                        type="text" name="alasan_berhenti" id="alasan_berhenti"
                                        value="{{ $errors->any() ? old('alasan_berhenti') : $status_pegawai->alasan_berhenti }}" placeholder="Enter Alasan Berhenti">
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
                                        name="perusahaan" id="perusahaan" value="{{ $errors->any() ? old('perusahaan') : $penugasan->perusahaan }}"
                                        placeholder="Enter Perusahaan">
                                    @error('perusahaan')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="area" class="form-label">Area</label>
                                    <input class="form-control @error('area') is-invalid @enderror" type="text"
                                        name="area" id="area" value="{{ $errors->any() ? old('area') : $penugasan->area }}"
                                        placeholder="Enter Area">
                                    @error('area')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="unit" class="form-label">Unit</label>
                                    <input class="form-control @error('unit') is-invalid @enderror" type="text"
                                        name="unit" id="unit" value="{{ $errors->any() ? old('unit') : $penugasan->unit }}"
                                        placeholder="Enter Unit">
                                    @error('unit')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="level" class="form-label">Level</label>
                                    <select class="form-control @error('level') is-invalid @enderror" name="level"
                                        id="level">
                                        @php
                                            $selectedLevel = old('level', $penugasan->level);
                                        @endphp
                                        <option value="">Select Level</option>
                                        <option value=1 {{ $selectedLevel == 1 ? 'selected' : '' }}>1</option>
                                        <option value=2 {{ $selectedLevel == 2 ? 'selected' : '' }}>2</option>
                                        <option value=3 {{ $selectedLevel == 3 ? 'selected' : '' }}>3</option>
                                        <option value=4 {{ $selectedLevel == 4 ? 'selected' : '' }}>4</option>
                                        <option value=5 {{ $selectedLevel == 5 ? 'selected' : '' }}>5</option>
                                        <option value=6 {{ $selectedLevel == 6 ? 'selected' : '' }}>6</option>
                                        <option value=7 {{ $selectedLevel == 7 ? 'selected' : '' }}>7</option>
                                        <option value=8 {{ $selectedLevel == 8 ? 'selected' : '' }}>8</option>
                                    </select>
                                    @error('level')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="grade" class="form-label">Grade</label>
                                    <select class="form-control @error('grade') is-invalid @enderror" name="grade"
                                        id="grade">
                                        @php
                                            $selectedGrade = old('grade', $penugasan->grade);
                                        @endphp
                                        <option value="">Select Grade</option>
                                        <option value="A" {{ $selectedGrade == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ $selectedGrade == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="C" {{ $selectedGrade == 'C' ? 'selected' : '' }}>C</option>
                                        <option value="D" {{ $selectedGrade == 'D' ? 'selected' : '' }}>D</option>
                                        <option value="E" {{ $selectedGrade == 'E' ? 'selected' : '' }}>E</option>
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
                                            value="{{ $errors->any() ? number_format((float) old('uang_makan', 0), 0, ',', '.') : number_format((float) ($gaji->uang_makan ?? 0), 0, ',', '.') }}"
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
                                            value="{{ $errors->any() ? number_format((float) old('gaji_pokok', 0), 0, ',', '.') : number_format((float) ($gaji->gaji_pokok ?? 0), 0, ',', '.') }}"
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
                                            value="{{ $errors->any() ? number_format((float) old('tunjangan_bpjs', 0), 0, ',', '.') : number_format((float) ($gaji->tunjangan_bpjs ?? 0), 0, ',', '.') }}"
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
            <div class="row">
                <div class="col-md-6 d-grid">
                    <a href="{{ route('karyawans.index') }}" class="btn btn-outline-dark btn-lg mt-3"><i
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
