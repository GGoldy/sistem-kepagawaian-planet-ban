@extends('layouts.admin')

@section('title', 'Mengajukan Ketidakhadiran')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center my-4">{{ $pageTitle }}</h1>
            <x-breadcrumb :links="[
                'User' => route('users.index'),
                'Create' => '#',
            ]" />
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Penilaian</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="karyawan" class="form-label">Pengguna untuk Karyawan:</label>
                                <select name="karyawan" id="karyawan" class="form-control select2">
                                    <option value="">-- Select Karyawan --</option>
                                    @foreach ($karyawans as $karyawan)
                                        <option value="{{ $karyawan->id }}" data-nik="{{ $karyawan->nik }}">
                                            {{ $karyawan->nama }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('karyawan')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">NIK</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text"
                                    name="name" id="name" value="{{ old('name') }}"
                                    placeholder="Choose an employee" readonly>
                                @error('name')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password Awal</label>
                                <div class="input-group">
                                    <input class="form-control @error('password') is-invalid @enderror" type="password"
                                        name="password" id="password" value="{{ old('password') }}"
                                        placeholder="Enter Password">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-eye toggle-password" data-target="password"
                                                style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <input class="form-control @error('confirm_password') is-invalid @enderror"
                                        type="password" name="confirm_password" id="confirm_password"
                                        value="{{ old('confirm_password') }}" placeholder="Enter Password">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-eye toggle-password" data-target="confirm_password"
                                                style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('confirm_password')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="roles">Peran (Roles)</label>
                                <select name="roles[]" id="roles" class="form-control select2" multiple required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->title }}</option>
                                    @endforeach
                                </select>
                                @error('roles')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 d-grid">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-dark btn-lg mt-3"><i
                                class="bi-arrow-left-circle me-2"></i>
                            Batal</a>
                    </div>
                    <div class="col-md-6 d-grid">
                        <button type="button" id="submitBtn" class="btn btn-dark btn-lg mt-3">
                            <i class="bi-check-circle me-2"></i> Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const input = document.getElementById(this.dataset.target);
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
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
                    $('#roles').select2({
                        placeholder: "Select a role...",
                        allowClear: true,
                        width: "100%"
                    });
                    console.log("Select2 initialized successfully");
                    $('#karyawan').on('change', function() {
                        const selected = $(this).find('option:selected');
                        const nik = selected.data('nik') || '';
                        $('#name').val(nik);
                    });
                } catch (e) {
                    console.error("Error initializing Select2:", e);
                }
            });
        })(jQuery);

        document.getElementById('submitBtn').addEventListener('click', function(e) {
            e.preventDefault();
            var form = $(this).closest("form");
            const karyawanId = document.getElementById('karyawan').value;

            if (!karyawanId) {
                Swal.fire('Peringatan', 'Silakan pilih karyawan terlebih dahulu.', 'warning');
                return;
            }

            fetch(`check-karyawan-user/${karyawanId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        Swal.fire({
                            title: 'Karyawan sudah memiliki pengguna!',
                            text: 'Apakah Anda yakin ingin melanjutkan?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, lanjutkan',
                            cancelButtonText: 'Batal',
                            footer: '<small>Tidak disarankan, Karyawan dengan pengguna ganda dapat menyebabkan kesalahan.</small>'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // document.querySelector('form').submit();
                                form.submit();
                            }
                        });
                    } else {
                        // document.querySelector('form').submit();
                        form.submit();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Gagal memeriksa data pengguna.', 'error');
                });
        });
    </script>
@endpush
