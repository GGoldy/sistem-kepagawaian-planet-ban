{{-- @extends('layouts.admin')

@section('title', 'Absen')

@section('content')
    <div>
        <div class="row mb-3 align-items-start">
            <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                <div class="d-flex flex-column justify-content-center h-100">
                    <h1 class="h3 text-gray-800 mb-2">{{ $pageTitle }}</h1>
                    <div class="mt-n1">
                        <x-breadcrumb :links="[
                            'Absen' => '#',
                        ]" />
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="d-flex flex-wrap justify-content-lg-end gap-2 align-items-start">
                    @if (Auth::check() && Auth::user()->karyawan)
                        <a href="{{ route('absens.self') }}" class="btn btn-info text-white"
                           title="Lihat riwayat absen pribadi">
                            <i class="bi bi-clock-history me-1"></i> Riwayat Absen
                        </a>
                    @endif

                    @if (Auth::user()->hasRole('admin'))
                        <a href="{{ route('lokasikerjas.index') }}" class="btn btn-dark" title="Kelola lokasi kerja">
                            <i class="bi bi-geo-alt me-1"></i> Mengelola Lokasi Kerja
                        </a>

                        <a href="{{ route('absens.data') }}" class="btn btn-secondary text-white"
                           title="Kelola data absensi">
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
@endpush --}}

@extends('layouts.admin')

@section('title', 'Absen')

