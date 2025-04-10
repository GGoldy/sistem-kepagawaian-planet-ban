<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Karyawan;
use App\Models\Absen;
use App\Models\LokasiKerja;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Location\Coordinate;
use Location\Distance\Vincenty;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensExport;

class AbsenController extends Controller
{
    public function __construct()
    {
        // Apply 'role:admin' middleware to all routes except 'show', 'index', and 'store'
        $this->middleware('role:admin')->except(['self', 'getDataSelf', 'index', 'store', 'calculateDistance']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Absen';

        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        // ])->post(
        //     'https://www.googleapis.com/geolocation/v1/geolocate?key=' . env('GOOGLE_API_KEY'),
        //     (object)[] // Required empty JSON object
        // );

        // $data = $response->json();

        // dd($data);

        $lokasi_kerja = LokasiKerja::all();
        $absens = Absen::all();
        return view('absen.index', [
            'pageTitle' => $pageTitle,
            'lokasi_kerja' => $lokasi_kerja,
            'absens' => $absens,
        ]);
    }

    public function data()
    {
        $pageTitle = 'Data Absen';

        $karyawans = Karyawan::all();
        $absens = Absen::all();
        return view('absen.data', [
            'pageTitle' => $pageTitle,
            'karyawans' => $karyawans,
            'absens' => $absens,
        ]);
    }

    public function self()
    {
        $pageTitle = 'Data Absen';
        return view('absen.dataself', compact('pageTitle'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka',
            'date' => 'Isi :attribute dengan format tanggal yang benar (YYYY-MM-DD)'
        ];

        $validator = Validator::make($request->all(), [
            // 'absen_pulang' => 'required|boolean',
            // 'waktu' => 'required|date_format:Y-m-d H:i:s',
            // 'latitude' => 'required|numeric|between:-90,90',
            // 'longitude' => 'required|numeric|between:-180,180',
            'absen_pulang' => 'required',
            'waktu' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric'
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $inputDate = Carbon::parse($request->waktu)->toDateString();

        $existingCheckIn = Absen::where('karyawan_id', Auth::user()->karyawan_id)
            ->whereDate('waktu', $inputDate)
            ->where('absen_pulang', 1)
            ->exists();

        $existingCheckOut = Absen::where('karyawan_id', Auth::user()->karyawan_id)
            ->whereDate('waktu', $inputDate)
            ->where('absen_pulang', 0)
            ->exists();

        if ($existingCheckIn && $request->absen_pulang == 1) {
            Alert::error('Error', 'You have already checked in today.');
            return redirect()->back();
        }

        if ($existingCheckOut && $request->absen_pulang == 0) {
            Alert::error('Error', 'You have already checked out today.');
            return redirect()->back();
        }


        $absen = new Absen;
        $absen->absen_pulang = $request->absen_pulang;
        $absen->waktu = $request->waktu;
        $absen->lokasi_kerja_id = $request->lokasi_kerja;
        $absen->latitude = $request->latitude;
        $absen->longitude = $request->longitude;
        $absen->karyawan_id = Auth::user()->karyawan_id;
        $absen->save();

        if ($request->absen_pulang == 1) {
            Alert::success('Success', 'You have successfully checked in.');
        } else {
            Alert::success('Success', 'You have successfully checked out.');
        }

        return redirect()->route('absens.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $karyawanID = $id;
        // $pageTitle = 'Data Absen';

        // return view('absen.show', compact('pageTitle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $pageTitle = 'Edit Data Absen';
        $absen = Absen::find($id);
        $karyawans = Karyawan::all();
        $lokasi_kerjas = LokasiKerja::all();

        return view('absen.edit', compact('pageTitle', 'karyawans', 'absen', 'lokasi_kerjas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka',
            'date' => 'Isi :attribute dengan format tanggal yang benar (YYYY-MM-DD)'
        ];
        $validator = Validator::make($request->all(), [
            'absen_pulang' => 'required',
            'waktu' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $absen = Absen::find($id);
        // $karyawan = $absen->karyawan;
        // $lokasi_kerja = $absen->lokasi_kerja;

        if ($absen) {
            $absen->absen_pulang = $request->absen_pulang;
            $absen->waktu = $request->waktu;
            $absen->lokasi_kerja_id = $request->lokasi_kerja;
            $absen->latitude = $request->latitude;
            $absen->longitude = $request->longitude;
            $absen->karyawan_id = $request->karyawan;
            $absen->save();
            Alert::success('Changed Successfully', 'Absen Data Changed Successfully.');
        } else {
            Alert::error('Error', 'Absen Does Not Exist');
        }

        return redirect()->route('absens.data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $absen = Absen::find($id);
        $absen->delete();
        Alert::success('Deleted Successfully', 'Absen Data Deleted Successfully.');
        return redirect()->route('karyawans.index');
    }

    public function getData(Request $request)
    {
        $absens = Absen::with(['karyawan', 'lokasi_kerja']);
        if ($request->ajax()) {
            return datatables()->of($absens)
                ->addIndexColumn()
                ->addColumn('actions', function ($absen) {
                    return view('absen.actions', compact('absen'));
                })
                ->toJson();
        }
    }
    public function getDataSelf(Request $request)
    {
        $karyawanID = $request->karyawan_id;
        $absens = Absen::with(['karyawan', 'lokasi_kerja'])->where('karyawan_id', $karyawanID);

        if ($request->ajax()) {
            return datatables()->of($absens)
                ->addIndexColumn()
                ->toJson();
        }
    }

    public function calculateDistance(Request $request)
    {
        // Get user's latitude and longitude from the request
        $userLatitude = $request->latitude;
        $userLongitude = $request->longitude;

        if (!$userLatitude || !$userLongitude) {
            return response()->json(['error' => 'Latitude and longitude are required'], 400);
        }

        // Convert user location to a coordinate object
        $userCoordinate = new Coordinate($userLatitude, $userLongitude);

        // Get all work locations
        $lokasi_kerja = LokasiKerja::all();

        $calculator = new Vincenty();
        $closestLokasi = null;
        $shortestDistance = PHP_FLOAT_MAX;

        // Loop through each work location to find the closest one
        foreach ($lokasi_kerja as $lokasi) {
            $lokasiCoordinate = new Coordinate($lokasi->latitude, $lokasi->longitude);
            $distance = $calculator->getDistance($userCoordinate, $lokasiCoordinate); // Distance in meters

            if ($distance < $shortestDistance) {
                $shortestDistance = $distance;
                $closestLokasi = $lokasi;
            }
        }

        // Return the closest work location
        return response()->json([
            'closest_lokasi' => $closestLokasi,
            'distance' => $shortestDistance
        ]);
    }

    public function testCalculateDistance(Request $request)
    {
        $coordinate1 = new Coordinate(-7.37777730, 112.64556980);
        $coordinate2 = new Coordinate(-7.31121345, 112.72886485);

        $calculator = new Vincenty();

        // echo $calculator->getDistance($coordinate1, $coordinate2);
    }
    public function exportExcel(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $monthName = $monthNames[(int) $month] ?? $month;

        return Excel::download(new AbsensExport($month, $year), "Rekap_Absen_{$monthName}_{$year}.xlsx");
    }

}
