<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\dosen;
use App\Models\tb_entry_progress;
use App\Models\mahasiswa;
use App\Models\irs;
use App\Models\khs;
use App\Models\pkl;
use App\Models\skripsi;
use App\Models\temp_file;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class VerifikasiBerkasKHSController extends Controller
{
    public function index()
{
    $mahasiswa = mahasiswa::where('kode_wali', Auth::user()->nim_nip)->get();
    $dosen = dosen::where('nip', Auth::user()->nim_nip)->first();

    // Mengambil semua data tanpa memperdulikan nilai is_verifikasi_khs
    $progress = tb_entry_progress::where('nip', Auth::user()->nim_nip)
        ->where('is_khs', 1)
        ->get();

    return view('dosen.verifikasi_khs.index', [
        'title' => 'Verifikasi Berkas Mahasiswa',
    ])->with(compact('mahasiswa', 'progress', 'dosen'));
}


    public function show(Request $request)
    {
        if ($request->nim_semester != null) {
            $nim = explode('_', $request->nim_semester)[0];
            $semester = explode('_', $request->nim_semester)[1];
        } else {
            $nim = $request->nim;
            $semester = $request->semester;
        }

        $mahasiswa = mahasiswa::where('nim', $nim)->first();
        $dosen = dosen::where('nip', $mahasiswa->kode_wali)->first();
        $progress = tb_entry_progress::where('nim', $nim)->where('semester_aktif', $semester)->first();
        //$irs = irs::where('nim', $nim)->where('semester_aktif', $semester)->first();
        $khs = khs::where('nim', $nim)->where('semester_aktif', $semester)->first();
        //$pkl = pkl::where('nim', $nim)->where('semester_aktif', $semester)->first();
        //$skripsi = skripsi::where('nim', $nim)->where('semester_aktif', $semester)->first();

        if ($progress == null) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        //} else if ($progress->is_irs == 0 || $progress->is_khs == 0 || $progress->is_pkl == 0 || $progress->is_skripsi == 0) {
        //    return redirect()->back()->with('error', 'Mahasiswa belum mengisi semua data');
        } else {
            return view('dosen.verifikasi_khs.berkas', [
                'title' => 'Verifikasi Berkas Mahasiswa',
            ])->with(compact('mahasiswa', 'dosen', 'progress', 'khs'));
        }
    }

    public function update(Request $request)
    {
        if ($request->id == 1) {
            tb_entry_progress::where('nim', $request->nim)->where('semester_aktif', $request->semester)->update([
                'is_verifikasi_khs' => '1',
            ]);
            Alert::success('Berhasil', 'Berkas berhasil diverifikasi');
            return redirect('/dosen/verifikasi_berkas_mahasiswa_khs');
        } else {
            tb_entry_progress::where('nim', $request->nim)->where('semester_aktif', $request->semester)->update([
                'is_verifikasi_khs' => '0',
            ]);
            Alert::success('Berhasil', 'Berkas berhasil dibatalkan');
            return redirect('/dosen/verifikasi_berkas_mahasiswa_khs');
        }
    }
}
