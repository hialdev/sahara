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