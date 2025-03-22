<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Absen;
use App\Models\LokasiKerja;
use RealRashid\SweetAlert\Facades\Alert;


class LokasiKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Lokasi Kerja';

        $lokasi_kerjas = LokasiKerja::all();
        $absens = Absen::all();
        return view('lokasikerja.index', [
            'pageTitle' => $pageTitle,
            'lokasi_kerjas' => $lokasi_kerjas,
            'absens' => $absens,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Create Lokasi Kerja';
        return view('lokasikerja.create', compact('pageTitle'));
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
            'date' => 'Isi :attribute dengan format tanggal yang benar (YYYY-MM-DD)',
            'between:-90,90' => 'Isi :attribute dengan nilai angka diantara -90,90 desimal',
            'between:-180,180' => 'Isi :attribute dengan nilai angka diantara -180,180 desimal'
        ];

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $lokasi_kerja = new LokasiKerja;
        $lokasi_kerja->nama = $request->nama;
        $lokasi_kerja->latitude = $request->latitude;
        $lokasi_kerja->longitude = $request->longitude;
        $lokasi_kerja->save();

        Alert::success('Added Successfully', 'Lokasi Kerja Data Added Successfully.');

        return redirect()->route('lokasikerjas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pageTitle = 'Lokasi Kerja Details';
        $lokasi_kerja = LokasiKerja::find($id);

        return view('lokasikerja.show', compact('pageTitle', 'lokasi_kerja'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $pageTitle = 'Lokasi Kerja Edit';
        $lokasi_kerja = LokasiKerja::find($id);

        return view('lokasikerja.edit', compact('pageTitle', 'lokasi_kerja'));
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
            'nama' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $lokasi_kerja = LokasiKerja::find($id);

        if ($lokasi_kerja) {
            $lokasi_kerja->nama = $request->nama;
            $lokasi_kerja->latitude = $request->latitude;
            $lokasi_kerja->longitude = $request->longitude;
            $lokasi_kerja->save();
            Alert::success('Changed Successfully', 'Lokasi Kerja Changed Successfully.');
        } else {
            Alert::error('Error', 'Lokasi Kerja Does Not Exist');
        }

        return redirect()->route('lokasikerjas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lokasi_kerja = LokasiKerja::find($id);
        $lokasi_kerja->delete();
        Alert::success('Deleted Successfully', 'Lokasi Kerja Deleted Successfully.');
        return redirect()->route('lokasikerjas.index');
    }

    public function getData(Request $request)
    {
        $lokasikerjas = LokasiKerja::all();
        if ($request->ajax()) {
            return datatables()->of($lokasikerjas)
                ->addIndexColumn()
                ->addColumn('actions', function ($lokasi_kerja) {
                    return view('lokasikerja.actions', compact('lokasi_kerja'));
                })
                ->toJson();
        }
    }
}
