<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = [
        'page_key',
        'title',
        'content',
        'is_active',
    ];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get content by page key.
     */
    public static function getByKey($key)
    {
        return self::where('page_key', $key)
                   ->where('is_active', true)
                   ->first();
    }

    /**
     * Update or create content by page key.
     */
    public static function updateOrCreateByKey($key, $data)
    {
        return self::updateOrCreate(
            ['page_key' => $key],
            $data
        );
    }
}
