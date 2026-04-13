<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AbsensiKegiatan;
use App\Models\Anggota;
use App\Models\RiwayatKegiatan;
use Illuminate\Http\Request;

class AdminAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = AbsensiKegiatan::with(['anggota', 'riwayatKegiatan']);

        // Role-based filtering
        $user = \Illuminate\Support\Facades\Auth::guard('admin')->user();
        if ($user) {
             if ($user->role === 'admin_cabang') {
                 $query->where('parent_id_cabang', $user->id);
             } elseif ($user->role === 'admin_wilayah') {
                 $query->where('parent_id', $user->id);
             }
        }

        // Filter berdasarkan status jika ada
        if ($request->has('status') && !empty($request->status)) {
            $statuses = explode(',', $request->status);
            $query->whereIn('status_kehadiran', $statuses);
        }

        // Filter berdasarkan anggota jika ada
        if ($request->has('anggota') && !empty($request->anggota)) {
            $query->where('anggota_id', $request->anggota);
        }

        // Filter berdasarkan kegiatan jika ada
        if ($request->has('kegiatan') && !empty($request->kegiatan)) {
            $query->where('riwayat_kegiatan_id', $request->kegiatan);
        }

        // Filter berdasarkan tanggal jika ada
        if ($request->has('tanggal') && !empty($request->tanggal)) {
            $query->whereDate('waktu_absen', $request->tanggal);
        }

        $absensiKegiatans = $query->orderBy('waktu_absen', 'desc')->paginate(20)->appends($request->query());

        // Statistics - Use base query without filters for accurate total stats for the user's scope
        $statsQuery = AbsensiKegiatan::query();
        if ($user) {
             if ($user->role === 'admin_cabang') {
                 $statsQuery->where('parent_id_cabang', $user->id);
             } elseif ($user->role === 'admin_wilayah') {
                 $statsQuery->where('parent_id', $user->id);
             }
        }

        $totalAbsensi = (clone $statsQuery)->count();
        // For total anggota and kegiatan, we should also filter based on role
        $anggotaQuery = Anggota::query();
        $kegiatanQuery = RiwayatKegiatan::query();
        
        if ($user) {
             if ($user->role === 'admin_cabang') {
                 $anggotaQuery->where('parent_id_cabang', $user->id);
                 $kegiatanQuery->where('parent_id_cabang', $user->id);
             } elseif ($user->role === 'admin_wilayah') {
                 $anggotaQuery->where('parent_id', $user->id);
                 $kegiatanQuery->where('parent_id', $user->id);
             }
        }

        $totalAnggota = $anggotaQuery->count();
        $totalKegiatan = $kegiatanQuery->count();
        
        $totalHadir = (clone $statsQuery)->hadir()->count();
        $totalTidakHadir = (clone $statsQuery)->tidakHadir()->count();
        $totalIzin = (clone $statsQuery)->izin()->count();
        $totalSakit = (clone $statsQuery)->sakit()->count();

        // Get options for filters
        $anggotaOptions = $anggotaQuery->orderBy('nama')->get();
        $kegiatanOptions = $kegiatanQuery->orderBy('tanggal_kegiatan', 'desc')->get();

        return view('admin.absensi.index', compact(
            'absensiKegiatans',
            'totalAbsensi',
            'totalAnggota',
            'totalKegiatan',
            'totalHadir',
            'totalTidakHadir',
            'totalIzin',
            'totalSakit',
            'anggotaOptions',
            'kegiatanOptions'
        ));
    }
    
    public function show($id)
    {
        $absensiKegiatan = AbsensiKegiatan::with(['anggota', 'riwayatKegiatan'])
                                        ->findOrFail($id);
        
        return view('admin.absensi.show', compact('absensiKegiatan'));
    }
    
    public function edit($id)
    {
        $absensiKegiatan = AbsensiKegiatan::with(['anggota', 'riwayatKegiatan'])
                                        ->findOrFail($id);
        
        // Get all anggotas for dropdown
        $anggotas = Anggota::where('status', 'Aktif')
                          ->orderBy('nama')
                          ->get();
        
        // Get all riwayat kegiatans for dropdown
        $riwayatKegiatans = RiwayatKegiatan::orderBy('tanggal_kegiatan', 'desc')
                                          ->get();
        
        return view('admin.absensi.edit', compact('absensiKegiatan', 'anggotas', 'riwayatKegiatans'));
    }
    
    public function update(Request $request, $id)
    {
        $absensiKegiatan = AbsensiKegiatan::findOrFail($id);
        
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'riwayat_kegiatan_id' => 'required|exists:riwayat_kegiatans,id',
            'ikut_serta_sebagai' => 'required|in:Peserta,Panitia,Narasumber,Lainnya',
            'ikut_serta_lainnya' => 'required_if:ikut_serta_sebagai,Lainnya|nullable|string|max:100',
            'status_kehadiran' => 'required|in:Hadir,Tidak Hadir,Izin,Sakit',
            'waktu_absen' => 'required|date',
            'metode_absensi' => 'nullable|string|max:50',
            'lokasi_absensi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'bukti_kehadiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        
        $data = $request->except('bukti_kehadiran');
        
        // Handle file upload
        if ($request->hasFile('bukti_kehadiran')) {
            // Delete old file
            if ($absensiKegiatan->bukti_kehadiran) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete('absensi-kegiatan/' . $absensiKegiatan->bukti_kehadiran);
            }
            
            $file = $request->file('bukti_kehadiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('absensi-kegiatan', $filename, 'public');
            $data['bukti_kehadiran'] = $filename;
        }
        
        $absensiKegiatan->update($data);
        
        return redirect()->route('admin.absensi.show', $absensiKegiatan->id)
            ->with('success', 'Absensi berhasil diupdate!');
    }
    
    public function anggota($anggotaId)
    {
        $anggota = Anggota::findOrFail($anggotaId);
        $absensiKegiatans = AbsensiKegiatan::where('anggota_id', $anggotaId)
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
        
        return view('admin.absensi.anggota', compact('anggota', 'absensiKegiatans', 'stats'));
    }
    
    public function kegiatan($kegiatanId)
    {
        $riwayatKegiatan = RiwayatKegiatan::findOrFail($kegiatanId);
        $absensiKegiatans = AbsensiKegiatan::where('riwayat_kegiatan_id', $kegiatanId)
                                          ->with('anggota')
                                          ->orderBy('waktu_absen', 'desc')
                                          ->get();
        
        $stats = [
            'total_peserta' => $absensiKegiatans->count(),
            'hadir' => $absensiKegiatans->where('status_kehadiran', 'Hadir')->count(),
            'tidak_hadir' => $absensiKegiatans->where('status_kehadiran', 'Tidak Hadir')->count(),
            'izin' => $absensiKegiatans->where('status_kehadiran', 'Izin')->count(),
            'sakit' => $absensiKegiatans->where('status_kehadiran', 'Sakit')->count(),
        ];
        
        return view('admin.absensi.kegiatan', compact('riwayatKegiatan', 'absensiKegiatans', 'stats'));
    }
    
    public function destroy($id)
    {
        $absensiKegiatan = AbsensiKegiatan::findOrFail($id);
        
        // Delete bukti kehadiran file
        if ($absensiKegiatan->bukti_kehadiran) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete('absensi-kegiatan/' . $absensiKegiatan->bukti_kehadiran);
        }
        
        $absensiKegiatan->delete();
        
        return redirect()->back()
            ->with('success', 'Absensi berhasil dihapus!');
    }

    public function ranking()
    {
        // Ranking anggota berdasarkan jumlah hadir terbanyak (lalu total absensi)
        $rankings = Anggota::withCount([
                'absensiKegiatans as jumlah_hadir' => function ($q) {
                    $q->where('status_kehadiran', 'Hadir');
                },
                'absensiKegiatans as absensi_count'
            ])
            ->orderByDesc('jumlah_hadir')
            ->orderByDesc('absensi_count')
            ->paginate(20);

        // Use custom pagination view
        $rankings->onEachSide(1);

        // Statistik ringkas
        $totalAnggota = Anggota::count();
        $totalAbsensi = AbsensiKegiatan::count();
        $totalHadir = AbsensiKegiatan::hadir()->count();
        $totalKegiatan = RiwayatKegiatan::count();

        return view('admin.absensi.ranking', compact('rankings', 'totalAnggota', 'totalAbsensi', 'totalHadir', 'totalKegiatan'));
    }
}