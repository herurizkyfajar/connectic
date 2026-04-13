<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RiwayatKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class RiwayatKegiatanController extends Controller
{
    public function publicIndex()
    {
        $kegiatans = RiwayatKegiatan::terlaksana()
            ->orderBy('tanggal_kegiatan', 'desc')
            ->orderBy('waktu_mulai', 'desc')
            ->paginate(12);

        return view('public.kegiatan-index', compact('kegiatans'));
    }

    public function calendar()
    {
        return view('admin.riwayat-kegiatan.calendar');
    }

    public function events(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $query = RiwayatKegiatan::whereBetween('tanggal_kegiatan', [$start, $end]);

        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admin_wilayah') {
            $query->where('parent_id', Auth::guard('admin')->id());
        }

        $events = $query->get()
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
                    'url' => route('riwayat-kegiatan.show', $kegiatan->id),
                    'color' => $color,
                    'extendedProps' => [
                        'status' => $kegiatan->status,
                        'lokasi' => $kegiatan->lokasi,
                    ]
                ];
            });

        return response()->json($events);
    }

    public function index()
    {
        $query = RiwayatKegiatan::orderBy('tanggal_kegiatan', 'desc')
                                ->orderBy('waktu_mulai', 'desc');

        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            if ($user->role === 'admin_wilayah') {
                $query->where('parent_id', $user->id);
            } elseif ($user->role === 'admin_cabang') {
                $query->where('parent_id_cabang', $user->id);
            }
        }

        $kegiatans = $query->paginate(10);

        $statsQuery = RiwayatKegiatan::query();
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            if ($user->role === 'admin_wilayah') {
                $statsQuery->where('parent_id', $user->id);
            } elseif ($user->role === 'admin_cabang') {
                $statsQuery->where('parent_id_cabang', $user->id);
            }
        }
        $stats = [
            'total' => (clone $statsQuery)->count(),
            'terlaksana' => (clone $statsQuery)->terlaksana()->count(),
            'dibatalkan' => (clone $statsQuery)->dibatalkan()->count(),
            'ditunda' => (clone $statsQuery)->ditunda()->count(),
            'akan_datang' => (clone $statsQuery)->akanDatang()->count(),
        ];
        
        return view('admin.riwayat-kegiatan.index', compact('kegiatans', 'stats'));
    }

    public function create()
    {
        $adminWilayahs = \App\Models\Admin::where('role', 'admin_wilayah')->orderBy('name')->get();
        $adminCabangs = \App\Models\Admin::where('role', 'admin_cabang')->orderBy('name')->get();
        
        $loggedInAdmin = Auth::guard('admin')->user();
        $autoFill = [];
        
        if ($loggedInAdmin) {
            if ($loggedInAdmin->role === 'admin_cabang') {
                $autoFill['parent_id_cabang'] = $loggedInAdmin->id;
                // Find parent admin via Wilayah hierarchy
                $wilayah = \App\Models\Wilayah::where('parent_id_cabang', $loggedInAdmin->id)->first();
                if ($wilayah && $wilayah->parent) {
                    $autoFill['parent_id'] = $wilayah->parent->parent_id_cabang;
                }
            } elseif ($loggedInAdmin->role === 'admin_wilayah') {
                $autoFill['parent_id'] = $loggedInAdmin->id;
            }
        }
        
        return view('admin.riwayat-kegiatan.create', compact('adminWilayahs', 'adminCabangs', 'autoFill'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_kegiatan' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'lokasi' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|in:Rapat,Pelatihan,Seminar,Workshop,Sosialisasi,Pertemuan,Kegiatan Lainnya',
            'status' => 'required|in:Terlaksana,Dibatalkan,Ditunda,Akan Datang',
            'penyelenggara' => 'required|string|max:255',
            'catatan' => 'nullable|string',
            'dokumentasi' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp|max:10240',
            'parent_id' => 'nullable|exists:admins,id',
            'parent_id_cabang' => 'nullable|exists:admins,id',
        ]);

        $data = $request->all();
        $user = Auth::guard('admin')->user();

        // Auto-fill for admin_wilayah
        if ($user->role === 'admin_wilayah') {
             $data['parent_id'] = $user->id;
        } 
        // Auto-fill for admin_cabang
        elseif ($user->role === 'admin_cabang') {
            $data['parent_id_cabang'] = $user->id;
            $wilayah = \App\Models\Wilayah::where('parent_id_cabang', $user->id)->first();
            if ($wilayah && $wilayah->parent && empty($data['parent_id'])) {
                 $data['parent_id'] = $wilayah->parent->parent_id_cabang;
            }
        }
        
        $data['parent_id'] = $data['parent_id'] ?? $user->id;

        // Handle dokumentasi upload
        if ($request->hasFile('dokumentasi')) {
            $dokumentasi = $request->file('dokumentasi');
            $dokumentasiName = time() . '_' . $dokumentasi->getClientOriginalName();
            Storage::disk('public')->putFileAs('riwayat-kegiatan', $dokumentasi, $dokumentasiName);
            $data['dokumentasi'] = $dokumentasiName;
        }

        RiwayatKegiatan::create($data);

        return redirect()->route('riwayat-kegiatan.index')
            ->with('success', 'Riwayat kegiatan berhasil ditambahkan!');
    }

    public function show($id)
    {
        $riwayatKegiatan = RiwayatKegiatan::findOrFail($id);
        
        // Get peserta kegiatan with pagination
        $pesertaKegiatan = \App\Models\AbsensiKegiatan::where('riwayat_kegiatan_id', $id)
            ->with('anggota')
            ->orderBy('waktu_absen', 'desc')
            ->paginate(10);
        
        // Count total peserta and statistics
        $totalPeserta = \App\Models\AbsensiKegiatan::where('riwayat_kegiatan_id', $id)->count();
        $jumlahHadir = \App\Models\AbsensiKegiatan::where('riwayat_kegiatan_id', $id)
            ->where('status_kehadiran', 'Hadir')->count();
        $jumlahTidakHadir = \App\Models\AbsensiKegiatan::where('riwayat_kegiatan_id', $id)
            ->where('status_kehadiran', 'Tidak Hadir')->count();
        $jumlahIzin = \App\Models\AbsensiKegiatan::where('riwayat_kegiatan_id', $id)
            ->where('status_kehadiran', 'Izin')->count();
        $jumlahSakit = \App\Models\AbsensiKegiatan::where('riwayat_kegiatan_id', $id)
            ->where('status_kehadiran', 'Sakit')->count();
        
        return view('admin.riwayat-kegiatan.show', compact(
            'riwayatKegiatan',
            'pesertaKegiatan',
            'totalPeserta',
            'jumlahHadir',
            'jumlahTidakHadir',
            'jumlahIzin',
            'jumlahSakit'
        ));
    }

    public function publicShow($id)
    {
        $riwayatKegiatan = RiwayatKegiatan::findOrFail($id);

        return view('public.kegiatan-show', compact('riwayatKegiatan'));
    }

    public function edit($id)
    {
        $riwayatKegiatan = RiwayatKegiatan::findOrFail($id);
        $adminWilayahs = \App\Models\Admin::where('role', 'admin_wilayah')->orderBy('name')->get();
        $adminCabangs = \App\Models\Admin::where('role', 'admin_cabang')->orderBy('name')->get();
        return view('admin.riwayat-kegiatan.edit', compact('riwayatKegiatan', 'adminWilayahs', 'adminCabangs'));
    }

    public function update(Request $request, $id)
    {
        $riwayatKegiatan = RiwayatKegiatan::findOrFail($id);
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_kegiatan' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'lokasi' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|in:Rapat,Pelatihan,Seminar,Workshop,Sosialisasi,Pertemuan,Kegiatan Lainnya',
            'status' => 'required|in:Terlaksana,Dibatalkan,Ditunda,Akan Datang',
            'penyelenggara' => 'required|string|max:255',
            'catatan' => 'nullable|string',
            'dokumentasi' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp|max:10240',
            'parent_id' => 'nullable|exists:admins,id',
            'parent_id_cabang' => 'nullable|exists:admins,id',
        ]);

        $data = $request->all();

        // Handle dokumentasi upload
        if ($request->hasFile('dokumentasi')) {
            // Delete old dokumentasi
            if ($riwayatKegiatan->dokumentasi) {
                Storage::disk('public')->delete('riwayat-kegiatan/' . $riwayatKegiatan->dokumentasi);
            }
            
            $dokumentasi = $request->file('dokumentasi');
            $dokumentasiName = time() . '_' . $dokumentasi->getClientOriginalName();
            Storage::disk('public')->putFileAs('riwayat-kegiatan', $dokumentasi, $dokumentasiName);
            $data['dokumentasi'] = $dokumentasiName;
        } else {
            // Keep existing dokumentasi if no new file uploaded
            $data['dokumentasi'] = $riwayatKegiatan->dokumentasi;
        }

        $riwayatKegiatan->update($data);

        return redirect()->route('riwayat-kegiatan.index')
            ->with('success', 'Riwayat kegiatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $riwayatKegiatan = RiwayatKegiatan::findOrFail($id);
        
        // Delete dokumentasi file
        if ($riwayatKegiatan->dokumentasi) {
            Storage::disk('public')->delete('riwayat-kegiatan/' . $riwayatKegiatan->dokumentasi);
        }
        
        $riwayatKegiatan->delete();

        return redirect()->route('riwayat-kegiatan.index')
            ->with('success', 'Riwayat kegiatan berhasil dihapus!');
    }

    public function storeAbsensi(Request $request, $id)
    {
        $request->validate([
            'anggota_ids' => 'required|array|min:1',
            'anggota_ids.*' => 'exists:anggotas,id',
            'waktu_absen' => 'required|date',
            'status_kehadiran' => 'required|array',
            'status_kehadiran.*' => 'required|in:Hadir,Tidak Hadir,Izin,Sakit',
            'keterangan' => 'nullable|array',
            'keterangan.*' => 'nullable|string|max:500',
        ], [
            'anggota_ids.required' => 'Pilih minimal satu anggota untuk diabsensi',
            'anggota_ids.min' => 'Pilih minimal satu anggota untuk diabsensi',
            'waktu_absen.required' => 'Waktu absen harus diisi',
            'waktu_absen.date' => 'Format waktu absen tidak valid',
        ]);

        $riwayatKegiatan = RiwayatKegiatan::findOrFail($id);
        $successCount = 0;
        $failedCount = 0;

        foreach ($request->anggota_ids as $anggotaId) {
            try {
                // Check if already exists
                $exists = \App\Models\AbsensiKegiatan::where('anggota_id', $anggotaId)
                    ->where('riwayat_kegiatan_id', $id)
                    ->exists();

                if (!$exists) {
                    $anggota = \App\Models\Anggota::find($anggotaId);
                    if ($anggota) {
                        \App\Models\AbsensiKegiatan::create([
                            'anggota_id' => $anggotaId,
                            'riwayat_kegiatan_id' => $id,
                            'waktu_absen' => $request->waktu_absen,
                            'status_kehadiran' => $request->status_kehadiran[$anggotaId] ?? 'Hadir',
                            'keterangan' => $request->keterangan[$anggotaId] ?? null,
                            'parent_id' => $anggota->parent_id,
                            'parent_id_cabang' => $anggota->parent_id_cabang,
                        ]);
                        $successCount++;
                    }
                } else {
                    $failedCount++;
                }
            } catch (\Exception $e) {
                $failedCount++;
            }
        }

        if ($successCount > 0 && $failedCount == 0) {
            return redirect()->route('riwayat-kegiatan.show', $id)
                ->with('success', "Berhasil menginput absensi untuk {$successCount} anggota!");
        } elseif ($successCount > 0 && $failedCount > 0) {
            return redirect()->route('riwayat-kegiatan.show', $id)
                ->with('warning', "Berhasil menginput absensi untuk {$successCount} anggota. {$failedCount} anggota sudah pernah absen sebelumnya.");
        } else {
            return redirect()->route('riwayat-kegiatan.show', $id)
                ->with('error', "Gagal menginput absensi. Semua anggota yang dipilih sudah pernah absen.");
        }
    }

    public function download($id)
    {
        $riwayatKegiatan = RiwayatKegiatan::findOrFail($id);

        if (!$riwayatKegiatan->dokumentasi) {
            return back()->with('error', 'Kegiatan ini tidak memiliki dokumentasi.');
        }

        $filename = basename($riwayatKegiatan->dokumentasi);
        $relativePath = 'riwayat-kegiatan/' . $filename;

        if (!\Storage::disk('public')->exists($relativePath)) {
            return back()->with('error', 'File dokumentasi tidak ditemukan. File mungkin telah dihapus.');
        }

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
        ];

        $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';

        return \Storage::disk('public')->download($relativePath, $filename, [
            'Content-Type' => $contentType,
        ]);
    }

    public function serveImage($id)
    {
        $riwayatKegiatan = RiwayatKegiatan::findOrFail($id);
        if (!$riwayatKegiatan->dokumentasi) {
            abort(404, 'Dokumentasi tidak tersedia');
        }
        $filename = basename($riwayatKegiatan->dokumentasi);
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($extension, ['jpg','jpeg','png','gif','webp'])) {
            abort(404, 'Dokumentasi bukan gambar');
        }
        $filePath = storage_path('app/public/riwayat-kegiatan/' . $filename);
        if (!file_exists($filePath)) {
            abort(404, 'File gambar tidak ditemukan');
        }
        $mimeType = mime_content_type($filePath);
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
}
