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

class ProgressMhsContoller extends Controller
{
    public function dosen()
    {
        $mahasiswa = mahasiswa::where('kode_wali', Auth::user()->nim_nip)->get();
        $dosen = dosen::where('nip', Auth::user()->nim_nip)->first();
        return view('dosen.progress.index', [
            'title' => 'Progress Studi Mahasiswa',
        ])->with(compact('mahasiswa', 'dosen'));
    }

    public function department()
    {
        $mahasiswa = mahasiswa::all();
        return view('department.progress.index', [
            'title' => 'Progress Studi Mahasiswa',
        ])->with(compact('mahasiswa'));
    }

    public function show(Request $request)
    {
        $mahasiswa = mahasiswa::where('nim', $request->nim)->first();
        $dosen = dosen::where('nip', $mahasiswa->kode_wali)->first();
        for ($i = 1; $i <= 14; $i++) {
            $progress = tb_entry_progress::where('nim', $request->nim)->where('semester_aktif', $i)->where('is_verifikasi', '1')->first();
            $pkl = pkl::where('nim', $request->nim)->where('semester_aktif', $i)->first();
            $skripsi = skripsi::where('nim', $request->nim)->where('semester_aktif', $i)->first();
            if ($progress != null) {
                if ($progress->is_irs == 1 && $progress->is_khs == 1) {
                    $semester[$i] = 'btn-info';
                } else {
                    $semester[$i] = 'btn-danger';
                }
                if ($progress->is_pkl == 1 && $pkl->status == 'Lulus') {
                    $semester[$i] = 'btn-warning';
                }
                if ($progress->is_skripsi == 1 && $skripsi->status == 'Lulus') {
                    $semester[$i] = 'btn-success';
                }
            } else {
                $semester[$i] = 'btn-danger';
            }
        }

        if (Auth::user()->role == 'dosen') {
            if ($mahasiswa->kode_wali == Auth::user()->nim_nip) {
                return view('dosen.progress.detail', [
                    'title' => 'Progress Studi Mahasiswa',
                ])->with(compact('mahasiswa', 'dosen', 'semester'));
            } else {
                Alert::error('Error', 'Anda tidak memiliki akses ke halaman ini');
                return redirect()->back();
            }
        } else {
            return view('department.progress.detail', [
                'title' => 'Progress Studi Mahasiswa',
            ])->with(compact('mahasiswa', 'dosen', 'semester'));
        }
    }

    public function show_semester(Request $request)
    {
        $irs = irs::where('nim', $request->nim)->where('semester_aktif', $request->semester)->first();
        $khs = khs::where('nim', $request->nim)->where('semester_aktif', $request->semester)->first();
        $pkl = pkl::where('nim', $request->nim)->where('semester_aktif', $request->semester)->first();
        $skripsi = skripsi::where('nim', $request->nim)->where('semester_aktif', $request->semester)->first();

        if (Auth::user()->role == 'dosen') {
            return view('dosen.progress.modal', compact('request', 'irs', 'khs', 'pkl', 'skripsi'));
        } else {
            return view('department.progress.modal', compact('request', 'irs', 'khs', 'pkl', 'skripsi'));
        }
    }
}
