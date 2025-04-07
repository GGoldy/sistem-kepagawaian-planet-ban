<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\LokasiKerjaController;
use App\Http\Controllers\KetidakhadiranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\UserController;
use App\Models\Karyawan;
use App\Models\Ketidakhadiran;
use App\Models\Penilaian;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('welcome');
});

Route::group(['middleware' => 'prevent-back-button'], function () {
    Auth::routes(['register' => false]);
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
});

// Auth::routes(['register' => false]);
// Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::get('/filter', [App\Http\Controllers\HomeController::class, 'getFilteredData'])->name('filter');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::prefix('users')->name('users.')->group(function () {
    Route::get('getUsers', [UserController::class, 'getData'])->name('users.getData');
    Route::resource('/', UserController::class)->parameters(['' => 'user']);
});

Route::prefix('karyawans')->name('karyawans.')->group(function () {
    Route::get('profile/{id}', [KaryawanController::class, 'profile'])->name('profile');
    Route::get('changepassword/{id}', [KaryawanController::class, 'password'])->name('changepassword');
    Route::put('updatepassword/{id}', [KaryawanController::class, 'changePassword'])->name('updatepassword');
    Route::get('getKaryawans', [KaryawanController::class, 'getData'])->name('karyawans.getData');
    Route::resource('/', KaryawanController::class)->parameters(['' => 'karyawan']);
});

Route::prefix('absens')->name('absens.')->group(function () {
    Route::get('data', [AbsenController::class, 'data'])->name('data');
    Route::get('self', [AbsenController::class, 'self'])->name('self');
    Route::post('calculateDistance', [AbsenController::class, 'calculateDistance'])->name('calculateDistance');
    Route::get('getAbsens', [AbsenController::class, 'getData'])->name('absens.getData');
    Route::get('getAbsenSelf', [AbsenController::class, 'getDataSelf'])->name('absens.getDataSelf');
    Route::resource('/', AbsenController::class)->parameters(['' => 'absen']);
});


Route::prefix('lokasikerjas')->name('lokasikerjas.')->group(function () {
    Route::resource('/', LokasiKerjaController::class)->parameters(['' => 'lokasikerja']);
});
Route::get('getLokasiKerjas', [LokasiKerjaController::class, 'getData'])->name('lokasikerjas.getData');

Route::prefix('ketidakhadirans')->name('ketidakhadirans.')->group(function () {
    Route::get('data', [KetidakhadiranController::class, 'data'])->name('data');
    Route::get('approve', [KetidakhadiranController::class, 'approve'])->name('approve');
    Route::get('showany/{id}', [KetidakhadiranController::class, 'showany'])->name('showany');
    Route::get('approval/{id}', [KetidakhadiranController::class, 'approval'])->name('approval');
    Route::put('signApproval/{id}', [KetidakhadiranController::class, 'signApproval'])->name('signApproval');
    Route::get('approvalHCM/{id}', [KetidakhadiranController::class, 'approvalHCM'])->name('approvalHCM');
    Route::put('signApprovalHCM/{id}', [KetidakhadiranController::class, 'signApprovalHCM'])->name('signApprovalHCM');
    Route::get('getKetidakhadiranSelf', [KetidakhadiranController::class, 'getDataSelf'])->name('ketidakhadirans.getDataSelf');
    Route::get('getKetidakhadiranAll', [KetidakhadiranController::class, 'getDataAll'])->name('ketidakhadirans.getDataAll');
    Route::get('getKetidakhadiranFiltered', [KetidakhadiranController::class, 'getDataFiltered'])->name('ketidakhadirans.getDataFiltered');
    Route::get('getKetidakhadiranAllFiltered', [KetidakhadiranController::class, 'getDataAllFiltered'])->name('ketidakhadirans.getDataAllFiltered');
    Route::resource('/', KetidakhadiranController::class)->parameters(['' => 'ketidakhadiran']);
});

Route::prefix('lemburs')->name('lemburs.')->group(function () {
    Route::get('data', [LemburController::class, 'data'])->name('data');
    Route::get('approve', [LemburController::class, 'approve'])->name('approve');
    Route::get('showany/{id}', [LemburController::class, 'showany'])->name('showany');
    Route::get('approval/{id}', [LemburController::class, 'approval'])->name('approval');
    Route::put('signApproval/{id}', [LemburController::class, 'signApproval'])->name('signApproval');
    Route::get('approvalHCM/{id}', [LemburController::class, 'approvalHCM'])->name('approvalHCM');
    Route::put('signApprovalHCM/{id}', [LemburController::class, 'signApprovalHCM'])->name('signApprovalHCM');
    Route::get('getLemburSelf', [LemburController::class, 'getDataSelf'])->name('lemburs.getDataSelf');
    Route::get('getLemburAll', [LemburController::class, 'getDataAll'])->name('lemburs.getDataAll');
    Route::get('getLemburFiltered', [LemburController::class, 'getDataFiltered'])->name('lemburs.getDataFiltered');
    Route::get('getLemburAllFiltered', [LemburController::class, 'getDataAllFiltered'])->name('lemburs.getDataAllFiltered');
    Route::resource('/', LemburController::class)->parameters(['' => 'lembur']);
});

Route::prefix('laporans')->name('laporans.')->group(function () {
    Route::get('filter', [LaporanController::class, 'getFilteredData'])->name('filter');
    Route::resource('/', LaporanController::class)->parameters(['' => 'laporan']);
});

Route::prefix('penilaians')->name('penilaians.')->group(function () {
    Route::get('getPenilaians', [PenilaianController::class, 'getData'])->name('penilaians.getData');
    Route::resource('/', PenilaianController::class)->parameters(['' => 'penilaian']);
});

// Route::get('/test-mail', function () {
//     Mail::raw('This is a test email from Laravel to Mailpit.', function ($message) {
//         $message->to('someone@example.com')->subject('Test Email');
//     });

//     return 'Email sent';
// });

// Route::prefix('gajis')->name('gajis.')->group(function () {
//     Route::get('filter', [GajiController::class, 'getFilteredData'])->name('filter');
//     Route::get('/', [GajiController::class, 'index'])->name('index');
// });

// Route::get('/view-signature/{id}', function ($id) {
//     $ketidakhadiran = Ketidakhadiran::findOrFail($id);

//     if (!$ketidakhadiran->signature || !Storage::disk('public')->exists($ketidakhadiran->signature)) {
//         return "Signature not found!";
//     }

//     return '<img src="'.asset('storage/' . $ketidakhadiran->signature).'" alt="Signature" width="300">';
// });
