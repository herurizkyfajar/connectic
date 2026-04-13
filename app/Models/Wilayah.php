<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $fillable = [
        'nama',
        'tipe',
        'kode',
        'parent_id',
        'parent_id_cabang',
        'deskripsi',
        'status',
    ];

    public function parent()
    {
        return $this->belongsTo(Wilayah::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Wilayah::class, 'parent_id');
    }

    public function parentCabangAdmin()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'parent_id_cabang');
    }
}
