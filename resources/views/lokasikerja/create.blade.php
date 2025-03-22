@extends('layouts.admin')

@section('title', 'Create Lokasi Kerja')

@section('content')
    <div>
        <h1 class="text-center my-4">{{ $pageTitle }}</h1>
        <form action="{{ route('lokasikerjas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-6">

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Lokasi Kerja</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Nama Tempat</label>
                                    <input class="form-control @error('nama') is-invalid @enderror" type="text"
                                        name="nama" id="nama" value="{{ old('nama') }}"
                                        placeholder="Enter Nama Tempat">
                                    @error('nama')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input class="form-control @error('latitude') is-invalid @enderror" type="text"
                                        name="latitude" id="latitude" value="{{ old('latitude') }}"
                                        placeholder="Enter Latitude (Decimal Format)">
                                    @error('latitude')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input class="form-control @error('longitude') is-invalid @enderror" type="text"
                                        name="longitude" id="longitude" value="{{ old('longitude') }}"
                                        placeholder="Enter Longitude (Decimal Format)">
                                    @error('longitude')
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
                    <a href="{{ route('lokasikerjas.index') }}" class="btn btn-outline-dark btn-lg mt-3"><i
                            class="bi-arrow-left-circle me-2"></i>
                        Cancel</a>
                </div>
                <div class="col-md-6 d-grid">
                    <button type="submit" class="btn btn-dark btn-lg mt-3"><i class="bi-check-circle me-2"></i>
                        Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection
