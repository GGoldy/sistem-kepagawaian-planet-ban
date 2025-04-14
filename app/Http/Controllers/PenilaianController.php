<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PenilaiansExport;
use App\Exports\RekapPenilaianExport;

class PenilaianController extends Controller
{
    public function __construct()
    {
        // Apply 'role:admin' middleware to all routes except 'show'
        $this->middleware('role:admin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Daftar Penilaian';

        return view('penilaian.index', [
            'pageTitle' => $pageTitle
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Form Penilaian';
        $karyawans = Karyawan::all();
        return view('penilaian.create', compact('pageTitle', 'karyawans'));
    }

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
            'karyawan' => 'required',
            'bulan_penilaian' => 'required',
            'tahun_penilaian' => 'required',
            'kinerja' => 'required',
            'kehadiran' => 'required',
            'kerjasama_tim' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $exists = Penilaian::where('karyawan_id', $request->karyawan)
            ->where('bulan_penilaian', $request->bulan_penilaian)
            ->where('tahun_penilaian', $request->tahun_penilaian)
            ->exists();

        if ($exists) {
            Alert::error('Error', 'Data Penilaian Karyawan dalam periode ini sudah ada.');
            return redirect()->back()->withInput();
        }

        $penilaian = new Penilaian();
        $penilaian->karyawan_id = $request->karyawan;
        $penilaian->penilai_id = Auth::user()->karyawan_id;
        $penilaian->bulan_penilaian = $request->bulan_penilaian;
        $penilaian->tahun_penilaian = $request->tahun_penilaian;
        $penilaian->kinerja = $request->kinerja;
        $penilaian->kehadiran = $request->kehadiran;
        $penilaian->kerjasama_tim = $request->kerjasama_tim;
        $penilaian->save();

        Alert::success('Added Successfully', 'Penilaian Data Added Successfully.');

        return redirect()->route('penilaians.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pageTitle = 'Detail Penilaian Karyawan';

        $penilaian = Penilaian::with(['karyawan', 'penilai'])->findOrFail($id);

        return view('penilaian.show', compact('pageTitle', 'penilaian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = 'Mengubah Data Penilaian Karyawan';
        $penilaian = Penilaian::find($id);
        $karyawan = Karyawan::find($penilaian->karyawan_id);
        $penilai = Karyawan::find($penilaian->penilai_id);

        return view('penilaian.edit', compact('pageTitle', 'penilaian'));
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
            'bulan_penilaian' => 'required',
            'tahun_penilaian' => 'required|numeric',
            'kinerja' => 'required',
            'kehadiran' => 'required',
            'kerjasama_tim' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $penilaian = Penilaian::find($id);

        if ($penilaian) {
            $penilaian->bulan_penilaian = $request->bulan_penilaian;
            $penilaian->tahun_penilaian = $request->tahun_penilaian;
            $penilaian->kinerja = $request->kinerja;
            $penilaian->kehadiran = $request->kehadiran;
            $penilaian->kerjasama_tim = $request->kerjasama_tim;
            $penilaian->save();

            Alert::success('Changed Successfully', 'Penilaian Data Changed Successfully.');
        } else {
            Alert::error('Error', 'Penilaian Data Does Not Exist');
        }

        return redirect()->route('penilaians.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penilaian = Penilaian::find($id);
        $penilaian->delete();
        Alert::success('Deleted Successfully', 'Penilaian Data Deleted Successfully.');
        return redirect()->route('penilaians.index');
    }

    public function getData(Request $request)
    {
        $penilaians = Penilaian::with(['karyawan', 'penilai'])->select([
            'penilaians.*',
            DB::raw("CONCAT(bulan_penilaian, ' ', tahun_penilaian) as tanggal_penilaian")
        ]);

        if ($request->ajax()) {
            return datatables()->of($penilaians)
                ->addIndexColumn()
                ->addColumn('actions', function ($penilaian) {
                    return view('penilaian.actions', compact('penilaian'));
                })
                ->filterColumn('tanggal_penilaian', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(bulan_penilaian, ' ', tahun_penilaian) LIKE ?", ["%{$keyword}%"]);
                })
                ->orderColumn('tahun_penilaian', function ($query, $order) {
                    $query->orderBy('tahun_penilaian', $order);
                })
                ->toJson();
        }
    }
    public function exportExcel()
    {
        return Excel::download(new PenilaiansExport, 'penilaian_all.xlsx');
    }
    public function rekapExportExcel()
    {
        return Excel::download(new RekapPenilaianExport, 'rekap_penilaian_all.xlsx');
    }
}
