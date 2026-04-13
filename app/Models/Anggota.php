<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Anggota extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'parent_id',
        'parent_id_cabang',
        'nama',
        'email',
        'password',
        'telepon',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'pekerjaan',
        'jabatan',
        'foto',
        'status',
        'aktif_di',
        'keterangan',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'password' => 'hashed',
        'aktif_di' => 'array',
    ];

    // Accessor untuk format tanggal
    public function getTanggalLahirFormattedAttribute()
    {
        return $this->tanggal_lahir->format('d/m/Y');
    }

    // Accessor untuk umur
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir->age;
    }

    // Scope untuk anggota aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }

    // Scope untuk anggota tidak aktif
    public function scopeTidakAktif($query)
    {
        return $query->where('status', 'Tidak Aktif');
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

    public function parentAdmin()
    {
        return $this->belongsTo(Admin::class, 'parent_id');
    }

    public function parentCabang()
    {
        return $this->belongsTo(Admin::class, 'parent_id_cabang');
    }
}
