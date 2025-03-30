<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ketidakhadiran;
use App\Models\Karyawan;
use App\Models\Lembur;
use App\Models\Absen;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GajiController extends Controller
{
    public function index()
    {
        $pageTitle = 'Gaji';

        $ketidakhadirans = Ketidakhadiran::where('karyawan_id', Auth::user()->karyawan->id)->get();
        $lemburs = Lembur::where('karyawan_id', Auth::user()->karyawan->id)->get();
        $absens = Absen::where('karyawan_id', Auth::user()->karyawan->id)->get();
        $karyawan = Karyawan::where('id', Auth::user()->karyawan->id)->get();

        return view('gaji.index', [
            'pageTitle' => $pageTitle,
            'ketidakhadirans' => $ketidakhadirans,
            'lemburs' => $lemburs,
            'absens' => $absens,
            'karyawan' => $karyawan,
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

        return response()->json([
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
        ]);
    }
}
