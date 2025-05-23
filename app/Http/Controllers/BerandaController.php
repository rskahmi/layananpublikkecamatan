<?php

namespace App\Http\Controllers;

use App\Traits\RulesTraits;
use Exception;
use Carbon\Carbon;
use App\Models\RilisModel;
use App\Traits\CacheTimeout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\ProgramUnggulanModel;

class BerandaController extends Controller
{
    public function index() {
        $berita = RilisModel::paginate(6);
        $program_unggulan = ProgramUnggulanModel::paginate(6);

        return view('before-login.beranda')->with([
            'berita' => $berita,
            'program_unggulan' => $program_unggulan
        ]);
    }

}
