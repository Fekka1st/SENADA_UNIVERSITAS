<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('safe_image_url')) {
    function safe_image_url($filename, $folder = 'logo', $fallback = 'images/logo.png', $addTimestamp = false)
    {
        if (!$filename) {
            return asset($fallback);
        }

        $fullPath = public_path("storage/{$folder}/{$filename}");

        if (file_exists($fullPath)) {
            $url = asset("storage/{$folder}/{$filename}");

            // Selalu tambahkan timestamp untuk avatar agar tidak ter-cache
            if ($addTimestamp || $folder === 'foto_user') {
                $url .= '?t=' . filemtime($fullPath);
            }

            return $url;
        }

        return asset($fallback);
    }
}

if (!function_exists('hexToRgb')) {
    /**
     * Convert hex color to RGB values
     *
     * @param string $hex Hex color code (e.g., #ff0000)
     * @return string RGB values separated by comma (e.g., 255, 0, 0)
     */
    function hexToRgb($hex)
    {
        // Remove # if present
        $hex = ltrim($hex, '#');

        // Handle 3-digit hex codes
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        // Convert to decimal
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return "$r, $g, $b";
    }
}

if (!function_exists('lighten_color')) {
    /**
     * Lighten a hex color by a percentage
     *
     * @param string $hex Hex color code
     * @param int $percent Percentage to lighten (0-100)
     * @return string Lightened hex color
     */
    function lighten_color($hex, $percent)
    {
        // Remove # if present
        $hex = ltrim($hex, '#');

        // Handle 3-digit hex codes
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        // Convert to decimal
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Calculate lightened values
        $r = min(255, $r + (255 - $r) * $percent / 100);
        $g = min(255, $g + (255 - $g) * $percent / 100);
        $b = min(255, $b + (255 - $b) * $percent / 100);

        // Convert back to hex
        return sprintf('#%02x%02x%02x', round($r), round($g), round($b));
    }
}

if (!function_exists('darken_color')) {
    /**
     * Darken a hex color by a percentage
     *
     * @param string $hex Hex color code
     * @param int $percent Percentage to darken (0-100)
     * @return string Darkened hex color
     */
    function darken_color($hex, $percent)
    {
        // Remove # if present
        $hex = ltrim($hex, '#');

        // Handle 3-digit hex codes
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        // Convert to decimal
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Calculate darkened values
        $r = max(0, $r - $r * $percent / 100);
        $g = max(0, $g - $g * $percent / 100);
        $b = max(0, $b - $b * $percent / 100);

        // Convert back to hex
        return sprintf('#%02x%02x%02x', round($r), round($g), round($b));
    }

    if (!function_exists('formatBytes')) {
        function formatBytes($bytes, $precision = 2)
        {
            $units = ['B', 'KB', 'MB', 'GB', 'TB'];

            $bytes = max($bytes, 0);
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
            $pow = min($pow, count($units) - 1);

            $bytes /= pow(1024, $pow);

            return round($bytes, $precision) . ' ' . $units[$pow];
        }
    }
}
