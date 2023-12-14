<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\dosen;
use App\Models\mahasiswa;
use App\Models\irs;
use App\Models\khs;
use App\Models\pkl;
use App\Models\skripsi;
use App\Models\temp_file;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function index()
    {
        $pkl = pkl::where('nim', Auth::user()->nim_nip)->orderBy('semester_aktif', 'desc')->first();
        $skripsi = skripsi::where('nim', Auth::user()->nim_nip)->orderBy('semester_aktif', 'desc')->first();
        $khs = khs::where('nim', Auth::user()->nim_nip)->orderBy('semester_aktif', 'desc')->first();
        $mahasiswa = mahasiswa::where('nim', Auth::user()->nim_nip)->first();
        $dosen = dosen::where('nip', Auth::user()->nim_nip)->first();
        $mahasiswaAll = mahasiswa::all();
        $dosenAll = dosen::all();
        return view('dashboard.index', [
            'title' => 'Rekap Status Angkatan',
        ])->with(compact('mahasiswa', 'mahasiswaAll', 'dosen', 'dosenAll', 'khs', 'pkl', 'skripsi'));
    }
}
