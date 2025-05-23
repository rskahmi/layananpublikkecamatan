<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramUnggulanModel;

class KegiatanController extends Controller
{
    public function program()
    {
        $program_unggulan = ProgramUnggulanModel::paginate(3);
        return view('before-login.kegiatan', compact('program_unggulan'));
    }
}
