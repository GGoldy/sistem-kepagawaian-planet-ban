@extends('layouts.admin')

@section('title', 'Detail Lokasi Kerja')

@section('content')
<div>
    <h1 class="text-center my-4">{{ $pageTitle }}</h1>

    <div class="row">

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Lokasi Kerja Details</h6>
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $lokasi_kerja->nama }}</p>
                    <p><strong>Latitude:</strong> {{ $lokasi_kerja->latitude }}</p>
                    <p><strong>Longitude:</strong> {{ $lokasi_kerja->longitude }}</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
