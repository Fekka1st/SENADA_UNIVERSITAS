<?php

namespace App\Helpers;

class ImageHelper 
{
    /**
     * Get safe image URL with fallback
     */
    public static function getSafeImageUrl($filename, $folder = 'logo', $fallback = 'images/logo.png')
    {
        if (!$filename) {
            return asset($fallback);
        }
        
        $fullPath = public_path("storage/{$folder}/{$filename}");
        
        if (file_exists($fullPath)) {
            return asset("storage/{$folder}/{$filename}");
        }
        
        return asset($fallback);
    }
    
    /**
     * Get user avatar with fallback
     */
    public static function getUserAvatar($filename)
    {
        return self::getSafeImageUrl($filename, 'foto_user', 'images/avatar.png');
    }
    
    /**
     * Get logo pengaturan with fallback
     */
    public static function getLogoPengaturan($filename)
    {
        return self::getSafeImageUrl($filename, 'logo', 'images/logo.png');
    }
}
