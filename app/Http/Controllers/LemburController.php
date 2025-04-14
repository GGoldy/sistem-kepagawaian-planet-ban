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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LembursExport;

class LemburController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->only(['update', 'destroy', 'edit', 'data', 'showany', 'getDataAll', 'approvalHCM', 'signApprovalHCM', 'exportExcel']);
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

    public function approve()
    {
        $pageTitle = 'Penyetujuan Lembur';

        $currentUser = Auth::user();
        $currentUserLevel = $currentUser->karyawan->penugasan->level ?? null;

        if ($currentUserLevel === null) {
            return abort(403, "User does not have a valid level to approve requests.");
        }

        return view('lembur.approve', [
            'pageTitle' => $pageTitle,
        ]);
    }

    public function approval(string $id)
    {
        $pageTitle = 'Form Lembur';

        $lembur = Lembur::with(['karyawan', 'perintahatasan'])->findOrFail($id);

        return view('lembur.approval', compact('pageTitle', 'lembur'));
    }

    public function signApproval(Request $request, string $id)
    {
        $lembur = Lembur::findOrFail($id);

        if ($request->has('signature')) {
            $image = $request->input('signature');
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'signatures/' . uniqid() . '.png';
            Storage::disk('public')->put($imageName, base64_decode($image));
            $lembur->signature = $imageName; // Save the image path to DB
        }

        $lembur->approved_by = Auth::user()->karyawan->id;

        if (!is_null($lembur->approved_by_hcm) && !is_null($lembur->signature_hcm)) {
            $lembur->status_pengajuan = true;
            $lembur->tanggal_sah = Carbon::now()->toDateTimeString(); // Set to today's date
        }
        $lembur->save();

        Alert::success('Approved Successfully', 'Form Has Been Approved Successfully.');

        return redirect()->route('lemburs.approve');
    }

    public function rejectApproval(Request $request, string $id)
    {
        $lembur = Lembur::findOrFail($id);

        $lembur->approved_by = Auth::user()->karyawan->id;

        $lembur->save();

        Alert::success('Rejected Successfully', 'Form Has Been Rejected Successfully.');

        return redirect()->route('lemburs.approve');
    }

    public function approvalHCM(string $id)
    {
        $pageTitle = 'Form Lembur';

        $lembur = Lembur::with(['karyawan', 'perintahatasan'])->findOrFail($id);

        return view('lembur.approvalHCM', compact('pageTitle', 'lembur'));
    }

    public function signApprovalHCM(Request $request, string $id)
    {
        $lembur = Lembur::findOrFail($id);

        if ($request->has('signature')) {
            $image = $request->input('signature');
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'signatures/' . uniqid() . '.png';
            Storage::disk('public')->put($imageName, base64_decode($image));
            $lembur->signature_hcm = $imageName; // Save the image path to DB
        }

        $lembur->approved_by_hcm = Auth::user()->karyawan->id;

        if (!is_null($lembur->approved_by) && !is_null($lembur->signature)) {
            $lembur->status_pengajuan = true;
            $lembur->tanggal_sah = Carbon::now()->toDateTimeString(); // Set to today's date
        }
        $lembur->save();

        Alert::success('Approved Successfully', 'Form Has Been Approved Successfully.');

        return redirect()->route('lemburs.approve');
    }

    public function rejectApprovalHCM(Request $request, string $id)
    {
        $lembur = Lembur::findOrFail($id);

        $lembur->approved_by_hcm = Auth::user()->karyawan->id;

        $lembur->save();

        Alert::success('Rejected Successfully', 'Form Has Been Rejected Successfully.');

        return redirect()->route('lemburs.approve');
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
                ->addColumn('status_pengajuan', function ($lembur) {
                    if ($lembur->approved_by && !$lembur->signature) {
                        return 'Tidak Disetujui';
                    }
                    if ($lembur->approved_by_hcm && !$lembur->signature_hcm) {
                        return 'Tidak Disetujui';
                    }
                    return $lembur->status_pengajuan == 1 ? 'Disetujui' : 'Pending';
                })
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
                ->addColumn('status_pengajuan', function ($lembur) {
                    if ($lembur->approved_by && !$lembur->signature) {
                        return 'Tidak Disetujui';
                    }
                    if ($lembur->approved_by_hcm && !$lembur->signature_hcm) {
                        return 'Tidak Disetujui';
                    }
                    return $lembur->status_pengajuan == 1 ? 'Disetujui' : 'Pending';
                })
                ->addColumn('actions', function ($lembur) {
                    return view('lembur.actions', compact('lembur'));
                })
                ->toJson();
        }
    }
    public function getDataFiltered(Request $request)
    {
        $currentUser = Auth::user();
        $currentUserLevel = $currentUser->karyawan->penugasan->level ?? null;

        if ($currentUserLevel === null) {
            return abort(403, "User does not have a valid level to approve requests.");
        }

        $lemburs = Lembur::whereHas('karyawan.penugasan', function ($query) use ($currentUserLevel) {
            $query->where('level', '<', $currentUserLevel);
        })
            ->whereNull('approved_by')
            ->with(['karyawan', 'perintahatasan']) // Ensure karyawan is loaded
            ->get();

        if ($request->ajax()) {
            return datatables()->of($lemburs)
                ->addIndexColumn()
                ->addColumn('actions', function ($lembur) {
                    return view('lembur.actionsapproval', compact('lembur'));
                })
                ->toJson();
        }
    }
    public function getDataAllFiltered(Request $request)
    {
        $lemburs = Lembur::whereNull('approved_by_hcm')->with(['karyawan', 'perintahatasan'])->get();

        if ($request->ajax()) {
            return datatables()->of($lemburs)
                ->addIndexColumn()
                ->addColumn('actions', function ($lembur) {
                    return view('lembur.actionsapprovalhcm', compact('lembur'));
                })
                ->toJson();
        }
    }
    public function exportExcel()
    {
        return Excel::download(new LembursExport, 'lembur_all.xlsx');
    }
    public function selfExportExcel()
    {
        return Excel::download(new LembursExport(auth()->user()->karyawan_id), 'lembur_self.xlsx');
    }
}
