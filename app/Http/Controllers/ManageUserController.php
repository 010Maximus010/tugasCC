<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\dosen;
use App\Models\mahasiswa;
use App\Models\irs;
use App\Models\khs;
use App\Models\pkl;
use App\Models\skripsi;
use App\Models\temp_file;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ManageUserController extends Controller
{
    public function index()
    {
        $mahasiswa = mahasiswa::all();
        $dosen = dosen::all();
        return view('operator.manage_users.index', [
            'title' => 'Manage Users',
        ])->with(compact('mahasiswa', 'dosen'));
    }
}
