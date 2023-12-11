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


class RekapSkripsiController extends Controller
{
    public function rekap_skripsi()
    {
        // Mendapatkan daftar angkatan
        $angkatanList = mahasiswa::select('angkatan')->distinct()->get();

        // Mendapatkan data mahasiswa
        $mahasiswa = mahasiswa::all(); 
        $skripsi = skripsi::all();

        // Mendapatkan data progress (gantilah sesuai kebutuhan Anda)
        $progress = tb_entry_progress::where('nim', Auth::user()->nim_nip)->first(); // Ganti dengan query sesuai kebutuhan
        
        // Menghitung jumlah mahasiswa per angkatan
        $jumlahMahasiswaPerAngkatan = mahasiswa::select('angkatan', DB::raw('COUNT(*) as total_mahasiswa'))
            ->groupBy('angkatan')
            ->get();

        // Menghitung jumlah mahasiswa yang sudah PKL per angkatan
        $jumlahSudahSkripsiPerAngkatan = mahasiswa::leftJoin('skripsis', 'mahasiswas.nim', '=', 'skripsis.nim')
            ->where('skripsis.status', '=', 'Lulus') // Sesuaikan dengan kondisi status PKL yang dianggap "sudah"
            ->select('mahasiswas.angkatan', DB::raw('COUNT(skripsis.nim) as total_sudah_skripsi'))
            ->groupBy('mahasiswas.angkatan')
            ->get();

        // Menggabungkan data angkatan, total mahasiswa, total sudah PKL, dan total belum PKL
        $dataPerAngkatan = [];
        foreach ($jumlahMahasiswaPerAngkatan as $angkatan) {
            $angkatanData = [
                'angkatan' => $angkatan->angkatan,
                'tahun' => [],
            ];

            // Iterasi untuk setiap tahun
            for ($year = 2017; $year <= 2023; $year++) {
                // Menghitung jumlah sudah PKL untuk angkatan tertentu dan tahun tertentu
                $sudahSkripsiData = mahasiswa::leftJoin('skripsis', 'mahasiswas.nim', '=', 'skripsis.nim')
                    ->where('mahasiswas.angkatan', $angkatan->angkatan)
                    ->where('skripsis.status', '=', 'Lulus')
                    ->where(DB::raw('YEAR(skripsis.semester_aktif)'), '=', $year)
                    ->count();

                // Menyimpan data per tahun ke dalam array
                $angkatanData['tahun'][$year]['sudah_skripsi'] = $sudahSkripsiData;

                // Menghitung jumlah belum PKL (total mahasiswa dikurangi yang sudah PKL)
                $belumSkripsiData = $angkatan->total_mahasiswa - $sudahSkripsiData;

                // Menyimpan data per tahun ke dalam array
                $angkatanData['tahun'][$year]['belum_skripsi'] = $belumSkripsiData;
            }


            // Menyimpan data per angkatan ke dalam array dataPerAngkatan
            $dataPerAngkatan[] = $angkatanData;
        }

        // Menyimpan data ke dalam variabel $mahasiswaPKL
        $mahasiswaSkripsi = $dataPerAngkatan;

        return view('departemen.data_skripsi.index', [
            'title' => 'Rekapitulasi Skripsi',
            'angkatanList' => $angkatanList,
            'dataPerAngkatan' => $dataPerAngkatan,
        ])->with(compact('mahasiswa', 'skripsi', 'progress', 'mahasiswaSkripsi'));
    }

    public function getRekapDataSkripsi()
    {
        $rekapDataSkripsi = [];

        for ($year = 2017; $year <= 2023; $year++) {
            $dataSudahSkripsi = DB::table('mahasiswas')
                ->leftJoin('skripsis', 'mahasiswas.nim', '=', 'skripsis.nim')
                ->where('mahasiswas.angkatan', $year)
                ->where('skripsis.status', 'Lulus')
                ->count();

            $dataBelumSkripsi = DB::table('mahasiswas')
                ->leftJoin('skripsis', 'mahasiswas.nim', '=', 'skripsis.nim')
                ->where('mahasiswas.angkatan', $year)
                ->whereNull('skripsis.nim') // Nim yang tidak ada di tabel pkls berarti belum PKL
                ->count();

            $rekapDataSkripsi[$year] = [
                'sudah' => $dataSudahSkripsi,
                'belum' => $dataBelumSkripsi,
            ];
        }

        return response()->json(['rekap_data' => $rekapDataSkripsi]);
    }

    public function listSkripsi($status, $year)
    {
        if ($status == 'sudah') {
            return $this->listSkripsiSudah($year);
        } elseif ($status == 'belum') {
            return $this->listSkripsiBelum($year);
        } else {
            // Handle case when status is neither 'sudah' nor 'belum'
            abort(404); // or redirect to an error page
        }
    }

    private function listSkripsiSudah($year)
    {
        $title = 'List Skripsi Sudah';
        // Gantilah 'status_pkl' dengan nama kolom yang sesuai pada model Mahasiswa
        $mahasiswaSkripsi = Mahasiswa::where('angkatan', $year)
            ->leftJoin('skripsis', 'mahasiswas.nim', '=', 'skripsis.nim')
            ->where('skripsis.status', 'Lulus')
            ->select('mahasiswas.*', 'skripsis.nilai') // Sesuaikan dengan kolom nilai pada model PKL
            ->get();

            return view('departemen.data_skripsi.list_skripsi_sudah', compact('year', 'mahasiswaSkripsi', 'title'));
    }

    private function listSkripsiBelum($year)
    {
        $title = 'List Skripsi Belum';
        // Gantilah 'status_pkl' dengan nama kolom yang sesuai pada model Mahasiswa
        $mahasiswaSkripsi = Mahasiswa::where('angkatan', $year)
            ->leftJoin('skripsis', 'mahasiswas.nim', '=', 'skripsis.nim')
            ->whereNull('skripsis.nim')
            ->select('mahasiswas.*') // Jika tidak ada kolom nilai pada model PKL
            ->get();

            return view('departemen.data_skripsi.list_skripsi_belum', compact('year', 'mahasiswaSkripsi', 'title'));
    }
}
