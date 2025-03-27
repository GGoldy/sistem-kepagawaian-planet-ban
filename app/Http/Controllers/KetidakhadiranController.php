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
    public function __construct()
    {
        // Apply 'role:admin' middleware to all routes except 'show', 'index', and 'store'
        $this->middleware('role:admin')->except(['create', 'index', 'store', 'approve', 'getDataSelf']);
    }
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

    public function approve()
    {
        $pageTitle = 'Penyetujuan Ketidakhadiran';

        $currentUser = Auth::user();
        $currentUserLevel = $currentUser->karyawan->penugasan->level ?? null;

        if ($currentUserLevel === null) {
            return abort(403, "User does not have a valid level to approve requests.");
        }

        // Get only Ketidakhadiran where the Karyawan's level is lower
        $ketidakhadirans = Ketidakhadiran::whereHas('karyawan.penugasan', function ($query) use ($currentUserLevel) {
            $query->where('level', '<', $currentUserLevel);
        })->get();

        $karyawans = Karyawan::all();
        $all = Ketidakhadiran::all();
        return view('ketidakhadiran.approve', [
            'pageTitle' => $pageTitle,
            'karyawans' => $karyawans,
            'ketidakhadirans' => $ketidakhadirans,
            'all' => $all,
        ]);
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
            'tanggal_pengganti' => 'array', // Ensure it's an array
            'tanggal_pengganti.*' => 'date', // Validate each date
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

        if ($request->tanggal_pengganti) {
            $ketidakhadiran->tanggal_pengganti = json_encode($request->tanggal_pengganti);
        } else {
            $ketidakhadiran->tanggal_pengganti = null;
        }

        $ketidakhadiran->tujuan = $request->tujuan;
        $ketidakhadiran->catatan = $request->catatan;
        $ketidakhadiran->approved_by = null;
        $ketidakhadiran->approved_by_hcm = null;
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
        $ketidakhadiran = Ketidakhadiran::findOrFail($id);
        $karyawans = Karyawan::all();

        // Ensure tanggal_pengganti is always an array
        $tanggal_pengganti = $ketidakhadiran->tanggal_pengganti ? json_decode($ketidakhadiran->tanggal_pengganti, true) : [];

        return view('ketidakhadiran.edit', compact('pageTitle', 'karyawans', 'ketidakhadiran', 'tanggal_pengganti'));
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
            'tanggal_pengganti' => 'array', // Ensure it's an array
            'tanggal_pengganti.*' => 'date', // Validate each date
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ketidakhadiran = Ketidakhadiran::find($id);

        if ($ketidakhadiran) {
            $ketidakhadiran->status_pengajuan = (bool) $request->status_pengajuan;
            $ketidakhadiran->jenis_ketidakhadiran = $request->jenis_ketidakhadiran;
            $ketidakhadiran->tanggal_mulai = $request->tanggal_mulai;
            $ketidakhadiran->tanggal_berakhir = $request->tanggal_berakhir;
            if ($request->tanggal_pengganti) {
                $ketidakhadiran->tanggal_pengganti = json_encode($request->tanggal_pengganti);
            } else {
                $ketidakhadiran->tanggal_pengganti = null;
            }
            $ketidakhadiran->tujuan = $request->tujuan;
            $ketidakhadiran->catatan = $request->catatan;
            $ketidakhadiran->approved_by = $request->approved_by;
            $ketidakhadiran->approved_by_hcm = $request->approved_by_hcm;
            $ketidakhadiran->tanggal_sah = $request->tanggal_sah;
            $ketidakhadiran->tanggal_aktif = $request->tanggal_aktif;
            $ketidakhadiran->save();

            Alert::success('Success', 'The form has been successfully edited.');
        } else {
            Alert::error('Error', 'Form Does Not Exist');
        }

        return redirect()->route('ketidakhadirans.data');
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
