<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatKegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'parent_id_cabang',
        'judul',
        'deskripsi',
        'tanggal_kegiatan',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'jenis_kegiatan',
        'status',
        'penyelenggara',
        'catatan',
        'dokumentasi',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
        'waktu_mulai' => 'datetime:H:i',
        'waktu_selesai' => 'datetime:H:i',
    ];

    // Accessor untuk format tanggal
    public function getTanggalKegiatanFormattedAttribute()
    {
        return $this->tanggal_kegiatan->format('d/m/Y');
    }

    // Accessor untuk durasi kegiatan
    public function getDurasiAttribute()
    {
        $mulai = \Carbon\Carbon::parse($this->waktu_mulai);
        $selesai = \Carbon\Carbon::parse($this->waktu_selesai);
        return $mulai->diffInHours($selesai) . ' jam ' . $mulai->diffInMinutes($selesai) % 60 . ' menit';
    }

    // Scope untuk kegiatan terlaksana
    public function scopeTerlaksana($query)
    {
        return $query->where('status', 'Terlaksana');
    }

    // Scope untuk kegiatan dibatalkan
    public function scopeDibatalkan($query)
    {
        return $query->where('status', 'Dibatalkan');
    }

    // Scope untuk kegiatan ditunda
    public function scopeDitunda($query)
    {
        return $query->where('status', 'Ditunda');
    }

    // Scope untuk kegiatan akan datang
    public function scopeAkanDatang($query)
    {
        return $query->where('status', 'Akan Datang');
    }

    // Scope untuk kegiatan berdasarkan jenis
    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis_kegiatan', $jenis);
    }

    // Relasi dengan AbsensiKegiatan
    public function absensiKegiatans()
    {
        return $this->hasMany(AbsensiKegiatan::class);
    }

    // Relasi dengan SertifikatAnggota
    public function sertifikats()
    {
        return $this->hasMany(SertifikatAnggota::class);
    }
}
