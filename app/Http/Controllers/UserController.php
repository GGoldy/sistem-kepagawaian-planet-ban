<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Daftar Pengguna';

        $users = User::all();
        return view('user.index', [
            'pageTitle' => $pageTitle,
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Tambah Pengguna';
        $karyawans = Karyawan::all();
        $roles = Role::all();
        return view('user.create', compact('pageTitle', 'karyawans', 'roles'));
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
            'min' => ':Attribute minimal harus :min karakter.',
            'same' => ':Attribute harus sama dengan password baru.',
        ];
        $validator = Validator::make($request->all(), [
            'karyawan' => 'required',
            'name' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id', // (optional) ensures each selected role is valid
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->karyawan_id = $request->karyawan;
        $user->save();
        $user->roles()->sync($request->roles);

        Alert::success('Added Successfully', 'User Data Added Successfully.');

        return redirect()->route('users.index');
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
        $pageTitle = 'Mengganti Pengguna';
        $user = User::with('roles')->find($id);
        $karyawans = Karyawan::all();
        $roles = Role::all();
        return view('user.edit', compact('pageTitle', 'user', 'karyawans', 'roles'));
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
            'date' => 'Isi :attribute dengan format tanggal yang benar (YYYY-MM-DD)',
            'min' => ':Attribute minimal harus :min karakter.',
            'same' => ':Attribute harus sama dengan password baru.',
        ];
        $validator = Validator::make($request->all(), [
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id', // (optional) ensures each selected role is valid
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find($id);

        if ($user) {
            $user->roles()->sync($request->roles);
        }
        Alert::success('Changed Successfully', 'User Data Changed Successfully.');

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        Alert::success('Deleted Successfully', 'User Data Deleted Successfully.');
        return redirect()->route('users.index');
    }

    public function getData(Request $request)
    {
        $users = User::with(['roles', 'karyawan'])->select('users.*');

        if ($request->ajax()) {
            return datatables()->of($users)
                ->addIndexColumn()
                ->addColumn('roles', function ($user) {
                    return $user->roles->pluck('title')->join(', ');
                })

                ->filterColumn('roles', function ($query, $keyword) {
                    $query->whereHas('roles', function ($q) use ($keyword) {
                        $q->where('title', 'like', "%{$keyword}%");
                    });
                })
                ->addColumn('actions', function ($user) {
                    return view('user.actions', compact('user'));
                })
                ->toJson();
        }
    }
}
