<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\dosen;
use App\Models\kab;
use App\Models\prov;
use App\Models\temp_file;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;

class EditProfileDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dosen = dosen::where('nip', Auth::user()->nim_nip)->first();
        $provinsi = prov::all();
        $kabupaten = kab::where('kode_prov', $dosen->kode_prov)->get();

        return view('dosen.edit_profile', [
            'title' => 'Edit Profile',
        ])->with(compact('dosen', 'provinsi', 'kabupaten'));
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
        //
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
    public function edit($id)
    {
        //
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
        // Validate
        $request->validate([
            'fileProfile' =>
            [
                // required if fileProfile null
                Rule::requiredIf(function () {
                    return dosen::where('nip', Auth::user()->nim_nip)->first()->foto == null;
                }),
            ],
            'nama' => 'required|string',
            'nip' => 'required',
            'status' => 'required',
            'handphone' => 'required|numeric',
            'email' =>
            [
                'required', 'email', 'max:255', Rule::unique('users')->ignore($id, 'nim_nip'),
            ],
            'alamat' => 'required',
            'provinsi' => 'required|exists:provs,kode_prov',
            'kabupatenkota' => 'required|exists:kabs,kode_kab',
        ], [
            'fileProfile.required' => 'Foto profile harus diisi.',
            'nama.required' => 'Nama harus diisi.',
            'nip.required' => 'NIP harus diisi.',
            'status.required' => 'Status harus diisi.',
            'handphone.required' => 'No. Handphone harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'alamat.required' => 'Alamat harus diisi.',
            'provinsi.required' => 'Provinsi harus diisi.',
            'provinsi.exists' => 'Provinsi tidak terdaftar.',
            'kabupatenkota.required' => 'Kabupaten/Kota harus diisi.',
            'kabupatenkota.exists' => 'Kabupaten/Kota tidak terdaftar.',
        ]);

        $temp = temp_file::where('path', $request->fileProfile)->first();

        // Update to DB
        dosen::where('nip', $id)->update([
            'nama' => $request->nama,
            'handphone' => $request->handphone,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'kode_prov' => $request->provinsi,
            'kode_kab' => $request->kabupatenkota,
        ]);
        User::where('nim_nip', $id)->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        if ($temp && $request->fileProfile != null) {
            if (dosen::where('nip', $id)->first()->foto != null) {
                unlink(dosen::where('nip', $id)->first()->foto);
            }
            $uniq = time() . uniqid();
            rename(public_path('files/temp/' . $temp->path), public_path('files/profile/' . $id . '_' . $uniq . '.jpg'));
            dosen::where('nip', $id)->update([
                'foto' => 'files/profile/' . $id . '_' . $uniq . '.jpg',
            ]);
            $temp->delete();
        }

        Alert::success('Berhasil', 'Data berhasil disimpan');
        if ($request->fileProfile != null) {
            return redirect()->route('home');
        } else {
            return redirect()->route('edit_profile_dosen.index');
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
        //
    }
}
