<?php

namespace App\Http\Controllers;

use App\Models\Ketidakhadiran;
use App\Models\Karyawan;
use Illuminate\Http\Request;

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

    public function approve()
    {

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
