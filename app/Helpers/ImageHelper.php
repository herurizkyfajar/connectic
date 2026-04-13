<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Get foto URL untuk anggota
     * Akan mencoba symlink dulu, jika tidak ada gunakan route
     * 
     * @param \App\Models\Anggota $anggota
     * @param string|null $default Default image jika foto tidak ada
     * @return string
     */
    public static function getAnggotaFotoUrl($anggota, $default = null)
    {
        if (!$anggota || !$anggota->foto) {
            return $default ?: asset('images/default-avatar.png');
        }
        
        // Check if storage symlink exists
        $symlinkPath = public_path('storage');
        
        if (is_link($symlinkPath) || file_exists($symlinkPath . '/anggotas/' . $anggota->foto)) {
            // Symlink works, use asset
            return asset('storage/anggotas/' . $anggota->foto);
        }
        
        // Symlink doesn't work, use route
        return route('anggota.foto', $anggota->id);
    }
    
    /**
     * Check if storage symlink is working
     * 
     * @return bool
     */
    public static function isStorageSymlinkWorking()
    {
        $symlinkPath = public_path('storage');
        return is_link($symlinkPath) || (file_exists($symlinkPath) && is_dir($symlinkPath));
    }
    
    /**
     * Get direct storage path untuk foto anggota
     * 
     * @param string $filename
     * @return string
     */
    public static function getAnggotaFotoPath($filename)
    {
        return storage_path('app/public/anggotas/' . $filename);
    }
}

