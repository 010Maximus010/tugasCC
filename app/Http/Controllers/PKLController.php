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

class PKLController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('pkl', ['only' => ['index']]);
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
        $pkl = pkl::where('nim', Auth::user()->nim_nip)->get();
        return view('mahasiswa.pkl.entry', [
            'title' => 'Entry PKL',
        ])->with(compact('mahasiswa', 'pkl', 'progress'));
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
        $pkl = pkl::where('nim', Auth::user()->nim_nip)->get();
        return view('mahasiswa.pkl.index', [
            'title' => 'PKL',
        ])->with(compact('mahasiswa', 'pkl', 'progress'));
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
        // Validate
        $request->validate([
            'semester_aktif' => 'required|unique:pkls,semester_aktif,NULL,id,nim,' . Auth::user()->nim_nip,
            'status_pkl' => 'required|in:,Lulus,Tidak Lulus',
            'nilai_pkl' => 'required_if:status_pkl,Lulus|in:,A,B,C,D,E',
            'file' => 'required',
        ], [
            'semester_aktif.required' => 'Semester Aktif tidak boleh kosong',
            'semester_aktif.unique' => 'Semester Aktif sudah ada',
            'status_pkl.required' => 'Status PKL tidak boleh kosong',
            'status_pkl.in' => 'Status PKL tidak valid',
            'nilai_pkl.required_if' => 'Nilai PKL tidak boleh kosong',
            'nilai_pkl.in' => 'Nilai PKL tidak valid',
            'file.required' => 'File tidak boleh kosong',
        ]);

        if ($request->status_pkl != 'Lulus' && $request->nilai_pkl != null) {
            Alert::error('Gagal', 'Nilai PKL hanya bisa diisi jika status PKL adalah Lulus');
            return redirect()->back();
        }

        $temp = temp_file::where('path', $request->file)->first();

        // Insert to DB
       
            $db = pkl::create([
                'nim' => Auth::user()->nim_nip,
                'semester_aktif' => $request->semester_aktif,
                'status' => $request->status_pkl,
                'upload_pkl' => $temp->path,
            ]);
            if ($request->status_pkl == 'Lulus') {
                pkl::where('nim', Auth::user()->nim_nip)
                    ->where('semester_aktif', $request->semester_aktif)
                    ->update([
                        'nilai' => $request->nilai_pkl,
                    ]);
            }
        

        tb_entry_progress::where('nim', Auth::user()->nim_nip)
            ->where('semester_aktif', $request->semester_aktif)
            ->update([
                'is_pkl' => 1,
            ]);

        if ($temp) {
            $uniq = time() . uniqid();
            rename(public_path('files/temp/' . $temp->folder . '/' . $temp->path), public_path('files/pkl/' . $db->nim . '_' . $db->semester_aktif . '_' . $uniq . '.pdf'));
            $db->where('nim', Auth::user()->nim_nip)->where('semester_aktif', $request->semester_aktif)->update([
                'upload_pkl' => 'files/pkl/' . $db->nim . '_' . $db->semester_aktif . '_' . $uniq . '.pdf'
            ]);
            $temp->delete();
        }

        if ($db->save()) {
            Alert::success('Berhasil', 'Data berhasil disimpan');
            return redirect()->route('skripsi.index');
        } else {
            Alert::error('Gagal', 'Data gagal disimpan');
            return redirect()->route('pkl.index');
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
        $data = pkl::where('nim', $nim)->where('semester_aktif', $semester_aktif)->first();
        return view('mahasiswa.pkl.modal.edit_pkl', compact('data'));
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
            'status_pkl' => 'required|in:Lulus,Tidak Lulus',
            'nilai_pkl' => 'required_if:status_pkl,Lulus|in:,A,B,C,D,E',
            'fileEdit' => 'required',
        ], [
            'status_pkl.required' => 'Status PKL tidak boleh kosong',
            'status_pkl.in' => 'Status PKL tidak valid',
            'nilai_pkl.required_if' => 'Nilai PKL tidak boleh kosong',
            'nilai_pkl.in' => 'Nilai PKL tidak valid',
            'fileEdit.required' => 'File tidak boleh kosong',
        ]);

        if ($request->status_pkl != 'Lulus' && $request->nilai_pkl != null) {
            Alert::error('Gagal', 'Nilai PKL hanya bisa diisi jika status PKL adalah Lulus');
            return redirect()->back();
        }

        $db = pkl::where('semester_aktif', $semester_aktif)->where('nim', $request->nim)->first();

        $temp = temp_file::where('path', $request->file)->first();

            if (pkl::where('semester_aktif', $semester_aktif)->where('nim', $request->nim)->where('upload_pkl', '!=', NULL)->first()) {
                unlink(public_path($db->upload_pkl));
            }
            $uniq = time() . uniqid();
            rename(public_path('files/temp/' . $temp->folder . '/' . $temp->path), public_path('files/pkl/' . $db->nim . '_' . $db->semester_aktif . '_' . $uniq . '.pdf'));
            pkl::where('semester_aktif', $semester_aktif)->where('nim', $request->nim)->update([
                'status' => $request->status_pkl,
                'nilai' => $request->nilai_pkl,
                'upload_pkl' => 'files/pkl/' . $db->nim . '_' . $db->semester_aktif  . '_' . $uniq . '.pdf'
            ]);
            $temp->delete();
        

        if ($db->update()) {
            Alert::success('Berhasil', 'Data berhasil diubah');
            return redirect('/mahasiswa/data/pkl');
        } else {
            Alert::error('Gagal', 'Data gagal diubah');
            return redirect('/mahasiswa/data/pkl');
        }
    }

    public function delete($semester_aktif, $nim)
    {
        $data = pkl::where('nim', $nim)->where('semester_aktif', $semester_aktif)->first();
        return view('mahasiswa.pkl.modal.delete_pkl', compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($semester_aktif, $nim)
    {
        pkl::where('nim', $nim)->where('semester_aktif', $semester_aktif)->delete();

        // Alert success
        Alert::success('Success!', 'Data PKL berhasil dihapus');
        return redirect()->route('data_pkl');
    }
}
