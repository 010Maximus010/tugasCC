<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\dosen;
use App\Models\mahasiswa;
use Illuminate\Support\Facades\Auth;

class AddUserController extends Controller
{
    public function index()
    {
        $mahasiswa = mahasiswa::where('nim', Auth::user()->nim_nip)->first();
        $dosen_wali = dosen::all();
        
        return view('operator.tambah_user.index', [
            'title' => 'Add User',
        ])->with(compact('mahasiswa', 'dosen_wali'));
    }

    public function storeMahasiswa(Request $request)
    {
        $request->validate([
            'nim' => 'required|numeric',
            'nama' => 'required|string',
            'dosen_wali' => 'required|exists:dosens,nip', // Memastikan bahwa dosen wali yang dipilih ada dalam tabel dosen
            // ... (validasi lainnya)
        ]);

        $request->merge(['status' => 'Aktif']);

        return redirect('/operator')->with('success', 'Mahasiswa berhasil ditambahkan');
    }
}


