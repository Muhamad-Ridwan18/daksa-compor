<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class ThemeService
{
    /**
     * Get all theme settings
     */
    public static function getThemeSettings()
    {
        return Cache::remember('theme_settings', 3600, function () {
            return Setting::getAllAsArray();
        });
    }

    /**
     * Get primary color
     */
    public static function getPrimaryColor()
    {
        return Setting::getValue('primary_color', '#D89B30');
    }

    /**
     * Get secondary color
     */
    public static function getSecondaryColor()
    {
        return Setting::getValue('secondary_color', '#4B2E1A');
    }

    /**
     * Get background color
     */
    public static function getBackgroundColor()
    {
        return Setting::getValue('background_color', '#F5F7FA');
    }

    /**
     * Generate dynamic CSS
     */
    public static function generateDynamicCSS()
    {
        $primaryColor = self::getPrimaryColor();
        $secondaryColor = self::getSecondaryColor();
        $backgroundColor = self::getBackgroundColor();

        return "
        :root {
            --primary-color: {$primaryColor};
            --secondary-color: {$secondaryColor};
            --background-color: {$backgroundColor};
        }
        
        .bg-primary { background-color: var(--primary-color) !important; }
        .text-primary { color: var(--primary-color) !important; }
        .border-primary { border-color: var(--primary-color) !important; }
        .bg-secondary { background-color: var(--secondary-color) !important; }
        .text-secondary { color: var(--secondary-color) !important; }
        .bg-background { background-color: var(--background-color) !important; }
        
        .hover\\:bg-primary:hover { background-color: var(--primary-color) !important; }
        .hover\\:text-primary:hover { color: var(--primary-color) !important; }
        .focus\\:ring-primary:focus { --tw-ring-color: var(--primary-color) !important; }
        .focus\\:border-primary:focus { border-color: var(--primary-color) !important; }
        ";
    }

    /**
     * Clear theme cache
     */
    public static function clearCache()
    {
        Cache::forget('theme_settings');
    }

    /**
     * Update theme settings
     */
    public static function updateThemeSettings(array $settings)
    {
        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value);
        }
        
        self::clearCache();
    }
}
