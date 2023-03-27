<?php

if (!function_exists('xp_to_level')) {
    function xp_to_level($xp)
    {
        for ($i = 0; $i < 101; $i++) {
            if (level_to_xp($i) > $xp) {
                return $i - 1;
            }
        }
        return 100;
    }
}

if (!function_exists('level_to_xp')) {
    function level_to_xp($level)
    {
        return $level + 10 * $level ** 3;
    }
}

if (!function_exists('seconds_until_tick')) {
    // Pass in 0 for previous tick
    function seconds_until_tick($ticks = 1)
    {
        $now = now();
        $next_tick = $now->copy()->addMinutes($ticks)->second(0);
        return $now->diffInSeconds($next_tick);
    }
}
