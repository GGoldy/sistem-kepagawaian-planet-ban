@extends('layouts.admin')

@section('title', 'Absen')

@section('content')
    <div>
        <div class="row mb-3 align-items-center">
            <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                <h1 class="h3 text-gray-800">{{ $pageTitle }}</h1>
            </div>
            <div class="col-12 col-lg-6">
                <div class="d-flex flex-wrap justify-content-lg-end gap-2">

                    @if (Auth::check() && Auth::user()->karyawan)
                        <a href="{{ route('absens.self') }}" class="btn btn-info text-white" title="Lihat riwayat absen pribadi">
                            <i class="bi bi-clock-history me-1"></i> Riwayat Absen
                        </a>
                    @endif

                    @if (Auth::user()->hasRole('admin'))
                        <a href="{{ route('lokasikerjas.index') }}" class="btn btn-dark" title="Kelola lokasi kerja">
                            <i class="bi bi-geo-alt me-1"></i> Mengelola Lokasi Kerja
                        </a>

                        <a href="{{ route('absens.data') }}" class="btn btn-secondary text-white" title="Kelola data absensi">
                            <i class="bi bi-folder2-open me-1"></i> Mengelola Data Absen
                        </a>
                    @endif

                </div>
            </div>
        </div>

        <hr class="my-3 border-top border-secondary">


        <form action="{{ route('absens.store') }}" method="POST" id="absen-form">
            @csrf
            <input type="hidden" name="waktu" id="waktu">
            <input type="hidden" name="absen_pulang" id="absen_pulang">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            <input type="hidden" name="lokasi_kerja" id="lokasi_kerja">
            <input type="hidden" name="lokasi_nama" id="lokasi_nama">
            @foreach ($lokasi_kerja as $lokasi)
                <input type="hidden" class="work-location" data-id="{{ $lokasi->id }}" data-nama="{{ $lokasi->nama }}"
                    data-lat="{{ $lokasi->latitude }}" data-lng="{{ $lokasi->longitude }}">
            @endforeach



            <div class="text-center">
                <h1 class="display-4 fw-bold" id="current-date"></h1>
                <h2 class="display-1 fw-bold text-primary mt-3" id="current-time"></h2>
            </div>
            <hr class="my-3 border-top border-secondary">

            <div class="container d-flex justify-content-center">
                <div class="row w-75">
                    <!-- First Card -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">
                                <h5 class="m-0">Absen</h5>
                            </div>
                            <div class="text-center">
                                <p class="display-7 fw-bold text-primary mt-3">Jam Kerja Normal</p>
                                <p class="display-6 text-secondary mt-3">08:00 - 17:00</p>
                            </div>
                            <div class="card-body d-flex gap-3 justify-content-center">
                                <button type="button" class="btn btn-primary btn-icon-split"
                                    onclick="validateTimeLocation(1)">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    <span class="text">Masuk</span>
                                </button>
                                <button type="button" class="btn btn-secondary btn-icon-split"
                                    onclick="validateTimeLocation(0)">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-times"></i>
                                    </span>
                                    <span class="text">Pulang</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Second Card -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">
                                <h5 class="m-0">Lokasi</h5>
                            </div>
                            <div class="text-center p-4">
                                <!-- Loading Animation (Default State) -->
                                <div id="loading-animation">
                                    <div class="spinner-border text-primary" role="status"
                                        style="width: 3rem; height: 3rem;">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2 text-secondary">Fetching location...</p>
                                </div>

                                <!-- Nearest Location Text (Hidden Initially) -->
                                <p id="location-text-1" class="display-6 fw-bold text-primary mt-3 d-none"></p>
                                <p id="location-text-2" class="display-6 fw-bold text-primary mt-3 d-none"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection


