@extends('layouts.admin')

@section('title', 'Create Lokasi Kerja')

@section('content')
    <div>
        <h1 class="text-center my-4">{{ $pageTitle }}</h1>
        <x-breadcrumb :links="[
                        'Absen' => route('absens.index'),
                        'Lokasi Kerja' => route('lokasikerjas.index'),
                        'Create' => '#',
                    ]" />
        <form action="{{ route('lokasikerjas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-6">

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Lokasi Kerja</h6>
                        </div>
                        <div class="card-body">
                            <div id="map" style="height: 400px;"></div> <!-- Map Container -->
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
                                    {{-- <input class="form-control @error('latitude') is-invalid @enderror" type="text"
                                        name="latitude" id="latitude" value="{{ $errors->any() ? old('latitude') : $lokasi_kerja->latitude }}"
                                        placeholder="Enter Latitude (Decimal Format)">
                                    @error('latitude')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror --}}

                                    <input class="form-control @error('latitude') is-invalid @enderror" type="number"
                                        name="latitude" id="latitude" step="0.00000001" min="-90" max="90"
                                        value="{{ old('latitude') }}" placeholder="Latitude (Max 8 decimal places)">
                                    @error('latitude')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    {{-- <input class="form-control @error('longitude') is-invalid @enderror" type="text"
                                        name="longitude" id="longitude" value="{{ $errors->any() ? old('longitude') : $lokasi_kerja->longitude }}"
                                        placeholder="Enter Longitude (Decimal Format)">
                                    @error('longitude')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror --}}
                                    <input class="form-control @error('longitude') is-invalid @enderror" type="number"
                                        name="longitude" id="longitude" step="0.00000001" min="-180" max="180"
                                        value="{{ old('longitude') }}" placeholder="Longitude (Max 8 decimal places)">
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
            <div class="row pb-5">
                <div class="col-md-6 d-grid">
                    <a href="{{ route('lokasikerjas.index') }}" class="btn btn-outline-dark btn-lg mt-3"><i
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
            var map = L.map('map').setView([-7.31112317, 112.72883614], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var marker;

            function formatCoordinate(value, decimalPlaces) {
                return parseFloat(value).toFixed(decimalPlaces);
            }

            function updateMarker(lat, lng) {
                lat = formatCoordinate(lat, 8); // Ensure 8 decimal places for latitude
                lng = formatCoordinate(lng, 8); // Ensure 8 decimal places for longitude

                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker([lat, lng]).addTo(map);

                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lng;
            }

            map.on('click', function(e) {
                updateMarker(e.latlng.lat, e.latlng.lng);
            });
        });
    </script>
@endpush
