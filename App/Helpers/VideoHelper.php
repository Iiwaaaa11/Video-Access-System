<?php

namespace App\Helpers;

class VideoHelper
{
    /**
     * Extract YouTube ID from URL
     */
    public static function extractYouTubeId($url)
    {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Extract Vimeo ID from URL
     */
    public static function extractVimeoId($url)
    {
        preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $url, $matches);
        return $matches[1] ?? null;
    }
}