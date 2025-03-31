<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ketidakhadiran;
use App\Models\Karyawan;
use App\Models\Lembur;
use App\Models\Absen;
use App\Models\Gaji;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class LaporanController extends Controller
{
    public function __construct()
    {
        // Apply 'role:admin' middleware to all routes except 'show'
        $this->middleware('role:admin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageTitle = 'Laporan';

        $ketidakhadirans = Ketidakhadiran::where('karyawan_id', Auth::user()->karyawan->id)->get();

        $absens = Absen::where('karyawan_id', Auth::user()->karyawan->id)->get();
        $gaji = Gaji::where('karyawan_id', Auth::user()->karyawan->id)->first();
        $karyawan = Karyawan::where('id', Auth::user()->karyawan->id)->get();
        $karyawans = Karyawan::all();

        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        $lemburs = Lembur::whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->where('karyawan_id', Auth::user()->karyawan->id)
            ->get();

        // dd($gaji, $lemburs);

        return view('laporan.index', [
            'pageTitle' => $pageTitle,
            'ketidakhadirans' => $ketidakhadirans,
            'lemburs' => $lemburs,
            'absens' => $absens,
            'karyawan' => $karyawan,
            'karyawans' => $karyawans,
            'gaji' => $gaji,
        ]);
    }

    public function getFilteredData(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        $karyawan_id = $request->input('karyawan_id');

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $ketidakhadirans = Ketidakhadiran::whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->where('karyawan_id', $karyawan_id)
            ->get();

        $absens = Absen::whereBetween('created_at', [$startDate, $endDate])
            ->where('karyawan_id', $karyawan_id)
            ->get();

        $lemburs = Lembur::whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->where('karyawan_id', $karyawan_id)
            ->get();

        $gaji = Gaji::where('karyawan_id', $karyawan_id)->first();

        $karyawan = Karyawan::where('id', $karyawan_id)->first();

        return response()->json([
            'karyawanNama' => $karyawan->nama,
            'karyawanNik' => $karyawan->nik,
            'ketidakhadirans' => $ketidakhadirans,
            'absens' => $absens,
            'lemburs' => $lemburs,
            'totalJamLembur' => $lemburs->sum(fn($lembur) => collect(json_decode($lembur->jam_lembur, true))->sum()),

            // Count different Ketidakhadiran types
            'sakitCount' => $ketidakhadirans->where('jenis_ketidakhadiran', 'Sakit')->count(),
            'cutiCount' => $ketidakhadirans->where('jenis_ketidakhadiran', 'Cuti')->count(),
            'penggantianHariCount' => $ketidakhadirans->where('jenis_ketidakhadiran', 'Penggantian Hari')->count(),
            'falseSakitCount' => $ketidakhadirans->where('jenis_ketidakhadiran', 'Sakit')->whereNull('approved_by_hcm')->count(),
            'falseCutiCount' => $ketidakhadirans->where('jenis_ketidakhadiran', 'Cuti')->whereNull('approved_by_hcm')->count(),
            'falsePenggantianHariCount' => $ketidakhadirans->where('jenis_ketidakhadiran', 'Penggantian Hari')->whereNull('approved_by_hcm')->count(),
            'lemburCount' => $lemburs->count(),
            'falseLemburCount' => $lemburs->whereNull('approved_by_hcm')->count(),

            // Count Absen types
            'absenCount' => $absens->where('absen_pulang', true)->count(),
            'pulangCount' => $absens->where('absen_pulang', false)->count(),

            'uangMakan' => $gaji->uang_makan,
            'gajiPokok' => $gaji->gaji_pokok,
            'tunjanganBpjs' => $gaji->tunjangan_bpjs,
            'approvedLemburs' => $lemburs->whereNotNull('approved_by_hcm'),
            'totalApprovedJamLembur' => $lemburs
                ->whereNotNull('approved_by_hcm')
                ->sum(fn($lembur) => collect(json_decode($lembur->jam_lembur, true))->sum()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
