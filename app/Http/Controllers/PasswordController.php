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
use App\Models\prov;
use App\Models\skripsi;
use App\Models\temp_file;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class PasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('nim_nip',  Auth::user()->nim_nip)->first();
        $dosen = dosen::where('nip',  Auth::user()->nim_nip)->first();
        $mahasiswa = mahasiswa::where('nim',  Auth::user()->nim_nip)->first();
        $departemen = User::where('nim_nip',  Auth::user()->nim_nip)->first();
        $operator = User::where('nim_nip',  Auth::user()->nim_nip)->first();
        return view('change_password.index', [
            'title' => 'Change Password',
        ])->with(compact('user', 'dosen', 'mahasiswa', 'departemen', 'operator'));
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
            // olf password must same with password in database
            'old_password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('Password lama tidak sama');
                    }
                },
            ],
            'new_password' => 'required|string',
            'ver_password' => 'required|string|same:new_password',
        ], [
            'old_password.required' => 'Password lama tidak boleh kosong',
            'new_password.required' => 'Password baru tidak boleh kosong',
            'ver_password.required' => 'Verifikasi password tidak boleh kosong',
            'ver_password.same' => 'Verifikasi password tidak sama dengan password baru',
        ]);


        User::where('nim_nip', $id)->update([
            'password' => bcrypt($request->new_password),
        ]);

        Alert::success('Berhasil', 'Data berhasil disimpan');
        return redirect()->route('change_password.index');
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
