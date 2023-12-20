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

class SkripsiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('skripsi', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countSemsester = tb_entry_progress::where('nim', Auth::user()->nim_nip)->count();
        $progress = tb_entry_progress::where('nim', Auth::user()->nim_nip)
            ->where('semester_aktif', $countSemsester)->first();
        $mahasiswa = mahasiswa::where('nim', Auth::user()->nim_nip)->first();
        $skripsi = skripsi::where('nim', Auth::user()->nim_nip)->get();
        return view('mahasiswa.skripsi.entry', [
            'title' => 'Entry Skripsi',
        ])->with(compact('mahasiswa', 'skripsi', 'progress'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        $progress = tb_entry_progress::where('nim', Auth::user()->nim_nip)->first();
        $mahasiswa = mahasiswa::where('nim', Auth::user()->nim_nip)->first();
        $skripsi = skripsi::where('nim', Auth::user()->nim_nip)->get();
        return view('mahasiswa.skripsi.index', [
            'title' => 'Skripsi',
        ])->with(compact('mahasiswa', 'skripsi', 'progress'));
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
        $existingSkripsi = skripsi::where('nim', Auth::user()->nim_nip)
        ->first();

        if ($existingSkripsi) {
            return redirect()->back()->withErrors(['error' => 'Anda hanya diizinkan mengisi Skripsi sekali']);
        }
        // Validate
        $request->validate([
            'semester_aktif' => 'required|unique:skripsis,semester_aktif,NULL,id,nim,' . Auth::user()->nim_nip,
            'tanggal_sidang' => 'required_if:status_skripsi,Lulus',
            'nilai_skripsi' => 'required_if:status_skripsi,Lulus|in:,A,B,C,D,E',
            'status_skripsi' => 'required|in:,Lulus,Tidak Lulus',
            'file' => 'required',
        ], [
            'semester_aktif.required' => 'Semester Aktif tidak boleh kosong',
            'semester_aktif.unique' => 'Anda sudah mengisi Skripsi semester ini',
            'tanggal_sidang.required_if' => 'Tanggal Sidang tidak boleh kosong',
            'nilai_skripsi.required_if' => 'Nilai Skripsi tidak boleh kosong',
            'nilai_skripsi.in' => 'Nilai Skripsi harus diisi dengan A, B, C, D, E',
            'file.required' => 'File tidak boleh kosong',
        ]);

        if ($request->status_skripsi != 'Lulus' && $request->nilai_skripsi != null) {
            Alert::error('Gagal', 'Nilai Skripsi hanya bisa diisi jika status Skripsi adalah Lulus');
            return redirect()->back();
        }

        $temp = temp_file::where('path', $request->file)->first();

        // Insert to DB
        
            $db = skripsi::create([
                'nim' => Auth::user()->nim_nip,
                'semester_aktif' => $request->semester_aktif,
                'tanggal_sidang' => $request->tanggal_sidang,
                'status' => 'Lulus',
                'upload_skripsi' => $temp->path,
                'nilai' => $request->nilai_skripsi,
            ]);
            if ($request->status_skripsi == 'Lulus') {
                skripsi::where('nim', Auth::user()->nim_nip)
                    ->where('semester_aktif', $request->semester_aktif)
                    ->update([
                        'nilai' => $request->nilai_skripsi,
                    ]);
            }
        

        tb_entry_progress::where('nim', Auth::user()->nim_nip)
            ->where('semester_aktif', $request->semester_aktif)
            ->update([
                'is_skripsi' => 1,
            ]);

        if ($temp) {
            $uniq = time() . uniqid();
            rename(public_path('files/temp/' . $temp->folder . '/' . $temp->path), public_path('files/skripsi/'  . $db->nim . '_' . $db->semester_aktif . '_' . $uniq . '.pdf'));
            $db->where('nim', Auth::user()->nim_nip)->where('semester_aktif', $request->semester_aktif)->update([
                'upload_skripsi' => 'files/skripsi/' . $db->nim . '_' . $db->semester_aktif . '_' . $uniq . '.pdf'
            ]);
            $temp->delete();
        }

        if ($db->save()) {
            Alert::success('Berhasil', 'Data berhasil disimpan');
            return redirect('/mahasiswa/entry');
        } else {
            Alert::error('Gagal', 'Data gagal disimpan');
            return redirect()->route('skripsi.index');
        }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($semester_aktif, $nim)
    {
        $data = skripsi::where('nim', $nim)->where('semester_aktif', $semester_aktif)->first();
        return view('mahasiswa.skripsi.modal.edit_skripsi', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $semester_aktif)
    {
        // Validate
        $request->validate([
            'confirm' => 'sometimes|accepted',
            'nilai_skripsi' => 'required_if:status_skripsi,Lulus|in:,A,B,C,D,E',
            'tanggal_sidang' => 'required_if:status_skripsi,Lulus',
            'fileEdit' => 'required_if:confirm,on',
        ], [
            'nilai_skripsi.required_if' => 'Nilai Skripsi tidak boleh kosong',
            'nilai_skripsi.in' => 'Nilai Skripsi harus diisi dengan A, B, C, D, E',
            'tanggal_sidang.required_if' => 'Tanggal Sidang tidak boleh kosong',
            'fileEdit.required_if' => 'File tidak boleh kosong',
        ]);

        $db = skripsi::where('semester_aktif', $semester_aktif)->where('nim', $request->nim)->first();

        $temp = temp_file::where('path', $request->fileEdit)->first();

        if ($temp && $request->confirm == 'on') {
            if (skripsi::where('semester_aktif', $semester_aktif)->where('nim', $request->nim)->where('upload_skripsi', '!=', null)->first()) {
                unlink(public_path($db->upload_skripsi));
            }
            $uniq = time() . uniqid();
            rename(public_path('files/temp/' . $temp->folder . '/' . $temp->path), public_path('files/skripsi/' . $db->nim . '_' . $db->semester_aktif . '_' . $uniq . '.pdf'));
            skripsi::where('semester_aktif', $semester_aktif)->where('nim', $request->nim)->update([
                'tanggal_sidang' => $request->tanggal_sidang,
                'status' => 'Lulus',
                'nilai' => $request->nilai_skripsi,
                'upload_skripsi' => 'files/skripsi/' . $db->nim . '_' . $db->semester_aktif . '_' . $uniq . '.pdf'
            ]);
            $temp->delete();
        } else {
            skripsi::where('semester_aktif', $semester_aktif)->where('nim', $request->nim)->update([
                'tanggal_sidang' => $request->tanggal_sidang,
                'status' => 'Lulus',
                'nilai' => $request->nilai_skripsi,
            ]);
        }

        if ($db->update()) {
            tb_entry_progress::where('nim', Auth::user()->nim_nip)->where('semester_aktif', $semester_aktif)->update(['is_skripsi' => 1,'is_verifikasi_skripsi' => 0]);
            Alert::success('Berhasil', 'Data berhasil diubah');
            return redirect('/mahasiswa/data/skripsi');
        } else {
            Alert::error('Gagal', 'Data gagal diubah');
            return redirect('/mahasiswa/data/skripsi');
        }
    }

    public function delete($semester_aktif, $nim)
    {
        $data = skripsi::where('nim', $nim)->where('semester_aktif', $semester_aktif)->first();
        return view('mahasiswa.skripsi.modal.delete_skripsi', compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($semester_aktif, $nim)
    {
        skripsi::where('nim', $nim)->where('semester_aktif', $semester_aktif)->delete();

        // Update is_khs menjadi 0
        tb_entry_progress::where('nim', $nim)
        ->where('semester_aktif', $semester_aktif)
        ->update(['is_skripsi' => 0]);

        // Alert success
        Alert::success('Success!', 'Data Skripsi berhasil dihapus');
        return redirect()->route('data_skripsi');
    }
}
