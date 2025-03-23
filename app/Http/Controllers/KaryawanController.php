<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\StatusPegawai;
use App\Models\Penugasan;
use App\Models\Gaji;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Daftar Karyawan';

        confirmDelete();

        $karyawans = Karyawan::all();
        return view('karyawan.index', [
            'pageTitle' => $pageTitle,
            'karyawans' => $karyawans
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Tambah Karyawan';
        return view('karyawan.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'tunjangan_bpjs' => str_replace('.', '', $request->tunjangan_bpjs),
            'uang_makan' => str_replace('.', '', $request->uang_makan),
            'gaji_pokok' => str_replace('.', '', $request->gaji_pokok),
        ]);

        $messages = [
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka',
            'date' => 'Isi :attribute dengan format tanggal yang benar (YYYY-MM-DD)'
        ];
        $validator = Validator::make($request->all(), [
            'jabatan' => 'required',
            'nik' => 'required|numeric',
            'nama' => 'required',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'status_pernikahan' => 'required',
            'agama' => 'required',
            'pendidikan_terakhir' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
            'negara' => 'required',
            'kode_pos' => 'required|numeric',
            'no_telepon_rumah' => 'required|numeric',
            'no_telepon_handphone' => 'required|numeric',
            'email' => 'required|email',
            'status_kerja' => 'required',
            'mulai_kerja' => 'required|date',
            'perusahaan' => 'required',
            'area' => 'required',
            'unit' => 'required',
            'level' => 'required|numeric',
            'grade' => 'required',
            'uang_makan' => 'required|numeric',
            'gaji_pokok' => 'required|numeric',
            'tunjangan_bpjs' => 'required|numeric',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $karyawan = new Karyawan;
        $karyawan->jabatan = $request->jabatan;
        $karyawan->nik = $request->nik;
        $karyawan->nama = $request->nama;
        $karyawan->tanggal_lahir = $request->tanggal_lahir;
        $karyawan->tempat_lahir = $request->tempat_lahir;
        $karyawan->jenis_kelamin = $request->jenis_kelamin;
        $karyawan->status_pernikahan = $request->status_pernikahan;
        $karyawan->agama = $request->agama;
        $karyawan->pendidikan_terakhir = $request->pendidikan_terakhir;
        $karyawan->alamat = $request->alamat;
        $karyawan->kota = $request->kota;
        $karyawan->provinsi = $request->provinsi;
        $karyawan->negara = $request->negara;
        $karyawan->kode_pos = $request->kode_pos;
        $karyawan->no_telepon_rumah = $request->no_telepon_rumah;
        $karyawan->no_telepon_handphone = $request->no_telepon_handphone;
        $karyawan->email = $request->email;
        $karyawan->save();

        $status_pegawai = new StatusPegawai;
        $status_pegawai->status_kerja = $request->status_kerja;
        $status_pegawai->mulai_kerja = $request->mulai_kerja;
        $status_pegawai->akhir_kerja = $request->akhir_kerja;
        $status_pegawai->alasan_berhenti = $request->alasan_berhenti;
        $status_pegawai->karyawan_id = $karyawan->id;
        $status_pegawai->save();

        $penugasan = new Penugasan;
        $penugasan->perusahaan = $request->perusahaan;
        $penugasan->area = $request->area;
        $penugasan->unit = $request->unit;
        $penugasan->level = $request->level;
        $penugasan->grade = $request->grade;
        $penugasan->karyawan_id = $karyawan->id;
        $penugasan->save();

        $gaji = new Gaji;
        $gaji->uang_makan = (int) $request->uang_makan;
        $gaji->gaji_pokok = (int) $request->gaji_pokok;
        $gaji->tunjangan_bpjs = (int) $request->tunjangan_bpjs;
        $gaji->karyawan_id = $karyawan->id;
        $gaji->save();

        Alert::success('Added Successfully', 'Karyawan Data Added Successfully.');

        return redirect()->route('karyawans.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pageTitle = 'Detail Karyawan';
        // RAW SQL QUERY
        $karyawan = Karyawan::with(['statuspegawai', 'penugasan', 'gaji'])->findOrFail($id);

        return view('karyawan.show', compact('pageTitle', 'karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = 'Mengubah Data Karyawan';
        $karyawan = Karyawan::find($id);
        $status_pegawai = $karyawan->statuspegawai;
        $penugasan = $karyawan->penugasan;
        $gaji = $karyawan->gaji;

        return view('karyawan.edit', compact('pageTitle', 'karyawan', 'status_pegawai', 'penugasan', 'gaji'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->merge([
            'tunjangan_bpjs' => str_replace('.', '', $request->tunjangan_bpjs),
            'uang_makan' => str_replace('.', '', $request->uang_makan),
            'gaji_pokok' => str_replace('.', '', $request->gaji_pokok),
        ]);

        $messages = [
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka',
            'date' => 'Isi :attribute dengan format tanggal yang benar (YYYY-MM-DD)'
        ];
        $validator = Validator::make($request->all(), [
            'jabatan' => 'required',
            'nik' => 'required|numeric',
            'nama' => 'required',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'status_pernikahan' => 'required',
            'agama' => 'required',
            'pendidikan_terakhir' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
            'negara' => 'required',
            'kode_pos' => 'required|numeric',
            'no_telepon_rumah' => 'required|numeric',
            'no_telepon_handphone' => 'required|numeric',
            'email' => 'required|email',
            'status_kerja' => 'required',
            'mulai_kerja' => 'required|date',
            'perusahaan' => 'required',
            'area' => 'required',
            'unit' => 'required',
            'level' => 'required|numeric',
            'grade' => 'required',
            'uang_makan' => 'required|numeric',
            'gaji_pokok' => 'required|numeric',
            'tunjangan_bpjs' => 'required|numeric',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $karyawan = Karyawan::find($id);
        $status_pegawai = $karyawan->status_pegawai;
        $penugasan = $karyawan->penugasan;
        $gaji = $karyawan->gaji;

        if ($karyawan) {
            $karyawan->jabatan = $request->jabatan;
            $karyawan->nik = $request->nik;
            $karyawan->nama = $request->nama;
            $karyawan->tanggal_lahir = $request->tanggal_lahir;
            $karyawan->tempat_lahir = $request->tempat_lahir;
            $karyawan->jenis_kelamin = $request->jenis_kelamin;
            $karyawan->status_pernikahan = $request->status_pernikahan;
            $karyawan->agama = $request->agama;
            $karyawan->pendidikan_terakhir = $request->pendidikan_terakhir;
            $karyawan->alamat = $request->alamat;
            $karyawan->kota = $request->kota;
            $karyawan->provinsi = $request->provinsi;
            $karyawan->negara = $request->negara;
            $karyawan->kode_pos = $request->kode_pos;
            $karyawan->no_telepon_rumah = $request->no_telepon_rumah;
            $karyawan->no_telepon_handphone = $request->no_telepon_handphone;
            $karyawan->email = $request->email;
            $karyawan->save();

            if ($status_pegawai) {
                $status_pegawai->status_kerja = $request->status_kerja;
                $status_pegawai->mulai_kerja = $request->mulai_kerja;
                $status_pegawai->akhir_kerja = $request->akhir_kerja;
                $status_pegawai->alasan_berhenti = $request->alasan_berhenti;
                $status_pegawai->karyawan_id = $karyawan->id;
                $status_pegawai->save();
            } else {
                $status_pegawai = new StatusPegawai;
                $status_pegawai->status_kerja = $request->status_kerja;
                $status_pegawai->mulai_kerja = $request->mulai_kerja;
                $status_pegawai->akhir_kerja = $request->akhir_kerja;
                $status_pegawai->alasan_berhenti = $request->alasan_berhenti;
                $status_pegawai->karyawan_id = $karyawan->id;
                $status_pegawai->save();
            }

            if ($penugasan) {
                $penugasan->perusahaan = $request->perusahaan;
                $penugasan->area = $request->area;
                $penugasan->unit = $request->unit;
                $penugasan->level = $request->level;
                $penugasan->grade = $request->grade;
                $penugasan->karyawan_id = $karyawan->id;
                $penugasan->save();
            } else {
                $penugasan = new Penugasan;
                $penugasan->perusahaan = $request->perusahaan;
                $penugasan->area = $request->area;
                $penugasan->unit = $request->unit;
                $penugasan->level = $request->level;
                $penugasan->grade = $request->grade;
                $penugasan->karyawan_id = $karyawan->id;
                $penugasan->save();
            }

            if ($gaji) {
                $gaji->uang_makan = $request->uang_makan;
                $gaji->gaji_pokok = $request->gaji_pokok;
                $gaji->tunjangan_bpjs = $request->tunjangan_bpjs;
                $gaji->karyawan_id = $karyawan->id;
                $gaji->save();
            } else {
                $gaji = new Gaji;
                $gaji->uang_makan = $request->uang_makan;
                $gaji->gaji_pokok = $request->gaji_pokok;
                $gaji->tunjangan_bpjs = $request->tunjangan_bpjs;
                $gaji->karyawan_id = $karyawan->id;
                $gaji->save();
            }

            Alert::success('Changed Successfully', 'Karyawan Data Changed Successfully.');
        } else {
            Alert::error('Error', 'Karyawan Does Not Exist');
        }

        return redirect()->route('karyawans.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $karyawan = Karyawan::find($id);
        $karyawan->delete();
        Alert::success('Deleted Successfully', 'Karyawan Data Deleted Successfully.');
        return redirect()->route('karyawans.index');
    }

    public function getData(Request $request)
    {
        $karyawans = Karyawan::all();

        if ($request->ajax()) {
            return datatables()->of($karyawans)
                ->addIndexColumn()
                ->addColumn('actions', function ($karyawan) {
                    return view('karyawan.actions', compact('karyawan'));
                })
                ->toJson();
        }
    }
}