@push('scripts')
    <script>
        function updateClock() {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            const dayName = days[now.getDay()];
            const day = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();

            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            document.getElementById('current-date').textContent = `${dayName}, ${day} ${month} ${year}`;
            document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
        }

        setInterval(updateClock, 1000);
        updateClock();

        function updateLocationText(locationName) {
            document.getElementById('loading-animation').style.display = 'none';
            const locationText1 = document.getElementById('location-text-1');
            const locationText2 = document.getElementById('location-text-2');
            locationText1.textContent = "Dekat dengan:";
            locationText2.textContent = locationName;
            locationText1.classList.remove('d-none');
            locationText2.classList.remove('d-none');
        }

        // Function to reset UI to loading state
        function resetToLoading() {
            document.getElementById('loading-animation').style.display = 'block';
            document.getElementById('location-text-1').classList.add('d-none');
            document.getElementById('location-text-2').classList.add('d-none');
        }

        function haversineDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Earth's radius in km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;

            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);

            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c; // Returns distance in km
        }

        // function findNearestLocation(userLat, userLng) {
        //     const workLocations = document.querySelectorAll('.work-location');
        //     let nearestLocation = null;
        //     let validLocation = false
        //     let nearestDistance = Infinity; // Start with a large number

        //     console.log("From FindNearest. Current Latitude: " + userLat + ", Longitude: " + userLng);

        //     workLocations.forEach((loc) => {
        //         const workLat = Number(loc.dataset.lat);
        //         const workLng = Number(loc.dataset.lng);
        //         const workId = loc.dataset.id;
        //         const workNama = loc.dataset.nama;

        //         if (!isNaN(workLat) && !isNaN(workLng)) {
        //             const distance = haversineDistance(userLat, userLng, workLat, workLng);
        //             console.log(
        //                 ` From Validate. Distance to work location: ${distance.toFixed(2)} km. Work Latitude: ${workLat} Work Longitude: ${workLng}`
        //             );

        //             if (distance <= 1 && distance < nearestDistance) {
        //                 validLocation = true;
        //                 nearestLocation = {
        //                     id: workId,
        //                     nama: workNama,
        //                     distance: distance
        //                 };
        //                 nearestDistance = distance;
        //             }
        //         }
        //     });

        //     if (validLocation && nearestLocation) {
        //         document.getElementById("lokasi_kerja").value = nearestLocation.id;
        //         document.getElementById("lokasi_nama").value = nearestLocation.nama;
        //         updateLocationText(nearestLocation.nama);
        //     } else {
        //         resetToLoading();
        //         // setTimeout(() => {
        //         //     findNearestLocation(userLat, userLng);
        //         // }, 1000);
        //     }
        // }

        // function updateLocation() {
        //     document.addEventListener("DOMContentLoaded", function() {
        //         document.getElementById("latitude").value = null;
        //         document.getElementById("longitude").value = null;

        //         if ("geolocation" in navigator) {
        //             navigator.geolocation.getCurrentPosition(
        //                 function(position) {
        //                     const userLat = position.coords.latitude;
        //                     const userLng = position.coords.longitude;

        //                     document.getElementById("latitude").value = userLat;
        //                     document.getElementById("longitude").value = userLng;
        //                     console.log("From Normal Location. Latitude: " + position.coords.latitude +
        //                         ", Longitude: " + position
        //                         .coords
        //                         .longitude);

        //                     findNearestLocation(userLat, userLng);
        //                 },
        //                 function(error) {
        //                     document.getElementById("latitude").value = null;
        //                     document.getElementById("longitude").value = null;
        //                     console.warn("Geolocation error:", error.message);
        //                 }
        //             );
        //         } else {
        //             document.getElementById("latitude").value = null;
        //             document.getElementById("longitude").value = null;
        //             console.warn("Geolocation is not supported by this browser.");
        //         }
        //     });
        // }

        // function updateLocationWithWatch() {
        //     document.addEventListener("DOMContentLoaded", function() {
        //         // Clear the input fields
        //         document.getElementById("latitude").value = null;
        //         document.getElementById("longitude").value = null;

        //         if (navigator.geolocation) {
        //             // Start watching the user's position
        //             let watchId = navigator.geolocation.watchPosition(
        //                 function(position) {
        //                     let latitude = position.coords.latitude.toFixed(8);
        //                     let longitude = position.coords.longitude.toFixed(8);

        //                     console.log(`User current latitude: ${latitude} and Longitude: ${longitude}`);

        //                     // Here you can send the updated coordinates to your server
        //                     fetch('absens/calculateDistance', {
        //                             method: 'POST',
        //                             headers: {
        //                                 'Content-Type': 'application/json',
        //                                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
        //                                     .getAttribute('content')
        //                             },
        //                             body: JSON.stringify({
        //                                 latitude: latitude,
        //                                 longitude: longitude
        //                             })
        //                         })
        //                         .then(response => response.json())
        //                         .then(data => {
        //                             console.log("Closest Location:", data.closest_lokasi);
        //                             console.log("Distance:", data.distance);

        //                             if (data && data.distance <= 500) {
        //                                 document.getElementById('latitude').value = latitude;
        //                                 document.getElementById('longitude').value = longitude;
        //                                 document.getElementById("lokasi_kerja").value = data.closest_lokasi
        //                                     .id;
        //                                 document.getElementById("lokasi_nama").value = data.closest_lokasi
        //                                     .nama;
        //                                 updateLocationText(data.closest_lokasi.nama);
        //                             } else {
        //                                 resetToLoading();
        //                             }
        //                         })
        //                         .catch(error => console.error('Error:', error));
        //                 },
        //                 function(error) {
        //                     console.error("Geolocation error:", error.message);
        //                     alert("Could not retrieve accurate location. Please enable GPS and try again.");
        //                 }, {
        //                     enableHighAccuracy: true,
        //                     timeout: 15000,
        //                     maximumAge: 0
        //                 }
        //             );

        //             // Optional: store watchId if you later want to stop watching the position
        //             // navigator.geolocation.clearWatch(watchId);
        //         } else {
        //             console.log("Geolocation is not supported by this browser.");
        //         }
        //     });
        // }

        function updateLocation() {
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("latitude").value = null;
                document.getElementById("longitude").value = null;

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            let latitude = position.coords.latitude.toFixed(8);
                            let longitude = position.coords.longitude.toFixed(8);

                            console.log(`User current latitude: ${latitude} and Longitude: ${longitude}`);

                            // Send data to Laravel for distance calculation
                            fetch('absens/calculateDistance', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                            .getAttribute('content')
                                    },
                                    body: JSON.stringify({
                                        latitude: latitude,
                                        longitude: longitude
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    console.log("Closest Location:", data.closest_lokasi);
                                    console.log("Distance:", data.distance);

                                    if (data && data.distance <= 500) {
                                        document.getElementById('latitude').value = latitude;
                                        document.getElementById('longitude').value = longitude;
                                        document.getElementById("lokasi_kerja").value = data.closest_lokasi
                                            .id;
                                        document.getElementById("lokasi_nama").value = data.closest_lokasi
                                            .nama;
                                        updateLocationText(data.closest_lokasi.nama);
                                    } else {
                                        resetToLoading();
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        },
                        function(error) {
                            console.error("Geolocation error:", error.message);
                            alert("Could not retrieve accurate location. Please enable GPS and try again.");
                        }, {
                            enableHighAccuracy: true,
                            timeout: 15000,
                            maximumAge: 0
                        }
                    );
                } else {
                    console.log("Geolocation is not supported by this browser.");
                }
            });
        }


        updateLocation();

        function validateTimeLocation(isPresent) {
            const now = new Date();
            now.setTime(now.getTime() + (7 * 60 * 60 * 1000));
            const hours = now.getUTCHours();
            let validLocation = false;
            let validTime = false;
            let nearestLocation = null;
            let nearestDistance = Infinity;

            console.log("Hours: " + hours)
            if ((hours >= 7 && hours <= 17) && isPresent == 1) {
                validTime = true;
            } else if (hours >= 17 && isPresent == 0) {
                validTime = true;
            }

            const userLat = Number(document.getElementById('latitude').value);
            const userLng = Number(document.getElementById('longitude').value);
            const workLocations = document.querySelectorAll('.work-location');

            if (isNaN(userLat) || isNaN(userLng)) {
                Swal.fire({
                    title: 'Location Error!',
                    text: 'Could not retrieve your location. Please allow GPS access.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return false;
            } else {
                workLocations.forEach((loc) => {
                    const workLat = Number(loc.dataset.lat);
                    const workLng = Number(loc.dataset.lng);
                    const workId = loc.dataset.id;
                    const workNama = loc.dataset.nama;

                    if (!isNaN(workLat) && !isNaN(workLng)) {
                        const distance = haversineDistance(userLat, userLng, workLat, workLng);
                        console.log(` From Validate. Distance to work location: ${distance.toFixed(2)} km`);

                        if (distance <= 1 && distance < nearestDistance) {
                            validLocation = true;
                            nearestLocation = {
                                id: workId,
                                nama: workNama,
                                distance: distance
                            };
                            nearestDistance = distance;
                        }
                    }
                });
            }
            console.log("Location: " + validLocation)
            console.log("Time: " + validTime)

            if (validTime && validLocation) {
                document.getElementById('lokasi_nama').value = nearestLocation.nama;
                let lokasiTerdekat = nearestLocation.id

                submitAbsen(isPresent, now, lokasiTerdekat)

            } else if (!validTime && validLocation) {
                Swal.fire({
                    title: 'Error!',
                    text: 'You are not in a valid time to check in/out.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });

            } else if (validTime && !validLocation) {
                Swal.fire({
                    title: 'Out of Range!',
                    text: `You are not within any valid work location.`,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });

            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });

            }

            validLocation = false
            validTime = false
        }

        function submitAbsen(isPresent, now, lokasiTerdekat) {
            const formattedDateTime = now.toISOString().slice(0, 19).replace('T', ' '); // Format: YYYY-MM-DD HH:MM:SS

            document.getElementById('lokasi_kerja').value = lokasiTerdekat;
            document.getElementById('waktu').value = formattedDateTime;
            document.getElementById('absen_pulang').value = isPresent;
            document.getElementById('absen-form').submit();

        }
    </script>
@endpush
