<?php

namespace App\Http\Controllers;

use App\Traits\RulesTraits;
use Exception;
use Carbon\Carbon;
use App\Models\PengumumanModel;
use App\Traits\CacheTimeout;
use Illuminate\Http\Request;
use App\Events\DashboardMediaEvent;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Auth\PengumumanResources;


class PengumumanController extends Controller
{
    use CacheTimeout, RulesTraits;
    public function showMonitoring()
    {
        try {
            $pengumuman = Cache::remember('pengumuman_data_in_monitoring', $this->time, function () {
                return PengumumanModel::get();
            });

            return view('after-login.pengumuman.index')
                ->with(['pengumuman' => PengumumanResources::collection($pengumuman)]);

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

