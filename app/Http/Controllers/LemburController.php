<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Lembur;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LemburController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->only(['update', 'destroy', 'edit', 'data', 'showany', 'getDataAll', 'approvalHCM', 'signApprovalHCM']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Lembur';

        $lemburs = Lembur::all();
        return view('lembur.index', [
            'pageTitle' => $pageTitle,
            'lemburs' => $lemburs,
        ]);
    }

    public function data()
    {
        $pageTitle = 'Data Lembur';

        $karyawans = Karyawan::all();
        $lemburs = Lembur::all();
        return view('lembur.data', [
            'pageTitle' => $pageTitle,
            'karyawans' => $karyawans,
            'lemburs' => $lemburs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Mengajukan Lembur';
        $karyawans = Karyawan::all();
        return view('lembur.create', compact('pageTitle', 'karyawans'));
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
            'atasan' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date',
            'tugas' => 'required',
            'jam_lembur' => 'required|array', // Validate as an array
            'jam_lembur.*' => 'integer'
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $lembur = new Lembur;
        $lembur->karyawan_id = Auth::user()->karyawan_id;
        $lembur->atasan = $request->atasan;
        $lembur->tanggal_pengajuan = Carbon::now()->addHours(7);
        $lembur->status_pengajuan = false;
        $lembur->tanggal_mulai = $request->tanggal_mulai;
        $lembur->tanggal_berakhir = $request->tanggal_berakhir;
        $lembur->jam_lembur = json_encode($request->jam_lembur); // Save array directly
        $lembur->tugas = $request->tugas;
        $lembur->save();

        Alert::success('Success', 'Your form will be processed in time.');

        return redirect()->route('lemburs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pageTitle = 'Form Lembur';

        $lembur = Lembur::with(['karyawan', 'perintahatasan', 'approvedBy', 'approvedByHcm'])->findOrFail($id);

        if (Auth::user()->karyawan_id !== $lembur->karyawan_id) {
            abort(403, 'Unauthorized access.');
        }

        return view('lembur.show', compact('pageTitle', 'lembur'));
    }

    public function showany(string $id)
    {
        $pageTitle = 'Form Lembur';

        $lembur = Lembur::with(['karyawan', 'perintahatasan', 'approvedBy', 'approvedByHcm'])->findOrFail($id);

        return view('lembur.show', compact('pageTitle', 'lembur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = 'Edit Form Lembur';
        $lembur = Lembur::findOrFail($id);
        $karyawans = Karyawan::all();

        $jam_lembur = $lembur->jam_lembur ? json_decode($lembur->jam_lembur, true) : [];

        return view('lembur.edit', compact('pageTitle', 'karyawans', 'lembur', 'jam_lembur'));
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
            'atasan' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date',
            'tugas' => 'required',
            'jam_lembur' => 'required|array', // Validate as an array
            'jam_lembur.*' => 'integer'
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $lembur = Lembur::find($id);

        if ($lembur) {
            $lembur->atasan = $request->atasan;
            $lembur->tanggal_mulai = $request->tanggal_mulai;
            $lembur->tanggal_berakhir = $request->tanggal_berakhir;
            $lembur->jam_lembur = json_encode($request->jam_lembur); // Save array directly
            $lembur->tugas = $request->tugas;
            $lembur->save();
            Alert::success('Success', 'The form has been successfully edited.');
        } else {
            Alert::error('Error', 'Form Does Not Exist');
        }

        return redirect()->route('lemburs.data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lembur = Lembur::find($id);
        $lembur->delete();
        Alert::success('Deleted Successfully', 'Lembur Form Deleted Successfully.');
        return redirect()->route('lemburs.data');
    }
    public function getDataSelf(Request $request)
    {
        $karyawanID = $request->karyawan_id;
        $lemburs = Lembur::with(['karyawan', 'perintahatasan'])->where('karyawan_id', $karyawanID);

        if ($request->ajax()) {
            return datatables()->of($lemburs)
                ->addIndexColumn()
                ->addColumn('actions', function ($lembur) {
                    return view('lembur.actionsrestricted', compact('lembur'));
                })
                ->toJson();
        }
    }
    public function getDataAll(Request $request)
    {
        $lemburs = Lembur::with(['karyawan', 'perintahatasan']);
        if ($request->ajax()) {
            return datatables()->of($lemburs)
                ->addIndexColumn()
                ->addColumn('actions', function ($lembur) {
                    return view('lembur.actions', compact('lembur'));
                })
                ->toJson();
        }
    }
}
