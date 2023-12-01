<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AddUserController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\EditProfileController;
use App\Http\Controllers\EditProfileOperatorController;
use App\Http\Controllers\EditProfileDepartemenController;
use App\Http\Controllers\EditProfileDosenController;
use App\Http\Controllers\IRSController;
use App\Http\Controllers\KHSController;
use App\Http\Controllers\PKLController;
use App\Http\Controllers\SkripsiController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\VerifikasiBerkasController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProgressMhsContoller;
use App\Http\Controllers\EntryProgressController;

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

Route::group(['middleware' => ['prevent-back-history']], function () {
    // Home 
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Auth (login & logout)
    Route::get('/login', [AuthController::class, 'index'])->middleware('guest');
    Route::post('/login', [AuthController::class, 'authenticate'])->middleware('guest')->name('login');
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
});

// Middleware auth
Route::group(['middleware' => ['auth', 'prevent-back-history']], function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('editprofile')->name('dashboard');

    // Fiture Operator
    Route::group(['middleware' => ['operator']], function () {
        // add user & manajamen user (CRUD User)
        Route::get('/operator/add_user', [AddUserController::class, 'index'])->name('add_user');
        Route::get('/operator/manage_users', [ManageUserController::class, 'index'])->name('manage_users');
        Route::resource('/operator/mahasiswa', MahasiswaController::class);
        Route::post('/operator/mahasiswa/bulk', [MahasiswaController::class, 'bulk'])->name('mahasiswa.bulk');
        Route::resource('/operator/dosen', DosenController::class);
        Route::post('/operator/dosen/bulk', [DosenController::class, 'bulk'])->name('dosen.bulk');
        // delete user
        Route::get('/operator/delete_mahasiswa/{id}', [MahasiswaController::class, 'delete'])->name('delete_mahasiswa');
        Route::get('/operator/delete_dosen/{id}', [DosenController::class, 'delete'])->name('delete_dosen');
    });

    // Fiture Mahasiswa
    Route::group(['middleware' => ['mahasiswa', 'editprofile']], function () {
        // entry progress
        Route::get('/mahasiswa/entry', [EntryProgressController::class, 'index'])->middleware('entry_progress');
        Route::post('/mahasiswa/entry', [EntryProgressController::class, 'entry_progress'])->name('entry_progress');

        // irs
        Route::resource('/mahasiswa/irs', IRSController::class);
        Route::get('/mahasiswa/data/irs', [IRSController::class, 'data'])->name('data_irs');
        Route::get('/mahasiswa/irs/{semester}/{nim}/edit', [IRSController::class, 'edit'])->name('irs.edit');
        //Route::get('/mahasiswa/irs/{semester}/{nim}/delete', [IRSController::class, 'delete'])->name('delete_irs');
        //Route::delete('/irs/{semester_aktif}/{nim}', 'IRSController@destroy')->name('irs.destroy');
        //Route::delete('/irs/{semester_aktif}/{nim}', [IRSController::class, 'destroy'])->name('irs.destroy');
        Route::delete('/mahasiswa/irs/{semester_aktif}/{nim}', 'IRSController@destroy')->name('delete_irs');


        // khs
        Route::resource('/mahasiswa/khs', KHSController::class);
        Route::get('/mahasiswa/data/khs', [KHSController::class, 'data'])->name('data_khs');
        Route::get('/mahasiswa/khs/{semester}/{nim}/edit', [KHSController::class, 'edit'])->name('khs.edit');

        // pkl
        Route::resource('/mahasiswa/pkl', PKLController::class);
        Route::get('/mahasiswa/data/pkl', [PKLController::class, 'data'])->name('data_pkl');
        Route::get('/mahasiswa/pkl/{semester}/{nim}/edit', [PKLController::class, 'edit'])->name('pkl.edit');

        // skripsi
        Route::resource('/mahasiswa/skripsi', SkripsiController::class);
        Route::get('/mahasiswa/data/skripsi', [SkripsiController::class, 'data'])->name('data_skripsi');
        Route::get('/mahasiswa/skripsi/{semester}/{nim}/edit', [SkripsiController::class, 'edit'])->name('skripsi.edit');
    });

    // Fiture Dosen
    Route::group(['middleware' => ['dosen', 'editprofile']], function () {
        // progress studi mahasiswa
        Route::get('/dosen/progress_studi_mahasiswa', [ProgressMhsContoller::class, 'dosen']);
        Route::get('/dosen/progress_studi_mahasiswa/detail', [ProgressMhsContoller::class, 'show'])->name('progress_detail');
        Route::get('/dosen/progress_studi_mahasiswa/semester', [ProgressMhsContoller::class, 'show_semester'])->name('progress_detail_semester');

        // verifikasi berkas mahasiswa
        Route::get('/dosen/verifikasi_berkas_mahasiswa', [VerifikasiBerkasController::class, 'index']);
        Route::get('/dosen/verifikasi_berkas_mahasiswa/detail', [VerifikasiBerkasController::class, 'show'])->name('berkas_detail');
        Route::post('/dosen/verifikasi_berkas_mahasiswa/update', [VerifikasiBerkasController::class, 'update'])->name('verifikasi_update');
    });

    // Fiture Departemen
    Route::group(['middleware' => ['departemen']], function () {
        // progress studi mahasiswa
        Route::get('/departemen/progress_studi_mahasiswa', [ProgressMhsContoller::class, 'departemen']);
        Route::get('/departemen/progress_studi_mahasiswa/detail', [ProgressMhsContoller::class, 'show'])->name('departemen_progress_detail');
        Route::get('/departemen/progress_studi_mahasiswa/semester', [ProgressMhsContoller::class, 'show_semester'])->name('departemen_progress_detail_semester');

        // berkas mahasiswa
        Route::get('/departemen/berkas_mahasiswa/detail', [VerifikasiBerkasController::class, 'show'])->name('departemen_berkas_detail');

        // data dosen
        Route::get('/departemen/data_dosen', [DosenController::class, 'data_dosen']);
        Route::post('/departemen/data_dosen/detail', [DosenController::class, 'data_dosen_detail'])->name('data_dosen_detail');

        // data mahasiswa
        Route::get('/departemen/data_mahasiswa', [MahasiswaController::class, 'data_mahasiswa']);
        Route::post('/departemen/data_mahasiswa/detail', [MahasiswaController::class, 'data_mahasiswa_detail'])->name('data_mahasiswa_detail');

        // data mahasiswa pkl
        Route::get('/departemen/data_mahasiswa_pkl', [MahasiswaController::class, 'data_pkl']);

        // data mahasiswa skripsi
        Route::get('/departemen/data_mahasiswa_skripsi', [MahasiswaController::class, 'data_skripsi']);
    });

    //edit profile
    Route::resource('/mahasiswa/edit_profile', EditProfileController::class)->middleware('mahasiswa')->names('edit_profile_mahasiswa');
    Route::resource('/operator/edit_profile', EditProfileOperatorController::class)->middleware('operator')->names('edit_profile_operator');
    Route::resource('/dosen/edit_profile', EditProfileDosenController::class)->middleware('dosen')->names('edit_profile_dosen');
    Route::resource('/departemen/edit_profile', EditProfileDepartemenController::class)->middleware('departemen')->names('edit_profile_departemen');

    // Change Password
    Route::resource('/dosen/change_password', PasswordController::class);
    Route::resource('/mahasiswa/change_password', PasswordController::class);
    Route::resource('/operator/change_password', PasswordController::class);
    Route::resource('/departemen/change_password', PasswordController::class);

     // Wilayah Indonesia
     Route::get('/wilayah/{provinsi}', [WilayahController::class, 'index'])->name('wilayah');

     // Upload File
     Route::post('/upload', [UploadController::class, 'upload']);
});
