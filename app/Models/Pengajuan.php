<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_pengajuan',
        'tanggal_pengajuan',
        'parent_id',
        'parent_id_cabang',
        'status',
        'deskripsi',
        'link_berkas',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
    ];

    public function parent()
    {
        return $this->belongsTo(Admin::class, 'parent_id');
    }

    public function parentCabang()
    {
        return $this->belongsTo(Admin::class, 'parent_id_cabang');
    }
}
