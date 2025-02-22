<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

function isRouteActive($route)
{
    return request()->route()->getName() === $route;
}

function month($index)
{
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

function isAdmin()
{
    $role = auth()->user()->role;
    return $role == 'admin';
}

function isSarana()
{
    $role = auth()->user()->role;
    return $role == 'sarana';
}

function isStaff()
{
    $role = auth()->user()->role;
    return $role == 'admin-csr' || $role == 'admin-comrel'|| $role == 'admin-staf4' || $role == 'admin-staf5' || $role == 'admin-staf6' ;
}

function isManager()
{
    return auth()->user()->role == 'am';
}

function isAksesPengguna(){
    $role = auth()->user()->role;
    return $role == 'am' || $role == 'mgr-adm';
}

function isNonSarana(){
    $role = auth()->user()->role;
    return $role == 'admin' || $role == 'admin-csr' || $role == 'admin-comrel' || $role == 'admin-staf4' || $role == 'admin-staf5' || $role == 'admin-staf6'  || $role == 'am' || $role == 'mgr-adm' ||$role == 'avp-adm' || $role == 'dhak';
}

function isMgrAdm(){
    return auth()->user()->role == 'mgr-adm';
}

function isAVPAdm(){
    return auth()->user()->role == 'avp-adm';
}

function isDHAK(){
    return auth()->user()->role == 'dhak';
}

function isAllAdmin()
{
    $role = auth()->user()->role;
    return $role == 'admin' || $role == 'admin-csr' || $role == 'admin-comrel' || $role == 'admin-staf4' || $role == 'admin-staf5' || $role == 'admin-staf6'  || $role == 'am' || $role == 'mgr-adm' ||$role == 'avp-adm' || $role == 'dhak' || $role = 'sarana';
}

function isAllnonUser(){
    $role = auth()->user()->role;
    return $role == 'admin-csr' || $role == 'admin-comrel' || $role == 'admin-staf4' || $role == 'admin-staf5' || $role == 'admin-staf6' || $role == 'am' || $role == 'mgr-adm' || $role == 'avp-adm' || $role == 'dhak' ;
}


function roles($role)
{
    switch (strtolower($role)) {
        case 'am':
            return "Staf Adm 1";
        case 'gm':
            return "General Manager";
        case 'admin-csr':
            return "Staf Adm 3";
        case 'admin-comrel':
            return "Staf Adm 2";
        case 'admin-staf4':
            return "Staf Adm 4";
        case 'admin-staf5':
            return "Staf Adm 5";
        case 'admin-staf6':
            return "Staf Adm 6";
        case 'mgr-adm' :
            return "Manager Adm";
        case 'avp-adm' :
            return "AVP Adm";
        case 'dhak' :
            return "DHAK";
        case 'sarana' :
            return "Sarana";
        default:
            return "User";
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

function isManagerSection($lastOfRiwayat)
{
    return ($lastOfRiwayat->status === 'diajukan' || $lastOfRiwayat->status === 'proses') && $lastOfRiwayat->peninjau === auth()->user()->role && $lastOfRiwayat->tindakan === 1 && auth()->user()->role && auth()->user()->role === 'am';
}

function isStaffSection($lastOfRiwayat)
{
    return isset($lastOfRiwayat->status, $lastOfRiwayat->peninjau, $lastOfRiwayat->tindakan) &&
    $lastOfRiwayat->status === 'proses' &&
    $lastOfRiwayat->peninjau === auth()->user()->role &&
    $lastOfRiwayat->tindakan === 1 &&
    in_array(auth()->user()->role, ['admin-csr', 'admin-comrel', 'admin-staf4', 'admin-staf5', 'admin-staf6']);
}


function isMgrAdmSection($lastOfRiwayat){
    return ($lastOfRiwayat->status === 'proses') && $lastOfRiwayat->peninjau === auth()->user()->role && $lastOfRiwayat->tindakan === 1 && auth()->user()->role && auth()->user()->role === 'mgr-adm';
}

function isAVPAdmSection($lastOfRiwayat){
    return ($lastOfRiwayat->status === 'proses') && $lastOfRiwayat->peninjau === auth()->user()->role && $lastOfRiwayat->tindakan === 1 && auth()->user()->role && auth()->user()->role === 'avp-adm';
}

function isDHAKSection($lastOfRiwayat){
    return ($lastOfRiwayat->status === 'proses') && $lastOfRiwayat->peninjau === auth()->user()->role && $lastOfRiwayat->tindakan === 1 && auth()->user()->role && auth()->user()->role === 'dhak';
}

function isSaranaSection($lastOfRiwayat){
    return ($lastOfRiwayat->status === 'proses') && $lastOfRiwayat->peninjau === auth()->user()->role && $lastOfRiwayat->tindakan === 1 && auth()->user()->role && auth()->user()->role === 'sarana';
}

function isUserSection($lastOfRiwayat) {
    return ($lastOfRiwayat->status === 'ditolak') && $lastOfRiwayat->peninjau === auth()->user()->role && $lastOfRiwayat->tindakan === 1 && auth()->user()->role && auth()->user()->role === 'admin';
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
    return strtolower($status_ve) === 'non-verify';
}

// function isStatusVerifikasiSudah($status_verifikasi){
//     return strtolower($status_verifikasi) === 'sudah-verifikasi';
// }

// function isStatusVerifikasiBelum($status_verifikasi){
//     return strtolower($status_verifikasi) === 'belum-verifikasi';
// }



function checkNumber($number)
{
    if (substr($number, 0, 1) === '0') {
        return "+62" . ltrim($number, '0');
    } else {
        return $number;
    }
}

function isProposal($jenis)
{
    return strtolower($jenis) === 'proposal';
}

function isUMD($jenis){
    return strtolower($jenis) === 'umd';
}

function isReim($jenis){
    return strtolower($jenis) === 'reim';
}

function isBaru($jenis){
    return strtolower($jenis) === 'baru';
}

function isGanti($jenis){
    return strtolower($jenis) === 'ganti';
}

function isKembalikan($jenis){
    return strtolower($jenis) === 'kembalikan';
}

function isMelayat($jenis){
    return strtolower($jenis) === 'melayat';
}

function isSakit($jenis){
    return strtolower($jenis) === 'sakit';
}

function isDinas($jenis){
    return strtolower($jenis) === 'dinas';
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

function removeProposalWord($string)
{
    return Str::replace('proposal', '', strtolower($string));
}

function validatorError($errors)
{
    $errorMessage = "";

    foreach ($errors as $value) {
        $errorMessage .= $value . "\n";
    }

    return $errorMessage;
}
