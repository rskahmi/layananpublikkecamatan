<?php

namespace App\Traits;
use App\Models\NomorSuratModel;

trait NomorSuratTraits
{
    public function generate_number($status)
    {
        $year = now()->year;
        $month = now()->month;

        $statusCode = $status === 'diterima' ? 'PI' : 'PII';

        $count = NomorSuratModel::count();

        $letterNumber = str_pad($count + 1, 4, '0', STR_PAD_LEFT);

        $formattedLetterNumber = "{$letterNumber}/{$statusCode}/{$month}/{$year}";

        return $formattedLetterNumber;
    }
}
