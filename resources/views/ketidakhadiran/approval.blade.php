@extends('layouts.admin')

@section('title', 'Form Ketidakhadiran')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center my-4">{{ $pageTitle }}</h1>
            <div class="card">
                <div class="card-header bg-primary text-white">Detail Ketidakhadiran</div>
                <div class="card-body">
                    <form action="{{ route('ketidakhadirans.signApproval', ['id' => $ketidakhadiran->id]) }}" method="POST">
                        {{-- onsubmit="return validateSignature()"> --}}
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label>Nama Karyawan:</label>
                            <input type="text" class="form-control" value="{{ $ketidakhadiran->karyawan->nama }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Jenis Ketidakhadiran:</label>
                            <input type="text" class="form-control" value="{{ $ketidakhadiran->jenis_ketidakhadiran }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Mulai:</label>
                            <input type="date" class="form-control" value="{{ $ketidakhadiran->tanggal_mulai }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Berakhir:</label>
                            <input type="date" class="form-control" value="{{ $ketidakhadiran->tanggal_berakhir }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Tujuan:</label>
                            <textarea class="form-control" readonly>{{ $ketidakhadiran->tujuan }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Catatan:</label>
                            <textarea class="form-control" readonly>{{ $ketidakhadiran->catatan }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Status Pengajuan:</label>
                            <input type="text" class="form-control"
                                value="{{ $ketidakhadiran->status_pengajuan ? 'Disetujui' : 'Pending' }}" readonly>
                        </div>
                        @php
                            $disetujui =
                                $ketidakhadiran->approved_by && !$ketidakhadiran->signature
                                    ? 'Tidak Disetujui Oleh'
                                    : 'Disetujui Oleh';
                        @endphp
                        <div class="form-group">
                            <label for="approved_by">{{ $disetujui }}</label>
                            <input type="text" class="form-control"
                                value="{{ optional($ketidakhadiran->approvedBy)->nama ?? 'Belum Disetujui' }}" readonly>
                        </div>
                        @php
                            $disetujuiHCM =
                                $ketidakhadiran->approved_by_hcm && !$ketidakhadiran->signature_hcm
                                    ? 'Tidak Disetujui Oleh HCM'
                                    : 'Disetujui Oleh HCM';
                        @endphp
                        <div class="form-group">
                            <label for="approved_by_hcm">{{ $disetujuiHCM }}</label>
                            <input type="text" class="form-control"
                                value="{{ optional($ketidakhadiran->approvedByHcm)->nama ?? 'Belum Disetujui' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pengajuan:</label>
                            <input type="datetime-local" class="form-control"
                                value="{{ $ketidakhadiran->tanggal_pengajuan }}" readonly>
                        </div>

                        <div class="form-group text-center">
                            <label class="d-block mb-2" style="font-size: 1.2rem; font-weight: bold;">Tanda Tangan:</label>
                            <div class="d-flex justify-content-center">
                                <canvas id="signature-pad" class="border border-dark" width="450"
                                    height="250"></canvas>
                            </div>
                            <input type="hidden" name="signature" id="signature-input">
                            <br>
                            <button type="button" class="btn btn-outline-secondary mt-2" onclick="clearSignature()">Hapus
                                Tanda Tangan</button>
                        </div>


                        <hr>
                        <div class="row">
                            <div class="col-md-6 d-grid">
                                <a href="{{ route('ketidakhadirans.approve') }}"
                                    class="btn btn-outline-dark btn-lg mt-3"><i class="bi-arrow-left-circle me-2"></i>
                                    Batal</a>
                            </div>
                            <div class="col-md-6 d-grid">
                                <button type="button" id="approveBtn" class="btn btn-dark btn-lg mt-3"><i
                                    class="bi-check-circle me-2"></i>
                                Setuju</button>
                            </div>
                        </div>
                    </form>
                    <form id="rejectForm"
                        action="{{ route('ketidakhadirans.rejectApproval', ['id' => $ketidakhadiran->id]) }}"
                        method="POST">
                        @csrf
                        @method('put')
                        <div class="d-flex justify-content-center">
                            <button type="button" id="rejectBtn" class="btn btn-danger btn-lg mt-3">
                                <i class="bi-x-circle me-2"></i> Tolak
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        let canvas = document.getElementById('signature-pad');
        let signaturePad = new SignaturePad(canvas);

        function clearSignature() {
            signaturePad.clear();
        }

        function validateSignature() {
            if (signaturePad.isEmpty()) {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Please sign in the provided signature pad.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return false;
            }
            // Convert signature to image and store in hidden input
            document.getElementById('signature-input').value = signaturePad.toDataURL('image/png');
            return true;
        }

        document.getElementById('approveBtn').addEventListener('click', function(e) {
            e.preventDefault();

            if (signaturePad.isEmpty()) {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Please sign in the provided signature pad.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Tindakan ini akan menyetujui pengajuan.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('signature-input').value = signaturePad.toDataURL('image/png');
                    document.querySelector('form[action*="signApproval"]').submit();
                }
            });
        });

        document.getElementById('rejectBtn').addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Tindakan ini akan menolak pengajuan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, tolak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('rejectForm').submit();
                }
            });
        });
    </script>
@endpush
