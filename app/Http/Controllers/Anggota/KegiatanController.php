<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\RiwayatKegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function calendar()
    {
        return view('anggota.kegiatan.calendar');
    }

    public function events(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        // Assuming start and end are dates
        $events = RiwayatKegiatan::whereBetween('tanggal_kegiatan', [$start, $end])
            ->get()
            ->map(function ($kegiatan) {
                // Combine date and time
                $startDateTime = $kegiatan->tanggal_kegiatan->format('Y-m-d') . 'T' . $kegiatan->waktu_mulai->format('H:i:s');
                $endDateTime = $kegiatan->tanggal_kegiatan->format('Y-m-d') . 'T' . $kegiatan->waktu_selesai->format('H:i:s');
                
                // Color coding based on status
                $color = '#3788d8'; // default blue
                if ($kegiatan->status == 'Dibatalkan') {
                    $color = '#dc3545'; // red
                } elseif ($kegiatan->status == 'Ditunda') {
                    $color = '#ffc107'; // yellow
                } elseif ($kegiatan->status == 'Terlaksana') {
                    $color = '#28a745'; // green
                } elseif ($kegiatan->status == 'Akan Datang') {
                    $color = '#17a2b8'; // info/cyan
                }

                return [
                    'id' => $kegiatan->id,
                    'title' => $kegiatan->judul,
                    'start' => $startDateTime,
                    'end' => $endDateTime,
                    'url' => route('anggota.kegiatan.show', $kegiatan->id),
                    'color' => $color,
                    'extendedProps' => [
                        'status' => $kegiatan->status,
                        'lokasi' => $kegiatan->lokasi,
                    ]
                ];
            });

        return response()->json($events);
    }

    public function show($id)
    {
        $kegiatan = RiwayatKegiatan::findOrFail($id);
        return view('anggota.kegiatan.show', compact('kegiatan'));
    }
}
