<?php

namespace App\Http\Controllers;

use App\Models\Ketidakhadiran;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KetidakhadiransExport;

class KetidakhadiranController extends Controller
{
    public function __construct()
    {
        // Apply 'role:admin' middleware to all routes except 'show', 'index', and 'store'
        $this->middleware('role:admin')->only(['update', 'destroy', 'edit', 'data', 'showany', 'getDataAll', 'approvalHCM', 'signApprovalHCM', 'exportExcel']);
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
        })
            ->where('status_pengajuan', false) // Filter only where status_pengajuan is false
            ->with(['karyawan']) // Ensure karyawan is loaded
            ->get();


        $karyawans = Karyawan::all();
        $all = Ketidakhadiran::where('status_pengajuan', false)->with(['karyawan'])->get();
        return view('ketidakhadiran.approve', [
            'pageTitle' => $pageTitle,
            'karyawans' => $karyawans,
            'ketidakhadirans' => $ketidakhadirans,
            'all' => $all,
        ]);
    }

    public function approval(string $id)
    {
        $pageTitle = 'Form Ketidakhadiran';

        $ketidakhadiran = Ketidakhadiran::with(['karyawan'])->findOrFail($id);

        return view('ketidakhadiran.approval', compact('pageTitle', 'ketidakhadiran'));
    }

    public function signApproval(Request $request, string $id)
    {
        $ketidakhadiran = Ketidakhadiran::findOrFail($id);

        if ($request->has('signature')) {
            $image = $request->input('signature');
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'signatures/' . uniqid() . '.png';
            Storage::disk('public')->put($imageName, base64_decode($image));
            $ketidakhadiran->signature = $imageName; // Save the image path to DB
        }

        $ketidakhadiran->approved_by = Auth::user()->karyawan->id;

        if (!is_null($ketidakhadiran->approved_by_hcm) && !is_null($ketidakhadiran->signature_hcm)) {
            $ketidakhadiran->status_pengajuan = true;
            $ketidakhadiran->tanggal_sah = Carbon::now()->toDateString(); // Set to today's date
            $ketidakhadiran->tanggal_aktif = Carbon::now()->toDateString(); // Set to today's date
        }
        $ketidakhadiran->save();

        Alert::success('Approved Successfully', 'Form Has Been Approved Successfully.');

        return redirect()->route('ketidakhadirans.approve');
    }

    public function rejectApproval(Request $request, string $id)
    {
        $ketidakhadiran = Ketidakhadiran::findOrFail($id);

        $ketidakhadiran->approved_by = Auth::user()->karyawan->id;

        $ketidakhadiran->save();

        Alert::success('Rejected Successfully', 'Form Has Been Rejected Successfully.');

        return redirect()->route('ketidakhadirans.approve');
    }

    public function approvalHCM(string $id)
    {
        $pageTitle = 'Form Ketidakhadiran';

        $ketidakhadiran = Ketidakhadiran::with(['karyawan'])->findOrFail($id);

        return view('ketidakhadiran.approvalHCM', compact('pageTitle', 'ketidakhadiran'));
    }

    public function signApprovalHCM(Request $request, string $id)
    {
        $ketidakhadiran = Ketidakhadiran::findOrFail($id);

        if ($request->has('signature')) {
            $image = $request->input('signature');
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'signatures/' . uniqid() . '.png';
            Storage::disk('public')->put($imageName, base64_decode($image));
            $ketidakhadiran->signature_hcm = $imageName; // Save the image path to DB
        }

        $ketidakhadiran->approved_by_hcm = Auth::user()->karyawan->id;
        if (!is_null($ketidakhadiran->approved_by) && !is_null($ketidakhadiran->signature)) {
            $ketidakhadiran->status_pengajuan = true;
            $ketidakhadiran->tanggal_sah = Carbon::now()->toDateString(); // Set to today's date
            $ketidakhadiran->tanggal_aktif = Carbon::now()->toDateString(); // Set to today's date
        }
        $ketidakhadiran->save();

        Alert::success('Approved Successfully', 'Form Has Been Approved Successfully.');

        return redirect()->route('ketidakhadirans.approve');
    }

    public function rejectApprovalHCM(Request $request, string $id)
    {
        $ketidakhadiran = Ketidakhadiran::findOrFail($id);

        $ketidakhadiran->approved_by_hcm = Auth::user()->karyawan->id;

        $ketidakhadiran->save();

        Alert::success('Rejected Successfully', 'Form Has Been Rejected Successfully.');

        return redirect()->route('ketidakhadirans.approve');
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

        $ketidakhadiran = Ketidakhadiran::with(['karyawan', 'approvedBy', 'approvedByHcm'])->findOrFail($id);

        if (Auth::user()->karyawan_id !== $ketidakhadiran->karyawan_id) {
            abort(403, 'Unauthorized access.');
        }

        return view('ketidakhadiran.show', compact('pageTitle', 'ketidakhadiran'));
    }

    public function showany(string $id)
    {
        $pageTitle = 'Form Ketidakhadiran';

        $ketidakhadiran = Ketidakhadiran::with(['karyawan', 'approvedBy', 'approvedByHcm'])->findOrFail($id);

        return view('ketidakhadiran.show', compact('pageTitle', 'ketidakhadiran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = 'Edit Form Ketidakhadiran';
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
        $ketidakhadirans = Ketidakhadiran::with(['karyawan', 'approvedBy'])
            ->where('karyawan_id', $karyawanID)
            ->get();

        // $ketidakhadirans = Ketidakhadiran::all();
        if ($request->ajax()) {
            return datatables()->of($ketidakhadirans)
                ->addIndexColumn()
                ->addColumn('status_pengajuan', function ($ketidakhadiran) {
                    if ($ketidakhadiran->approved_by && !$ketidakhadiran->signature) {
                        return 'Tidak Disetujui';
                    }
                    if ($ketidakhadiran->approved_by_hcm && !$ketidakhadiran->signature_hcm) {
                        return 'Tidak Disetujui';
                    }
                    return $ketidakhadiran->status_pengajuan == 1 ? 'Disetujui' : 'Pending';
                })
                ->addColumn('actions', function ($ketidakhadiran) {
                    return view('ketidakhadiran.actionsrestricted', compact('ketidakhadiran'));
                })
                ->toJson();
        }
    }
    public function getDataAll(Request $request)
    {
        $ketidakhadirans = Ketidakhadiran::with(['karyawan', 'approvedBy']);
        if ($request->ajax()) {
            return datatables()->of($ketidakhadirans)
                ->addIndexColumn()
                ->addColumn('status_pengajuan', function ($ketidakhadiran) {
                    if ($ketidakhadiran->approved_by && !$ketidakhadiran->signature) {
                        return 'Tidak Disetujui';
                    }
                    if ($ketidakhadiran->approved_by_hcm && !$ketidakhadiran->signature_hcm) {
                        return 'Tidak Disetujui';
                    }
                    return $ketidakhadiran->status_pengajuan == 1 ? 'Disetujui' : 'Pending';
                })
                ->addColumn('actions', function ($ketidakhadiran) {
                    return view('ketidakhadiran.actions', compact('ketidakhadiran'));
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

        // Get only Ketidakhadiran where the Karyawan's level is lower
        $ketidakhadirans = Ketidakhadiran::whereHas('karyawan.penugasan', function ($query) use ($currentUserLevel) {
            $query->where('level', '<', $currentUserLevel);
        })
            ->whereNull('approved_by')
            ->with(['karyawan']) // Ensure karyawan is loaded
            ->get();

        if ($request->ajax()) {
            return datatables()->of($ketidakhadirans)
                ->addIndexColumn()
                ->addColumn('actions', function ($ketidakhadiran) {
                    return view('ketidakhadiran.actionsapproval', compact('ketidakhadiran'));
                })
                ->toJson();
        }
    }
    public function getDataAllFiltered(Request $request)
    {

        $ketidakhadirans = Ketidakhadiran::whereNull('approved_by_hcm')->with(['karyawan'])->get();

        if ($request->ajax()) {
            return datatables()->of($ketidakhadirans)
                ->addIndexColumn()
                ->addColumn('actions', function ($ketidakhadiran) {
                    return view('ketidakhadiran.actionsapprovalhcm', compact('ketidakhadiran'));
                })
                ->toJson();
        }
    }
    public function exportExcel()
    {
        return Excel::download(new KetidakhadiransExport, 'ketidakhadiran_all.xlsx');
    }
    public function selfExportExcel()
    {
        return Excel::download(new KetidakhadiransExport(auth()->user()->karyawan_id), 'ketidakhadiran_self.xlsx');
    }
}
