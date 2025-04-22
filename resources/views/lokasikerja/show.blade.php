@extends('layouts.admin')

@section('title', 'Detail Lokasi Kerja')

@section('content')
    <div>
        <h1 class="text-center my-4">{{ $pageTitle }}</h1>
        <x-breadcrumb :links="[
                        'Absen' => route('absens.index'),
                        'Lokasi Kerja' => route('lokasikerjas.index'),
                        'Show' => '#',
                    ]" />
        <input type="hidden" id="latitude" value="{{ $lokasi_kerja->latitude }}">
        <input type="hidden" id="longitude" value="{{ $lokasi_kerja->longitude }}">

        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Lokasi Kerja Details</h6>

                    </div>
                    <div id="map" style="height: 400px;"></div> <!-- Map Container -->
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
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let oldLat = document.getElementById('latitude').value || -7.31112317;
            let oldLng = document.getElementById('longitude').value || 112.72883614;

            var map = L.map('map').setView([oldLat, oldLng], 12);

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
            updateMarker(oldLat, oldLng);

        });
    </script>
@endpush
