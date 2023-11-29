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

class EntryProgressController extends Controller
{
    public function index()
    {
        $countSemsester = tb_entry_progress::where('nim', Auth::user()->nim_nip)->count();
        $progress = tb_entry_progress::where('nim', Auth::user()->nim_nip)
            ->where('semester_aktif', $countSemsester)->first();
        $mahasiswa = mahasiswa::where('nim', Auth::user()->nim_nip)->first();
        return view('mahasiswa.entry.index', [
            'title' => 'Entry Progress',
        ])->with(compact('mahasiswa', 'progress'));
    }

    public function entry_progress(Request $request)
    {
        $request->validate([
            'semester_aktif' => 'required|unique:tb_entry_progresses,semester_aktif,NULL,id,nim,' . Auth::user()->nim_nip,
        ], [
            'semester_aktif.required' => 'Semester Aktif tidak boleh kosong',
            'semester_aktif.unique' => 'Semester' . $request->semester_aktif . 'sudah dientry',
        ]);

        $semester_aktif = $request->semester_aktif;
        $nim = Auth::user()->nim_nip;
        $kode_wali = mahasiswa::where('nim', $nim)->first()->kode_wali;

       
        $entry_progress = tb_entry_progress::create([
                'semester_aktif' => $semester_aktif,
                'nim' => $nim,
                'nip' => $kode_wali,
         ]);
            return redirect()->route('entry.index');
        }
    }