@section('content')
    <div>
        <div class="row mb-3 align-items-start">
            <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                <div class="d-flex flex-column justify-content-center h-100">
                    <h1 class="h3 text-gray-800 mb-2">{{ $pageTitle }}</h1>
                    <div class="mt-n1">
                        <x-breadcrumb :links="[
                            'Absen' => '#',
                        ]" />
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="d-flex flex-wrap justify-content-lg-end gap-2 align-items-start">
                    @if (Auth::check() && Auth::user()->karyawan)
                        <a href="{{ route('absens.self') }}" class="btn btn-info text-white"
                            title="Lihat riwayat absen pribadi">
                            <i class="bi bi-clock-history me-1"></i> Riwayat Absen
                        </a>
                    @endif

                    @if (Auth::user()->hasRole('admin'))
                        <a href="{{ route('lokasikerjas.index') }}" class="btn btn-dark" title="Kelola lokasi kerja">
                            <i class="bi bi-geo-alt me-1"></i> Mengelola Lokasi Kerja
                        </a>

                        <a href="{{ route('absens.data') }}" class="btn btn-secondary text-white"
                            title="Kelola data absensi">
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
            let e = new Date,
                t = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"][e.getDay()],
                o = e.getDate(),
                n = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober",
                    "November", "Desember"
                ][e.getMonth()],
                a = e.getFullYear(),
                i = String(e.getHours()).padStart(2, "0"),
                l = String(e.getMinutes()).padStart(2, "0"),
                r = String(e.getSeconds()).padStart(2, "0");
            document.getElementById("current-date").textContent = `${t}, ${o} ${n} ${a}`, document.getElementById(
                "current-time").textContent = `${i}:${l}:${r}`
        }

        function updateLocationText(e) {
            document.getElementById("loading-animation").style.display = "none";
            let t = document.getElementById("location-text-1"),
                o = document.getElementById("location-text-2");
            t.textContent = "Dekat dengan:", o.textContent = e, t.classList.remove("d-none"), o.classList.remove("d-none")
        }

        function resetToLoading() {
            document.getElementById("loading-animation").style.display = "block", document.getElementById("location-text-1")
                .classList.add("d-none"), document.getElementById("location-text-2").classList.add("d-none")
        }

        function haversineDistance(e, t, o, n) {
            let a = (o - e) * Math.PI / 180,
                i = (n - t) * Math.PI / 180,
                l = Math.sin(a / 2) * Math.sin(a / 2) + Math.cos(e * Math.PI / 180) * Math.cos(o * Math.PI / 180) * Math
                .sin(i / 2) * Math.sin(i / 2);
            return 6371 * (2 * Math.atan2(Math.sqrt(l), Math.sqrt(1 - l)))
        }
        setInterval(updateClock, 1e3), updateClock();
        let locationSamples = [],
            watchPositionId = null,
            manualCoordinates = null;

        function updateLocation() {
            if (document.getElementById("latitude").value = null, document.getElementById("longitude").value = null,
                locationSamples = [], resetToLoading(), !navigator.geolocation) {
                showGeolocationError("Your browser does not support geolocation. Please use a modern browser.");
                return
            }
            null !== watchPositionId && navigator.geolocation.clearWatch(watchPositionId), watchPositionId = navigator
                .geolocation.watchPosition(handlePositionUpdate, handlePositionError, {
                    enableHighAccuracy: !0,
                    timeout: 1e4,
                    maximumAge: 0
                }), setTimeout(() => {
                    null === watchPositionId || (navigator.geolocation.clearWatch(watchPositionId), watchPositionId =
                        null, locationSamples.length > 0 ? processLocationSamples() : document.getElementById(
                            "latitude").value || offerManualLocationEntry())
                }, 15e3)
        }

        // function handlePositionUpdate(e) {
        //     if (locationSamples.push({
        //             latitude: e.coords.latitude,
        //             longitude: e.coords.longitude,
        //             accuracy: e.coords.accuracy,
        //             timestamp: e.timestamp
        //         }), console.log(
        //             `Location sample collected: Lat ${e.coords.latitude}, Lng ${e.coords.longitude}, Accuracy: ${e.coords.accuracy}m`
        //         ), locationSamples.length >= 3) {
        //         let t = locationSamples.filter(e => e.accuracy < 100);
        //         t.length >= 2 && (navigator.geolocation.clearWatch(watchPositionId), watchPositionId = null,
        //             processLocationSamples())
        //     }
        // }

        function handlePositionUpdate(e) {
            if (
                locationSamples.push({
                    latitude: e.coords.latitude,
                    longitude: e.coords.longitude,
                    accuracy: e.coords.accuracy,
                    timestamp: e.timestamp
                }),
                console.log(
                    `Location sample collected: Lat ${e.coords.latitude}, Lng ${e.coords.longitude}, Accuracy: ${e.coords.accuracy}m`
                ),
                locationSamples.length >= 3
            ) {
                // Always wait for 3 samples minimum before doing anything
                navigator.geolocation.clearWatch(watchPositionId),
                    watchPositionId = null,
                    processLocationSamples();
            }
        }


        function processLocationSamples() {
            if (0 === locationSamples.length) {
                offerManualLocationEntry();
                return
            }
            locationSamples.sort((e, t) => e.accuracy - t.accuracy);
            let e = locationSamples[0];
            console.log(`Using best sample with accuracy ${e.accuracy}m`);
            let t = e.latitude.toFixed(8),
                o = e.longitude.toFixed(8);
            sendLocationToServer(t, o)
        }

        function handlePositionError(e) {
            console.error("Geolocation error:", e.message), navigator.geolocation.clearWatch(watchPositionId),
                watchPositionId = null;
            let t = "Could not retrieve accurate location. ";
            switch (e.code) {
                case e.PERMISSION_DENIED:
                    t +=
                        "You denied the request for location access. Please enable location services for this website in your browser settings.";
                    break;
                case e.POSITION_UNAVAILABLE:
                    t += "Location information is unavailable. Please check your device's GPS.";
                    break;
                case e.TIMEOUT:
                    t += "The request to get your location timed out. Please try again.";
                    break;
                default:
                    t += "An unknown error occurred."
            }
            Swal.fire({
                title: "Location Error",
                text: t,
                icon: "error",
                confirmButtonText: "Enter Manually",
                showCancelButton: !0,
                cancelButtonText: "Cancel"
            }).then(e => {
                e.isConfirmed && offerManualLocationEntry()
            })
        }

        function offerManualLocationEntry() {
            Swal.fire({
                title: "Enter Location Manually",
                html: `
            <div class="text-left mb-3">
                <p>Browser geolocation is not working accurately. You can:</p>
                <ol>
                    <li>Try using a different device</li>
                    <li>Use a mobile device with GPS</li>
                    <li>Enter coordinates manually (if you know them)</li>
                </ol>
            </div>
            <div class="form-group mb-3">
                <label for="manual-latitude" class="form-label">Latitude</label>
                <input type="number" id="manual-latitude" class="form-control" step="0.00000001" placeholder="e.g. -7.25381234">
            </div>
            <div class="form-group">
                <label for="manual-longitude" class="form-label">Longitude</label>
                <input type="number" id="manual-longitude" class="form-control" step="0.00000001" placeholder="e.g. 112.73425678">
            </div>
        `,
                showCancelButton: !0,
                confirmButtonText: "Submit",
                cancelButtonText: "Cancel",
                focusConfirm: !1,
                preConfirm() {
                    let e = document.getElementById("manual-latitude").value,
                        t = document.getElementById("manual-longitude").value;
                    return e && t ? {
                        latitude: e,
                        longitude: t
                    } : (Swal.showValidationMessage("Please enter both latitude and longitude"), !1)
                }
            }).then(e => {
                if (e.isConfirmed) {
                    let t = e.value.latitude.toString(),
                        o = e.value.longitude.toString();
                    sendLocationToServer(t, o)
                }
            })
        }

        function sendLocationToServer(e, t) {
            let o = document.querySelector('meta[name="csrf-token"]');
            if (!o) {
                showGeolocationError("CSRF token not found. Please contact administrator.");
                return
            }
            console.log(`Sending to server: Lat ${e}, Lng ${t}`), fetch('{{ route('absens.calculateDistance') }}', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": o.getAttribute("content")
                },
                body: JSON.stringify({
                    latitude: e,
                    longitude: t
                })
            }).then(e => {
                if (!e.ok) throw Error(`Server responded with status: ${e.status}`);
                return e.json()
            }).then(o => {
                console.log("Closest Location:", o.closest_lokasi), console.log("Distance:", o.distance, "meters"),
                    document.getElementById("latitude").value = e, document.getElementById("longitude").value = t,
                    o && o.closest_lokasi && o.distance <= 500 ? (document.getElementById("lokasi_kerja").value = o
                        .closest_lokasi.id, document.getElementById("lokasi_nama").value = o.closest_lokasi.nama,
                        updateLocationText(o.closest_lokasi.nama)) : (resetToLoading(), Swal.fire({
                        title: "Location Notice",
                        html: `
                    <p>You are not within range of any registered work location.</p>
                    <p><strong>Your current location:</strong><br>
                    Latitude: ${e}<br>
                    Longitude: ${t}</p>
                    <p>Distance to nearest location: ${(o.distance/1e3).toFixed(2)} km</p>
                `,
                        icon: "warning",
                        confirmButtonText: "OK"
                    }))
            }).catch(e => {
                console.error("Error calculating distance:", e), Swal.fire({
                    title: "Server Error",
                    text: "Could not calculate distance to work locations. Please try again or contact administrator.",
                    icon: "error",
                    confirmButtonText: "OK"
                }), resetToLoading()
            })
        }

        function showGeolocationError(e) {
            console.error(e), Swal.fire({
                title: "Geolocation Error",
                text: e,
                icon: "error",
                confirmButtonText: "OK"
            }), resetToLoading()
        }

        function validateTimeLocation(e) {
            let t = new Date;
            t.setTime(t.getTime() + 252e5);
            let o = t.getUTCHours(),
                n = !1,
                a = !1,
                i = null,
                l = 1 / 0;
            console.log("Hours: " + o), o >= 7 && o <= 17 && 1 == e ? a = !0 : o >= 17 && 0 == e && (a = !0);
            let r = Number(document.getElementById("latitude").value),
                c = Number(document.getElementById("longitude").value),
                s = document.querySelectorAll(".work-location");
            if (isNaN(r) || isNaN(c)) return Swal.fire({
                title: "Location Error!",
                text: "Could not retrieve your location. Please allow GPS access.",
                icon: "error",
                confirmButtonText: "OK"
            }), !1;
            if (s.forEach(e => {
                    let t = Number(e.dataset.lat),
                        o = Number(e.dataset.lng),
                        a = e.dataset.id,
                        s = e.dataset.nama;
                    if (!isNaN(t) && !isNaN(o)) {
                        let u = haversineDistance(r, c, t, o);
                        console.log(` From Validate. Distance to work location: ${u.toFixed(2)} km`), u <= 1 && u < l &&
                            (n = !0, i = {
                                id: a,
                                nama: s,
                                distance: u
                            }, l = u)
                    }
                }), console.log("Location: " + n), console.log("Time: " + a), a && n) {
                document.getElementById("lokasi_nama").value = i.nama;
                submitAbsen(e, t, i.id)
            } else !a && n ? Swal.fire({
                title: "Error!",
                text: "You are not in a valid time to check in/out.",
                icon: "error",
                confirmButtonText: "OK"
            }) : a && !n ? Swal.fire({
                title: "Out of Range!",
                text: "You are not within any valid work location.",
                icon: "error",
                confirmButtonText: "OK"
            }) : Swal.fire({
                title: "Error!",
                text: "Something went wrong.",
                icon: "error",
                confirmButtonText: "OK"
            });
            n = !1, a = !1
        }

        function submitAbsen(e, t, o) {
            let n = t.toISOString().slice(0, 19).replace("T", " ");
            document.getElementById("lokasi_kerja").value = o, document.getElementById("waktu").value = n, document
                .getElementById("absen_pulang").value = e, document.getElementById("absen-form").submit()
        }
        document.addEventListener("DOMContentLoaded", function() {
            updateLocation();
            let e = document.querySelectorAll(".card-header"),
                t = null;
            for (let o of e)
                if (o.textContent.includes("Lokasi")) {
                    t = o.closest(".card");
                    break
                } if (t) {
                let n = document.createElement("div");
                n.className = "mt-3 d-flex justify-content-center gap-2";
                let a = document.createElement("button");
                a.className = "btn btn-sm btn-outline-primary", a.innerHTML =
                    '<i class="fas fa-sync-alt mr-1"></i> Refresh', a.onclick = function() {
                        return updateLocation(), !1
                    };
                let i = document.createElement("button");
                i.className = "btn btn-sm btn-outline-secondary", i.innerHTML =
                    '<i class="fas fa-edit mr-1"></i> Enter Manually', i.onclick = function() {
                        return offerManualLocationEntry(), !1
                    }, n.appendChild(a), n.appendChild(i);
                let l = t.querySelector(".card-body") || t.querySelector(".text-center");
                l && l.appendChild(n);
                let r = document.createElement("div");
                r.id = "location-accuracy", r.className = "small text-muted mt-2 d-none", l && l.appendChild(r)
            }
        });
    </script>
@endpush
