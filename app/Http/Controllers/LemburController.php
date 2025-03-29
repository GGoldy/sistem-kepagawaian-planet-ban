<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Lembur;

class LemburController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->only(['update', 'destroy', 'edit', 'data', 'getDataAll', 'approvalHCM', 'signApprovalHCM']);
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
    public function getDataSelf(Request $request)
    {
        $karyawanID = $request->karyawan_id;
        $lemburs = Lembur::with(['karyawan', 'atasan'])->where('karyawan_id', $karyawanID);

        if ($request->ajax()) {
            return datatables()->of($lemburs)
                ->addIndexColumn()
                ->addColumn('actions', function ($lembur) {
                    return view('lembur.actionsrestricted', compact('lembur'));
                })
                ->toJson();
        }
    }
}
