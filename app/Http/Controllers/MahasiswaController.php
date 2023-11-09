<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\irs;
use App\Models\kab;
use App\Models\khs;
use App\Models\pkl;
use App\Models\prov;
use App\Models\dosen;
use App\Models\skripsi;
use App\Models\mahasiswa;
use App\Models\temp_file;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MahasiswaImport;
use App\Models\tb_entry_progress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mahasiswa = mahasiswa::latest()->paginate(5);
        return view('operator.manage_users', compact('mahasiswa'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request...
        $request->validate([
            'nim' => 'required|numeric|unique:users,nim_nip|digits:14',
            'nama' => 'required|string',
            'status' => 'required',
        ], [
            'nim.required' => 'NIM tidak boleh kosong',
            'nim.unique' => 'NIM sudah terdaftar',
            'nim.digits' => 'NIM harus 14 digit',
            'nama.required' => 'Nama tidak boleh kosong',
            'status.required' => 'Status tidak boleh kosong',
        ]);

        // Angkatan Mahasiswa
        // 24060120120120
        // 01234567890123
        $angkatan = 20 . substr($request->nim, 6, 2);

        // 12 = SNMPTN
        // 13 = SBMPTN
        // 14 = Ujian Mandiri
        if (substr($request->nim, 8, 2) == '12') {
            $jalur_masuk = 'SNMPTN';
        } elseif (substr($request->nim, 8, 2) == '13') {
            $jalur_masuk = 'SBMPTN';
        } elseif (substr($request->nim, 8, 2) == '14') {
            $jalur_masuk = 'Ujian Mandiri';
        } else {
            $jalur_masuk = 'SBUB';
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Insert to table mahasiswa & users
        mahasiswa::insert([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'angkatan' => $angkatan,
            'status' => $request->status,
            'jalur_masuk' => $jalur_masuk,
        ]);

        User::insert([
            'nim_nip' => $request->nim,
            'nama' => $request->nama,
            'password' => bcrypt($request->nim),
            'role' => 'mahasiswa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Alert success
        Alert::success('Success!', 'Data mahasiswa berhasil ditambahkan');

        return redirect()->route('manage_users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // find where nim table mahasiswa
        $mahasiswa = mahasiswa::where('nim', $id)->first();
        $user = User::where('nim_nip', $id)->first();
        return view('operator.manage_users.modal.edit_mahasiswa', compact('mahasiswa'), compact('user'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 
        $request->validate([
            'nama' => 'required|string',
            'angkatan' => 'required|numeric',
            'status' => 'required',
            'email' => 'nullable|email|unique:users,email,' . $id . ',nim_nip',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'angkatan.required' => 'Angkatan tidak boleh kosong',
            'status.required' => 'Status tidak boleh kosong',
            'email.unique' => 'Email sudah terdaftar',
        ]);

        // Update to table mahasiswa & users
        if ($request->email == '') {
            $data = $request->except(['_token', '_method', 'password', 'email']);
        } else {
            $request->validate([
                'email' => 'unique:users,email,' . $id . ',nim_nip',
            ]);
            $data = $request->except(['_token', '_method', 'password']);
        }
        mahasiswa::where('nim', $id)->update($data);

        if ($request->password == '') {
            $data = $request->only(['nama', 'email']);
        } else {
            $data = $request->only(['nama', 'email', 'password']);
            $data['password'] = bcrypt($request->password);
        }
        User::where('nim_nip', $id)->update($data);

        // Alert success
        Alert::success('Success!', 'Data mahasiswa berhasil diupdate');

        return redirect()->route('manage_users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        // find where nim table mahasiswa
        if ($id == 'all') {
            return view('operator.manage_users.modal.delete_all_mahasiswa');
        } else {
            $mahasiswa = mahasiswa::where('nim', $id)->first();
            return view('operator.manage_users.modal.delete_mahasiswa', compact('mahasiswa'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete to table mahasiswa & users
        if ($id == 'all') {
            User::where('role', 'mahasiswa')->delete();
            mahasiswa::where('nim', '!=', '')->delete();
        } else {
            User::where('nim_nip', $id)->delete();
            mahasiswa::where('nim', $id)->delete();
        }

        // Alert success
        Alert::success('Success!', 'Data mahasiswa berhasil dihapus');
        return redirect()->route('manage_users');
    }

    // bulk
    public function bulk(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ], [
            'file.required' => 'File tidak boleh kosong',
            'file.mimes' => 'File harus berformat xlsx, xls, atau csv',
        ]);

        Excel::import(new MahasiswaImport, $request->file('file'));

        // Alert success
        Alert::success('Success!', 'Data mahasiswa berhasil ditambahkan');
        return redirect()->route('manage_users');
    }

    public function data_mahasiswa()
    {
        $mahasiswaAll = mahasiswa::all();
        return view('departemen.data_mhs.index', [
            'title' => 'Data Mahasiswa',
        ])->with(compact('mahasiswaAll'));
    }

    public function data_mahasiswa_detail(Request $request)
    {
        $mahasiswa = mahasiswa::where('nim', $request->nim)->first();
        $dosen = dosen::where('nip', $mahasiswa->kode_wali)->first();
        $kabupaten = kab::where('kode_kab', $mahasiswa->kode_kab)->first();
        $provinsi = prov::where('kode_prov', $mahasiswa->kode_prov)->first();
        return view('departemen.data_mhs.detail', [
            'title' => 'Data Mahasiswa Detail',
        ])->with(compact('mahasiswa', 'dosen', 'kabupaten', 'provinsi'));
    }

    public function data_pkl()
    {
        $mahasiswaAll = mahasiswa::orderBy('angkatan', 'asc')->get();
        $selectPKL = mahasiswa::orderBy('tb_entry_progresses.semester_aktif', 'desc')->join('pkls', 'mahasiswas.nim', '=', 'pkls.nim')
            ->join('tb_entry_progresses', 'pkls.nim', '=', 'tb_entry_progresses.nim')
            ->where('pkls.semester_aktif', '=', DB::raw('tb_entry_progresses.semester_aktif'))
            ->where('tb_entry_progresses.is_pkl', '=', 1)
            ->where('tb_entry_progresses.is_verifikasi', '=', '1')
            ->select('mahasiswas.*', 'pkls.*', 'tb_entry_progresses.*')
            ->get()
            ->unique('nim');

        $mahasiswaPKL = [];
        foreach ($selectPKL as $key => $value) {
            $mahasiswaPKL[] = $value;
        }

        return view('departemen.data_pkl.index', [
            'title' => 'Data Mahasiswa PKL',
        ])->with(compact('mahasiswaAll', 'mahasiswaPKL'));
    }

    public function data_skripsi()
    {
        $mahasiswaAll = mahasiswa::orderBy('angkatan', 'asc')->get();
        $selectSkripsi = mahasiswa::orderBy('tb_entry_progresses.semester_aktif', 'desc')->join('skripsis', 'mahasiswas.nim', '=', 'skripsis.nim')
            ->join('tb_entry_progresses', 'skripsis.nim', '=', 'tb_entry_progresses.nim')
            ->where('skripsis.semester_aktif', '=', DB::raw('tb_entry_progresses.semester_aktif'))
            ->where('tb_entry_progresses.is_skripsi', '=', 1)
            ->where('tb_entry_progresses.is_verifikasi', '=', '1')
            ->select('mahasiswas.*', 'skripsis.*', 'tb_entry_progresses.*')
            ->get()
            ->unique('nim');
        $mahasiswaSkripsi = [];
        foreach ($selectSkripsi as $key => $value) {
            $mahasiswaSkripsi[] = $value;
        }

        return view('departemen.data_skripsi.index', [
            'title' => 'Data Mahasiswa Skripsi',
        ])->with(compact('mahasiswaAll', 'mahasiswaSkripsi'));
    }
}
