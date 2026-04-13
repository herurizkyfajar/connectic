<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SertifikatAnggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'anggota_id',
        'riwayat_kegiatan_id',
        'nomor_sertifikat',
        'tanggal_terbit',
        'penyelenggara',
        'keterangan',
        'file_sertifikat',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
    ];

    // Accessor untuk format tanggal
    public function getTanggalTerbitFormattedAttribute()
    {
        return $this->tanggal_terbit->format('d/m/Y');
    }

    // Relasi dengan Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    // Relasi dengan RiwayatKegiatan
    public function riwayatKegiatan()
    {
        return $this->belongsTo(RiwayatKegiatan::class);
    }
}
