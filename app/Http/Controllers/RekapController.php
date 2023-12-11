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

class RekapController extends Controller
{
    public function status($status) {
        $title = 'Rekap Mahasiswa Status';
        $mahasiswaData = Mahasiswa::leftJoin('dosens', 'mahasiswas.kode_wali', '=', 'dosens.nip')
            ->select('mahasiswas.*', 'dosens.nama as nama_dosen')
            ->where('mahasiswas.status', $status) // Specify the table for the 'status' column
            ->get();
        return view('departemen.rekap_status', compact('status', 'title', 'mahasiswaData'));
    }
    
    public function angkatan($angkatan) {
        $title = 'Rekap Mahasiswa Angkatan';
        $mahasiswaData = Mahasiswa::leftJoin('dosens', 'mahasiswas.kode_wali', '=', 'dosens.nip')
            ->select('mahasiswas.*', 'dosens.nama as nama_dosen')
            ->where('mahasiswas.angkatan', $angkatan) // Specify the table for the 'angkatan' column
            ->get();
        return view('departemen.rekap_angkatan', compact('angkatan', 'title', 'mahasiswaData'));
    }
    
    public function tahunStatus($tahun, $status) {
        $title = 'Rekap Mahasiswa Angkatan-Status';
        $mahasiswaData = Mahasiswa::leftJoin('dosens', 'mahasiswas.kode_wali', '=', 'dosens.nip')
            ->select('mahasiswas.*', 'dosens.nama as nama_dosen')
            ->where('mahasiswas.angkatan', $tahun)
            ->where('mahasiswas.status', $status) // Specify the table for the 'status' column
            ->get();
        return view('departemen.rekap_tahun_status', compact('tahun', 'status', 'title', 'mahasiswaData'));
    }
    
    
}
