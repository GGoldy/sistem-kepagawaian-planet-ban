<?php

namespace App\Http\Controllers;

use App\Models\Ketidakhadiran;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class KetidakhadiranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Ketidakhadiran';

        $ketidakhadirans = Ketidakhadiran::all();
        return view('ketidakhadiran.index', [
            'pageTitle' => $pageTitle,
            'ketidakhadirans' => $ketidakhadirans,
        ]);
    }

    public function data()
    {
        $pageTitle = 'Data Ketidakhadiran';

        $karyawans = Karyawan::all();
        $ketidakhadirans = Ketidakhadiran::all();
        return view('ketidakhadiran.data', [
            'pageTitle' => $pageTitle,
            'karyawans' => $karyawans,
            'ketidakhadirans' => $ketidakhadirans,
        ]);
    }

    public function approve() {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Mengajukan Ketidakhadiran';
        return view('ketidakhadiran.create', compact('pageTitle'));
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
            'jenis_ketidakhadiran' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date',
            'tujuan' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ketidakhadiran = new Ketidakhadiran;
        $ketidakhadiran->karyawan_id = Auth::user()->karyawan_id;
        $ketidakhadiran->tanggal_pengajuan = Carbon::now()->addHours(7);
        $ketidakhadiran->status_pengajuan = false;
        $ketidakhadiran->jenis_ketidakhadiran = $request->jenis_ketidakhadiran;
        $ketidakhadiran->tanggal_mulai = $request->tanggal_mulai;
        $ketidakhadiran->tanggal_berakhir = $request->tanggal_berakhir;
        $ketidakhadiran->tujuan = $request->tujuan;
        $ketidakhadiran->catatan = $request->catatan;
        $ketidakhadiran->approved_by = null;
        $ketidakhadiran->tanggal_sah = null;
        $ketidakhadiran->tanggal_aktif = null;
        $ketidakhadiran->save();

        Alert::success('Success', 'Your form will be processed in time.');

        return redirect()->route('ketidakhadirans.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pageTitle = 'Form Ketidakhadiran';

        $ketidakhadiran = Ketidakhadiran::with(['karyawan'])->findOrFail($id);

        return view('ketidakhadiran.show', compact('pageTitle', 'ketidakhadiran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = 'Edit Data Absen';
        $ketidakhadiran = Ketidakhadiran::find($id);
        $karyawans = Karyawan::all();

        return view('ketidakhadiran.edit', compact('pageTitle', 'karyawans', 'ketidakhadiran'));
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
            'jenis_ketidakhadiran' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date',
            'tujuan' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ketidakhadiran = Ketidakhadiran::find($id);
        $ketidakhadiran->delete();
        Alert::success('Deleted Successfully', 'Karyawan Data Deleted Successfully.');
        return redirect()->route('ketidakhadirans.index');
    }

    public function getDataSelf(Request $request)
    {
        $karyawanID = $request->karyawan_id;
        $ketidakhadirans = Ketidakhadiran::with(['karyawan', 'approved_by'])->where('karyawan_id', $karyawanID);
        // $ketidakhadirans = Ketidakhadiran::all();
        if ($request->ajax()) {
            return datatables()->of($ketidakhadirans)
                ->addIndexColumn()
                ->addColumn('actions', function ($ketidakhadiran) {
                    return view('ketidakhadiran.actionsrestricted', compact('ketidakhadiran'));
                })
                ->toJson();
        }
    }
    public function getDataAll(Request $request)
    {
        $ketidakhadirans = Ketidakhadiran::with(['karyawan', 'approved_by']);
        if ($request->ajax()) {
            return datatables()->of($ketidakhadirans)
                ->addIndexColumn()
                ->addColumn('actions', function ($ketidakhadiran) {
                    return view('ketidakhadiran.actions', compact('ketidakhadiran'));
                })
                ->toJson();
        }
    }
}
