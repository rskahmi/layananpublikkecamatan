<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

function isRouteActive($route) {
    return request()->route()->getName() === $route;
}

function month($index) {
    $indoMonthNames = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];
    return $indoMonthNames[$index - 1];
}

function format_dfy($date)
{
    $carbon = Carbon::parse($date);
    return $carbon->format('j') . ' ' . month($carbon->month) . ' ' . $carbon->format('Y');
}

function format_dfh($timestamp)
{
    $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp);

    $formattedDate = $carbon->format('j') . ' ' . month($carbon->month) . ' ' . $carbon->format('y');

    return $formattedDate;
}

function format_time($timestamp)
{
    $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp);
    $formattedTime = $carbon->format('H:i');

    return $formattedTime;
}

function formatRupiah($amount)
{
    return str_replace(':amount', number_format($amount), trans('currency.money'));
}

function formatRibuan($angka)
{
    return number_format($angka);
}

function isMasyarakat()
{
    $role = auth()->user()->role;
    return $role == 'masyarakat';
}

function isPetugasAdministrasi()
{
    return auth()->user()->role == 'petugasadministrasi';
}

function isKepalaSeksi(){
    return auth()->user()->role == 'kepalaseksi';
}

function isSekretarisCamat(){
    return auth()->user()->role == 'sekretariscamat';
}

function isCamat(){
    return auth()->user()->role == 'camat';
}

function isAllnonMasyarakat(){
    $role = auth()->user()->role;
    return $role == 'petugasadministrasi' || $role == 'kepalaseksi' || $role == 'sekretariscamat' || $role == 'camat' ;
}

function isAll(){
    $role = auth()->user()->role;
    return $role == 'masyarakat' || 'petugasadministrasi' || $role == 'kepalaseksi' || $role == 'sekretariscamat' || $role == 'camat' ;

}


function roles($role)
{
    switch (strtolower($role)) {
        case 'petugasadministrasi':
            return "Petugas Administrasi";
        case 'kepalaseksi' :
            return "Kepala Seksi";
        case 'sekretariscamat' :
            return "Sekretaris Camat";
        case 'camat' :
            return "Camat";
        default:
            return "Masyarakat";
    }
}

function limitCharacters($words, $limit)
{
    return strlen($words) > $limit ? substr($words, 0, $limit) . '...' : $words;
}

function isLimit($words, $limit)
{
    return strlen($words) > $limit;
}


function isFileExists($path, $default)
{
    $file = file_exists($path);

    if ($file) {
        return asset($path);
    } else {
        return $default;
    }
}

function isPetugasAdministrasiSection($lastOfRiwayat)
{
    return ($lastOfRiwayat->status === 'diajukan' || $lastOfRiwayat->status === 'proses') && $lastOfRiwayat->peninjau === auth()->user()->role && $lastOfRiwayat->tindakan === 1 && auth()->user()->role && auth()->user()->role === 'petugasadministrasi';
}

function isKepalaSeksiSection($lastOfRiwayat){
    return ($lastOfRiwayat->status === 'proses') && $lastOfRiwayat->peninjau === auth()->user()->role && $lastOfRiwayat->tindakan === 1 && auth()->user()->role && auth()->user()->role === 'kepalaseksi';
}

function isSekretarisCamatSection($lastOfRiwayat)
{
    return (
        ($lastOfRiwayat->status === 'proses' || $lastOfRiwayat->status === 'diajukan') &&
        $lastOfRiwayat->peninjau === auth()->user()->role &&
        $lastOfRiwayat->tindakan === 1 &&
        auth()->user()->role === 'sekretariscamat'
    );
}

function isCamatSection($lastOfRiwayat){
    return ($lastOfRiwayat->status === 'proses') && $lastOfRiwayat->peninjau === auth()->user()->role && $lastOfRiwayat->tindakan === 1 && auth()->user()->role && auth()->user()->role === 'camat';
}

function isMasyarakatSection($lastOfRiwayat) {
    return ($lastOfRiwayat->status === 'ditolak') && $lastOfRiwayat->peninjau === auth()->user()->role && $lastOfRiwayat->tindakan === 1 && auth()->user()->role && auth()->user()->role === 'masyarakat';
}

function isStatusDiterima($status)
{
    return strtolower($status) === 'diterima';
}

function isStatusDiajukan($status)
{
    return strtolower($status) === 'diajukan';
}
function isStatusProses($status)
{
    return strtolower($status) === 'proses';
}
function isStatusDitolak($status)
{
    return strtolower($status) === 'ditolak';
}

function isStatusVerify($status)
{
    return strtolower($status) === 'verify';
}

function isStatusNonVerify($status)
{
    return strtolower($status) === 'non-verify';
}

function checkNumber($number)
{
    if (substr($number, 0, 1) === '0') {
        return "+62" . ltrim($number, '0');
    } else {
        return $number;
    }
}

function isBBM($jenis){
    return strtolower($jenis) == 'bbm';
}

function isKTP($jenis){
    return strtolower($jenis) == 'ktp';
}

function isKK($jenis){
    return strtolower($jenis) == 'kk';
}

function isSKTM($jenis){
    return strtolower($jenis) == 'sktm';
}

function removeComma($data)
{
    return doubleval(str_replace(',', '', $data));
}

function parseToPercentage($value, $max)
{
    return $value === 0 ? 0 : $value / $max * 100;
}

function getDomainOnly($url)
{
    $parsedUrl = parse_url($url);

    if (isset($parsedUrl['host'])) {
        return $parsedUrl['host'];
    }

    return '';
}

function deleteFile($path)
{
    if (Storage::exists($path)) {
        Storage::delete($path);
    }
}

function generateFileName($originalName)
{
    return time() . '-' . str_replace(' ', '-', $originalName);
}

function validatorError($errors)
{
    $errorMessage = "";

    foreach ($errors as $value) {
        $errorMessage .= $value . "\n";
    }

    return $errorMessage;
}
