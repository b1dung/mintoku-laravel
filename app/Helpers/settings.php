<?php
if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        return \App\Models\Setting::where('key', $key)->value('value') ?? $default;
    }
}
