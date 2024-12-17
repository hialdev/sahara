<?php

use App\Models\Setting;
use Illuminate\Support\Carbon;

if (!function_exists('setting')) {
    function setting($key)
    {
        $setting = Setting::where('the_key', $key)->first();
        return $setting->the_value;
    }
}

if (!function_exists('formatTanggal')) {
    function formatTanggal($date) {
        // Set locale ke bahasa Indonesia
        Carbon::setLocale('id');
        // Convert tanggal ke dalam format yang diinginkan
        return Carbon::parse($date)->translatedFormat('d F Y');
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah($angka) {
        // Set locale to Indonesian
        setlocale(LC_MONETARY, 'id_ID');
        $formatted = number_format($angka, 2, ',', '.');
        return 'Rp ' . $formatted;
    }
}

if (!function_exists('getAccountTypes')) {
    function getAccountTypes() {
        $accountTypes = explode(',', env('ACCOUNTING_ACCOUNT_TYPES'));
        return $accountTypes;
    }
}