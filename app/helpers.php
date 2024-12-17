<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting($key)
    {
        $setting = Setting::where('the_key', $key)->first();
        return $setting->the_value;
    }
}