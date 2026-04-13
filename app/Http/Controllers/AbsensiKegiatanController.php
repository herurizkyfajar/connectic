<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AbsensiKegiatan;
use App\Models\RiwayatKegiatan;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AbsensiKegiatanController extends Controller
{
    public function index()
    {
        $anggota = Auth::guard('anggota')->user();
        $absensiKegiatans = AbsensiKegiatan::where('anggota_id', $anggota->id)
                                          ->with('riwayatKegiatan')
                                          ->orderBy('waktu_absen', 'desc')
                                          ->get();
        
        $stats = [
            'total' => $absensiKegiatans->count(),
            'hadir' => $absensiKegiatans->where('status_kehadiran', 'Hadir')->count(),
            'tidak_hadir' => $absensiKegiatans->where('status_kehadiran', 'Tidak Hadir')->count(),
            'izin' => $absensiKegiatans->where('status_kehadiran', 'Izin')->count(),
            'sakit' => $absensiKegiatans->where('status_kehadiran', 'Sakit')->count(),
        ];
        
        return view('anggota.absensi-kegiatan.index', compact('absensiKegiatans', 'stats'));
    }

    public function create()
    {
        $riwayatKegiatans = RiwayatKegiatan::where('status', 'Terlaksana')
                                          ->orderBy('tanggal_kegiatan', 'desc')
                                          ->get();
        
        return view('anggota.absensi-kegiatan.create', compact('riwayatKegiatans'));
    }

    public function store(Request $request)
    {
        $anggota = Auth::guard('anggota')->user();
        
        $request->validate([
            'riwayat_kegiatan_id' => 'required|exists:riwayat_kegiatans,id',
            'status_kehadiran' => 'required|in:Hadir,Tidak Hadir,Izin,Sakit',
            'ikut_serta_sebagai' => 'required|in:Peserta,Panitia,Narasumber,Lainnya',
            'ikut_serta_lainnya' => 'required_if:ikut_serta_sebagai,Lainnya|nullable|string|max:100',
            'keterangan' => 'nullable|string|max:500',
            'bukti_kehadiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Cek apakah sudah ada absensi untuk kegiatan ini
        $existingAbsensi = AbsensiKegiatan::where('anggota_id', $anggota->id)
                                         ->where('riwayat_kegiatan_id', $request->riwayat_kegiatan_id)
                                         ->first();

        if ($existingAbsensi) {
            return redirect()->back()
                ->with('error', 'Anda sudah melakukan absensi untuk kegiatan ini sebelumnya.');
        }

        $data = $request->all();
        $data['anggota_id'] = $anggota->id;
        $data['waktu_absen'] = now();
        $data['parent_id'] = $anggota->parent_id;
        $data['parent_id_cabang'] = $anggota->parent_id_cabang;

        // Handle upload bukti kehadiran
        if ($request->hasFile('bukti_kehadiran')) {
            $bukti = $request->file('bukti_kehadiran');
            $buktiName = time() . '_' . $anggota->id . '_' . $bukti->getClientOriginalName();
            Storage::disk('public')->putFileAs('absensi-kegiatan', $bukti, $buktiName);
            $data['bukti_kehadiran'] = $buktiName;
        }

        AbsensiKegiatan::create($data);

        return redirect()->route('absensi-kegiatan.index')
            ->with('success', 'Absensi berhasil dicatat!');
    }

    public function show($id)
    {
        $anggota = Auth::guard('anggota')->user();
        $absensiKegiatan = AbsensiKegiatan::where('anggota_id', $anggota->id)
                                        ->with('riwayatKegiatan')
                                        ->findOrFail($id);
        
        return view('anggota.absensi-kegiatan.show', compact('absensiKegiatan'));
    }

    public function edit($id)
    {
        $anggota = Auth::guard('anggota')->user();
        $absensiKegiatan = AbsensiKegiatan::where('anggota_id', $anggota->id)
                                        ->findOrFail($id);
        
        $riwayatKegiatans = RiwayatKegiatan::where('status', 'Terlaksana')
                                          ->orderBy('tanggal_kegiatan', 'desc')
                                          ->get();
        
        return view('anggota.absensi-kegiatan.edit', compact('absensiKegiatan', 'riwayatKegiatans'));
    }

    public function update(Request $request, $id)
    {
        $anggota = Auth::guard('anggota')->user();
        $absensiKegiatan = AbsensiKegiatan::where('anggota_id', $anggota->id)
                                        ->findOrFail($id);
        
        $request->validate([
            'riwayat_kegiatan_id' => 'required|exists:riwayat_kegiatans,id',
            'status_kehadiran' => 'required|in:Hadir,Tidak Hadir,Izin,Sakit',
            'ikut_serta_sebagai' => 'required|in:Peserta,Panitia,Narasumber,Lainnya',
            'ikut_serta_lainnya' => 'required_if:ikut_serta_sebagai,Lainnya|nullable|string|max:100',
            'keterangan' => 'nullable|string|max:500',
            'bukti_kehadiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Cek apakah sudah ada absensi untuk kegiatan lain (kecuali yang sedang diedit)
        $existingAbsensi = AbsensiKegiatan::where('anggota_id', $anggota->id)
                                         ->where('riwayat_kegiatan_id', $request->riwayat_kegiatan_id)
                                         ->where('id', '!=', $id)
                                         ->first();

        if ($existingAbsensi) {
            return redirect()->back()
                ->with('error', 'Anda sudah melakukan absensi untuk kegiatan ini sebelumnya.');
        }

        $data = $request->all();

        // Handle upload bukti kehadiran
        if ($request->hasFile('bukti_kehadiran')) {
            // Delete old bukti
            if ($absensiKegiatan->bukti_kehadiran) {
                Storage::disk('public')->delete('absensi-kegiatan/' . $absensiKegiatan->bukti_kehadiran);
            }
            
            $bukti = $request->file('bukti_kehadiran');
            $buktiName = time() . '_' . $anggota->id . '_' . $bukti->getClientOriginalName();
            Storage::disk('public')->putFileAs('absensi-kegiatan', $bukti, $buktiName);
            $data['bukti_kehadiran'] = $buktiName;
        } else {
            // Keep existing bukti
            $data['bukti_kehadiran'] = $absensiKegiatan->bukti_kehadiran;
        }

        $absensiKegiatan->update($data);

        return redirect()->route('absensi-kegiatan.index')
            ->with('success', 'Absensi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $anggota = Auth::guard('anggota')->user();
        $absensiKegiatan = AbsensiKegiatan::where('anggota_id', $anggota->id)
                                        ->findOrFail($id);
        
        // Delete bukti kehadiran file
        if ($absensiKegiatan->bukti_kehadiran) {
            Storage::disk('public')->delete('absensi-kegiatan/' . $absensiKegiatan->bukti_kehadiran);
        }
        
        $absensiKegiatan->delete();

        return redirect()->route('absensi-kegiatan.index')
            ->with('success', 'Absensi berhasil dihapus!');
    }

    // API untuk autocomplete kegiatan
    public function searchKegiatan(Request $request)
    {
        $query = $request->get('q');
        
        $kegiatans = RiwayatKegiatan::where('status', 'Terlaksana')
                                  ->where(function($q) use ($query) {
                                      $q->where('judul', 'like', "%{$query}%")
                                        ->orWhere('deskripsi', 'like', "%{$query}%")
                                        ->orWhere('lokasi', 'like', "%{$query}%")
                                        ->orWhere('penyelenggara', 'like', "%{$query}%");
                                  })
                                  ->orderBy('tanggal_kegiatan', 'desc')
                                  ->limit(10)
                                  ->get(['id', 'judul', 'tanggal_kegiatan', 'lokasi', 'penyelenggara']);
        
        return response()->json($kegiatans);
    }
}