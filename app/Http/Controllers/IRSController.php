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
use Illuminate\Support\Facades\Storage;

class IRSController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('irs', ['only' => ['index']]);
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
        $irs = irs::where('nim', Auth::user()->nim_nip)->get();
        return view('mahasiswa.irs.entry', [
            'title' => 'Entry IRS',
        ])->with(compact('mahasiswa', 'irs', 'progress'));
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
        $irs = irs::where('nim', Auth::user()->nim_nip)->get();
        return view('mahasiswa.irs.index', [
            'title' => 'IRS',
        ])->with(compact('mahasiswa', 'irs', 'progress'));
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
            'semester_aktif' => 'required|unique:irs,semester_aktif,NULL,id,nim,' . Auth::user()->nim_nip,
            'jumlah_sks' => 'required|numeric|between:1,24',
            'file' => 'required',
        ], [
            'semester_aktif.required' => 'Semester Aktif tidak boleh kosong',
            'semester_aktif.unique' => 'Anda sudah mengisi IRS semester ini',
            'jumlah_sks.required' => 'Jumlah SKS tidak boleh kosong',
            'jumlah_sks.numeric' => 'Jumlah SKS harus berupa angka',
            'jumlah_sks.between' => 'Jumlah SKS harus antara 1 - 24',
            'file.required' => 'File tidak boleh kosong',
        ]);

        $temp = temp_file::where('path', $request->file)->first();

        // Insert to DB
        $db = irs::create([
            'nim' => Auth::user()->nim_nip,
            'semester_aktif' => $request->semester_aktif,
            'sks' => $request->jumlah_sks,
            'upload_irs' => $request->file,
        ]);

        tb_entry_progress::where('nim', Auth::user()->nim_nip)
            ->where('semester_aktif', $request->semester_aktif)
            ->update([
                'is_irs' => 1,
            ]);

        if ($temp) {
            $uniq = time() . uniqid();
            rename(public_path('files/temp/' . $temp->folder . '/' . $temp->path), public_path('files/irs/' . $db->nim . '_' . $db->semester_aktif . '_' . $uniq . '.pdf'));
            $db->where('nim', Auth::user()->nim_nip)->where('semester_aktif', $request->semester_aktif)->update([
                'upload_irs' => 'files/irs/' . $db->nim . '_' . $db->semester_aktif . '_' . $uniq . '.pdf'
            ]);
            $temp->delete();
        }

        if ($db->save()) {
            Alert::success('Berhasil', 'Data berhasil disimpan');
            return redirect()->route('irs.index');
        } else {
            Alert::error('Gagal', 'Data gagal disimpan');
            return redirect()->route('irs.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(irs $irs)
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
        $data = irs::where('nim', $nim)->where('semester_aktif', $semester_aktif)->first();
        return view('mahasiswa.irs.modal.edit_irs', compact('data'));
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
            'jumlah_sks' => 'required|numeric|between:1,24',
            'confirm' => 'sometimes|accepted',
            'fileEdit' => 'required_if:confirm,on',
        ], [
            'jumlah_sks.required' => 'Jumlah SKS tidak boleh kosong',
            'jumlah_sks.numeric' => 'Jumlah SKS harus berupa angka',
            'jumlah_sks.between' => 'Jumlah SKS harus antara 1 - 24',
            'confirm.accepted' => 'Konfirmasi harus di ceklis',
            'fileEdit.required_if' => 'File tidak boleh kosong',
        ]);

        $db = irs::where('semester_aktif', $semester_aktif)->where('nim', $request->nim)->first();

        $temp = temp_file::where('path', $request->fileEdit)->first();

        if ($temp && $request->confirm == 'on') {
            $uniq = time() . uniqid();
            rename(public_path('files/temp/' . $temp->folder . '/' . $temp->path), public_path('files/irs/' . $db->nim . '_' . $db->semester_aktif . '_' . $uniq . '.pdf'));
            irs::where('semester_aktif', $semester_aktif)->where('nim', $request->nim)->update([
                'sks' => $request->jumlah_sks,
                'upload_irs' => 'files/irs/' . $db->nim . '_' . $db->semester_aktif  . '_' . $uniq . '.pdf'
            ]);
            // update khs all
            for ($i = $semester_aktif; $i <= khs::where('nim', $request->nim)->max('semester_aktif'); $i++) {
                khs::where('nim', $request->nim)->where('semester_aktif', $i)->update([
                    'sks' => irs::where('nim', $request->nim)->where('semester_aktif', $i)->first()->sks,
                    'sks_kumulatif' => khs::where('nim', $request->nim)->where('semester_aktif', $i)->first()->sks_kumulatif - $db->sks + $request->jumlah_sks,
                ]);
            }
            $temp->delete();
            unlink(public_path($db->upload_irs));
        } else {
            irs::where('semester_aktif', $semester_aktif)->where('nim', $request->nim)->update([
                'sks' => $request->jumlah_sks,
            ]);
            // update khs all
            for ($i = $semester_aktif; $i <= khs::where('nim', $request->nim)->max('semester_aktif'); $i++) {
                khs::where('nim', $request->nim)->where('semester_aktif', $i)->update([
                    'sks' => irs::where('nim', $request->nim)->where('semester_aktif', $i)->first()->sks,
                    'sks_kumulatif' => khs::where('nim', $request->nim)->where('semester_aktif', $i)->first()->sks_kumulatif - $db->sks + $request->jumlah_sks,
                ]);
            }
        }

        if ($db->update()) {
            Alert::success('Berhasil', 'Data berhasil diubah');
            return redirect('/mahasiswa/data/irs');
        } else {
            Alert::error('Gagal', 'Data gagal diubah');
            return redirect('/mahasiswa/data/irs');
        }
    }

    public function delete($semester_aktif, $nim)
    {
        $data = irs::where('nim', $nim)->where('semester_aktif', $semester_aktif)->first();
        return view('mahasiswa.irs.modal.delete_irs', compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($semester_aktif, $nim)
    {
        irs::where('nim', $nim)->where('semester_aktif', $semester_aktif)->delete();

        // Alert success
        Alert::success('Success!', 'Data IRS berhasil dihapus');
        return redirect()->route('data_irs');
    }

}
