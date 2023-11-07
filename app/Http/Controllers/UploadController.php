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

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $name = $file->getClientOriginalName();
            $file->move('files/temp/' . '', $name);

            if (temp_file::where('path', $name)->first() == null) {
                temp_file::create([
                    'folder' => '',
                    'path' => $name,
                ]);
            }

            return $name;
        }

        if ($request->hasFile('fileEdit')) {
            $file = $request->file('fileEdit');
            $name = $file->getClientOriginalName();
            $file->move('files/temp/' . '', $name);

            if (temp_file::where('path', $name)->first() == null) {
                temp_file::create([
                    'folder' => '',
                    'path' => $name,
                ]);
            }

            return $name;
        }

        if ($request->hasFile('fileProfile')) {
            $file = $request->file('fileProfile');
            $name = $file->getClientOriginalName();
            $file->move('files/temp/' . '', $name);

            if (temp_file::where('path', $name)->first() == null) {
                temp_file::create([
                    'folder' => '',
                    'path' => $name,
                ]);
            }

            return $name;
        }
    }
}
