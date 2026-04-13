<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbsensiKegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'anggota_id',
        'riwayat_kegiatan_id',
        'waktu_absen',
        'status_kehadiran',
        'ikut_serta_sebagai',
        'ikut_serta_lainnya',
        'keterangan',
        'bukti_kehadiran',
        'parent_id',
        'parent_id_cabang',
    ];

    protected $casts = [
        'waktu_absen' => 'datetime',
    ];

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

    // Scope untuk status kehadiran
    public function scopeHadir($query)
    {
        return $query->where('status_kehadiran', 'Hadir');
    }

    public function scopeTidakHadir($query)
    {
        return $query->where('status_kehadiran', 'Tidak Hadir');
    }

    public function scopeIzin($query)
    {
        return $query->where('status_kehadiran', 'Izin');
    }

    public function scopeSakit($query)
    {
        return $query->where('status_kehadiran', 'Sakit');
    }

    // Accessor untuk format waktu absen
    public function getWaktuAbsenFormattedAttribute()
    {
        return $this->waktu_absen->format('d/m/Y H:i');
    }
}
