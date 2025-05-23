<?php

namespace App\Http\Controllers;

use App\Traits\RulesTraits;
use Exception;
use Carbon\Carbon;
use App\Models\BeritaModel;
use App\Traits\CacheTimeout;
use Illuminate\Http\Request;
use App\Events\DashboardMediaEvent;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Auth\BeritaResources;

class BeritaController extends Controller
{
    use CacheTimeout, RulesTraits;
    public function showMonitoring()
    {
        try {
            $berita = Cache::remember('berita_data_in_monitoring', $this->time, function () {
                return BeritaModel::get();
            });

            return view('after-login.berita.index')
                ->with(['berita' => BeritaResources::collection($berita)]);

        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Show Monitoring',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }


    }
