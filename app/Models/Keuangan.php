<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Keuangan extends Model
{
    protected $fillable = [
        'parent_id',
        'parent_id_cabang',
        'jenis',
        'jumlah',
        'kategori',
        'keterangan',
        'tanggal',
        'sumber',
        'penerima',
        'bukti',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    /**
     * Scope untuk transaksi masuk
     */
    public function scopeMasuk($query)
    {
        return $query->where('jenis', 'masuk');
    }

    /**
     * Scope untuk transaksi keluar
     */
    public function scopeKeluar($query)
    {
        return $query->where('jenis', 'keluar');
    }

    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeTanggalBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal', [$startDate, $endDate]);
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Scope untuk filter berdasarkan rentang waktu
     */
    public function scopeRentangWaktu($query, $rentang)
    {
        $now = now();
        switch ($rentang) {
            case 'hari':
                return $query->whereDate('tanggal', $now->toDateString());
            case 'minggu':
                return $query->whereBetween('tanggal', [
                    $now->startOfWeek()->toDateString(),
                    $now->endOfWeek()->toDateString()
                ]);
            case 'bulan':
                return $query->whereYear('tanggal', $now->year)
                            ->whereMonth('tanggal', $now->month);
            case 'tahun':
                return $query->whereYear('tanggal', $now->year);
            default:
                return $query;
        }
    }

    /**
     * Get URL untuk bukti transaksi
     */
    public function getBuktiUrlAttribute()
    {
        return $this->bukti ? Storage::disk('public')->url('keuangan/' . $this->bukti) : null;
    }

    /**
     * Format jumlah sebagai mata uang
     */
    public function getFormattedJumlahAttribute()
    {
        return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
    }

    /**
     * Get badge class berdasarkan jenis transaksi
     */
    public function getBadgeClassAttribute()
    {
        return $this->jenis === 'masuk' ? 'success' : 'danger';
    }
}
