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


class RekapPKLController extends Controller
{

    public function rekap_pkl()
    {
        // Mendapatkan daftar angkatan
        $angkatanList = mahasiswa::select('angkatan')->distinct()->get();

        // Mendapatkan data mahasiswa
        $mahasiswa = mahasiswa::all(); 
        $pkl = pkl::all();

        // Mendapatkan data progress (gantilah sesuai kebutuhan Anda)
        $progress = tb_entry_progress::where('nim', Auth::user()->nim_nip)->first(); // Ganti dengan query sesuai kebutuhan
        
        // Menghitung jumlah mahasiswa per angkatan
        $jumlahMahasiswaPerAngkatan = mahasiswa::select('angkatan', DB::raw('COUNT(*) as total_mahasiswa'))
            ->groupBy('angkatan')
            ->get();

        // Menghitung jumlah mahasiswa yang sudah PKL per angkatan
        $jumlahSudahPKLPerAngkatan = mahasiswa::leftJoin('pkls', 'mahasiswas.nim', '=', 'pkls.nim')
            ->where('pkls.status', '=', 'Lulus') // Sesuaikan dengan kondisi status PKL yang dianggap "sudah"
            ->select('mahasiswas.angkatan', DB::raw('COUNT(pkls.nim) as total_sudah_pkl'))
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
                $sudahPKLData = mahasiswa::leftJoin('pkls', 'mahasiswas.nim', '=', 'pkls.nim')
                    ->where('mahasiswas.angkatan', $angkatan->angkatan)
                    ->where('pkls.status', '=', 'Lulus')
                    ->where(DB::raw('YEAR(pkls.semester_aktif)'), '=', $year)
                    ->count();

                // Menyimpan data per tahun ke dalam array
                $angkatanData['tahun'][$year]['sudah_pkl'] = $sudahPKLData;

                // Menghitung jumlah belum PKL (total mahasiswa dikurangi yang sudah PKL)
                $belumPKLData = $angkatan->total_mahasiswa - $sudahPKLData;

                // Menyimpan data per tahun ke dalam array
                $angkatanData['tahun'][$year]['belum_pkl'] = $belumPKLData;
            }


            // Menyimpan data per angkatan ke dalam array dataPerAngkatan
            $dataPerAngkatan[] = $angkatanData;
        }

        // Menyimpan data ke dalam variabel $mahasiswaPKL
        $mahasiswaPKL = $dataPerAngkatan;

        return view('departemen.data_pkl.index', [
            'title' => 'Rekapitulasi PKL',
            'angkatanList' => $angkatanList,
            'dataPerAngkatan' => $dataPerAngkatan,
        ])->with(compact('mahasiswa', 'pkl', 'progress', 'mahasiswaPKL'));
    }

    public function getRekapDataPKL()
    {
        $rekapDataPKL = [];

        for ($year = 2017; $year <= 2023; $year++) {
            $dataSudahPKL = DB::table('mahasiswas')
                ->leftJoin('pkls', 'mahasiswas.nim', '=', 'pkls.nim')
                ->where('mahasiswas.angkatan', $year)
                ->where('pkls.status', 'Lulus')
                ->count();

            $dataBelumPKL = DB::table('mahasiswas')
                ->leftJoin('pkls', 'mahasiswas.nim', '=', 'pkls.nim')
                ->where('mahasiswas.angkatan', $year)
                ->whereNull('pkls.nim') // Nim yang tidak ada di tabel pkls berarti belum PKL
                ->count();

            $rekapDataPKL[$year] = [
                'sudah' => $dataSudahPKL,
                'belum' => $dataBelumPKL,
            ];
        }

        return response()->json(['rekap_data' => $rekapDataPKL]);
    }

    public function listPKL($status, $year)
    {
        if ($status == 'sudah') {
            return $this->listPKLSudah($year);
        } elseif ($status == 'belum') {
            return $this->listPKLBelum($year);
        } else {
            // Handle case when status is neither 'sudah' nor 'belum'
            abort(404); // or redirect to an error page
        }
    }

    private function listPKLSudah($year)
    {
        $title = 'List PKL Sudah';
        // Gantilah 'status_pkl' dengan nama kolom yang sesuai pada model Mahasiswa
        $mahasiswaPKL = Mahasiswa::where('angkatan', $year)
            ->leftJoin('pkls', 'mahasiswas.nim', '=', 'pkls.nim')
            ->where('pkls.status', 'Lulus')
            ->select('mahasiswas.*', 'pkls.nilai') // Sesuaikan dengan kolom nilai pada model PKL
            ->get();

            return view('departemen.data_pkl.list_pkl_sudah', compact('year', 'mahasiswaPKL', 'title'));
    }

    private function listPKLBelum($year)
    {
        $title = 'List PKL Belum';
        // Gantilah 'status_pkl' dengan nama kolom yang sesuai pada model Mahasiswa
        $mahasiswaPKL = Mahasiswa::where('angkatan', $year)
            ->leftJoin('pkls', 'mahasiswas.nim', '=', 'pkls.nim')
            ->whereNull('pkls.nim')
            ->select('mahasiswas.*') // Jika tidak ada kolom nilai pada model PKL
            ->get();

            return view('departemen.data_pkl.list_pkl_belum', compact('year', 'mahasiswaPKL', 'title'));
    }
}
