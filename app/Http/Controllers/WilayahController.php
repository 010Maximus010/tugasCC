<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\dosen;
use App\Models\mahasiswa;
use App\Models\irs;
use App\Models\kab;
use App\Models\khs;
use App\Models\pkl;
use App\Models\skripsi;
use App\Models\temp_file;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class WilayahController extends Controller
{
    public function index($provinsi)
    {
        // if User is Mahasiswa
        if (Auth::user()->role == 'mahasiswa') {
            $kabupatenkota = kab::where('kode_prov', $provinsi)->get();
            $mahasiswa = mahasiswa::where('nim', Auth::user()->nim_nip)->first();

            echo "<option value=''>Pilih Kabupaten/Kota</option>";
            foreach ($kabupatenkota as $kab) {
                echo "<option value='" . $kab->kode_kab . "' " . ($mahasiswa->kode_kab == $kab->kode_kab ? 'selected="true"' : '') . ">" . $kab->nama_kab . "</option>";
            }
        } else if (Auth::user()->role == 'dosen') {
            $kabupatenkota = kab::where('kode_prov', $provinsi)->get();
            $dosen = dosen::where('nip', Auth::user()->nim_nip)->first();

            echo "<option value=''>Pilih Kabupaten/Kota</option>";
            foreach ($kabupatenkota as $kab) {
                echo "<option value='" . $kab->kode_kab . "' " . ($dosen->kode_kab == $kab->kode_kab ? 'selected="true"' : '') . ">" . $kab->nama_kab . "</option>";
            }
        } else {
            $kabupatenkota = kab::where('kode_prov', $provinsi)->get();

            echo "<option value=''>Pilih Kabupaten/Kota</option>";
            foreach ($kabupatenkota as $kab) {
                echo "<option value='" . $kab->kode_kab . "'>" . $kab->nama_kab . "</option>";
            }
        }
    }
}
