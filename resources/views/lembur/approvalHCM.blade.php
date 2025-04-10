@extends('layouts.admin')

@section('title', 'Form Ketidakhadiran')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center my-4">{{ $pageTitle }}</h1>
            <div class="card">
                <div class="card-header bg-primary text-white">Detail Lembur</div>
                <div class="card-body">
                    <form action="{{ route('lemburs.signApprovalHCM', ['id' => $lembur->id]) }}" method="POST"
                        onsubmit="return validateSignature()">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label>Nama Karyawan:</label>
                            <input type="text" class="form-control" value="{{ $lembur->karyawan->nama }}" readonly>
                        </div>

                        <div class="form-group">
                            <label>Perintah Atasan:</label>
                            <input type="text" class="form-control" value="{{ $lembur->perintahatasan->nama }}" readonly>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Mulai:</label>
                            <input type="date" class="form-control" value="{{ $lembur->tanggal_mulai }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Berakhir:</label>
                            <input type="date" class="form-control" value="{{ $lembur->tanggal_berakhir }}" readonly>
                        </div>

                        @if (!empty($lembur->jam_lembur))
                            <div class="form-group">
                                <label>Detail Jam Lembur:</label>
                                <ul class="list-group">
                                    @foreach (json_decode($lembur->jam_lembur, true) as $tanggal => $jam)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $tanggal }}
                                            <span class="badge bg-primary rounded-pill">{{ $jam }} Jam</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <div class="form-group">
                            <label>Tugas Lembur:</label>
                            <textarea class="form-control" readonly>{{ $lembur->tugas }}</textarea>
                        </div>
                        @php
                            $disetujui =
                                $lembur->approved_by && !$lembur->signature ? 'Tidak Disetujui Oleh' : 'Disetujui Oleh';
                        @endphp
                        <div class="form-group">
                            <label for="approved_by">{{ $disetujui }}</label>
                            <input type="text" class="form-control"
                                value="{{ optional($lembur->approvedBy)->nama ?? 'Belum Disetujui' }}" readonly>
                        </div>
                        @php
                            $disetujuiHCM =
                                $lembur->approved_by_hcm && !$lembur->signature_hcm
                                    ? 'Tidak Disetujui Oleh HCM'
                                    : 'Disetujui Oleh HCM';
                        @endphp
                        <div class="form-group">
                            <label for="approved_by_hcm">{{ $disetujuiHCM }}</label>
                            <input type="text" class="form-control"
                                value="{{ optional($lembur->approvedByHcm)->nama ?? 'Belum Disetujui' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Pengajuan:</label>
                            <input type="datetime-local" class="form-control" value="{{ $lembur->tanggal_pengajuan }}"
                                readonly>
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
                                <button type="submit" class="btn btn-dark btn-lg mt-3"><i class="bi-check-circle me-2"></i>
                                    Setuju</button>
                            </div>
                        </div>
                    </form>
                    <form id="rejectForm" action="{{ route('lemburs.rejectApprovalHCM', ['id' => $lembur->id]) }}"
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
