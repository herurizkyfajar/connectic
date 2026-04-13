<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Pagination\LengthAwarePaginator;

class AnggotaAuthController extends Controller
{
    public function showLoginForm()
    {
        // If user is already logged in, redirect to profile
        if (Auth::guard('anggota')->check()) {
            return redirect()->route('anggota.beranda');
        }
        
        return view('anggota.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Try to find by email first, then by username
        $anggota = Anggota::where('email', $request->username)
                          ->orWhere('nama', $request->username)
                          ->first();

        if ($anggota && Hash::check($request->password, $anggota->password)) {
            Auth::guard('anggota')->login($anggota);
            $request->session()->regenerate();
            
            return redirect()->intended('/anggota/beranda');
        }

        throw ValidationException::withMessages([
            'username' => ['Kredensial yang diberikan tidak valid.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('anggota')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }

    public function profile()
    {
        $anggota = Auth::guard('anggota')->user();
        
        // Get sertifikat with related data
        $sertifikats = $anggota->sertifikats()
            ->with('riwayatKegiatan')
            ->orderBy('tanggal_terbit', 'desc')
            ->get();
        
        // Get riwayat kegiatan (melalui absensi kegiatan)
        $riwayatKegiatans = \App\Models\AbsensiKegiatan::where('anggota_id', $anggota->id)
            ->with('riwayatKegiatan')
            ->orderBy('waktu_absen', 'desc')
            ->limit(10) // Limit to last 10 activities
            ->get()
            ->pluck('riwayatKegiatan')
            ->unique('id');
        
        // Hitung kategori keaktifan anggota (1 tahun terakhir)
        $kehadiranKegiatan = \Illuminate\Support\Facades\DB::table('absensi_kegiatans')
            ->where('anggota_id', $anggota->id)
            ->where('waktu_absen', '>=', now()->subYear())
            ->count();
        
        $kehadiranMeeting = \App\Models\MeetingNote::where('meeting_date', '>=', now()->subYear())
            ->whereNotNull('attendance')
            ->where('attendance', 'LIKE', '%' . $anggota->nama . '%')
            ->count();
        
        // Total skor keaktifan
        $skor = $kehadiranKegiatan + $kehadiranMeeting;
        
        // Tentukan kategori
        if ($skor >= 5) {
            $kategoriKeaktifan = 'Sangat Aktif';
            $badgeKeaktifan = 'success';
            $iconKeaktifan = 'fa-star';
        } elseif ($skor >= 3) {
            $kategoriKeaktifan = 'Aktif';
            $badgeKeaktifan = 'info';
            $iconKeaktifan = 'fa-thumbs-up';
        } elseif ($skor >= 1) {
            $kategoriKeaktifan = 'Kurang Aktif';
            $badgeKeaktifan = 'warning';
            $iconKeaktifan = 'fa-exclamation-triangle';
        } else {
            $kategoriKeaktifan = 'Tidak Aktif';
            $badgeKeaktifan = 'danger';
            $iconKeaktifan = 'fa-times-circle';
        }
        
        return view('anggota.profile', compact(
            'anggota', 
            'sertifikats', 
            'riwayatKegiatans',
            'kategoriKeaktifan',
            'badgeKeaktifan',
            'iconKeaktifan',
            'skor',
            'kehadiranKegiatan',
            'kehadiranMeeting'
        ));
    }

    public function beranda()
    {
        $anggota = Auth::guard('anggota')->user();

        // Kegiatan terbaru RTIK (global)
        $kegiatanTerbaruData = \App\Models\RiwayatKegiatan::terlaksana()
            ->orderBy('tanggal_kegiatan', 'desc')
            ->get();

        $rapatTerbaruData = \App\Models\MeetingNote::orderBy('meeting_date', 'desc')
            ->get();
        $rapatTerbaruData = $rapatTerbaruData->map(function ($m) {
            $foto = null;
            if (!empty($m->note_taker)) {
                $a = \App\Models\Anggota::where('nama', $m->note_taker)->first();
                if ($a && $a->foto) { $foto = $a->foto; }
            }
            if (!$foto && !empty($m->attendance)) {
                $first = trim(explode(',', $m->attendance)[0]);
                if (!empty($first)) {
                    $a = \App\Models\Anggota::where('nama', $first)->first();
                    if ($a && $a->foto) { $foto = $a->foto; }
                }
            }
            $m->foto_anggota = $foto;
            return $m;
        });

        $feedKegiatan = $kegiatanTerbaruData->map(function($k){
            $dok = $k->dokumentasi ?? null;
            $ext = $dok ? strtolower(pathinfo($dok, PATHINFO_EXTENSION)) : null;
            $isImg = $ext && in_array($ext, ['jpg','jpeg','png','gif','webp']);
            $imgUrl = ($isImg && $dok) ? asset('storage/riwayat-kegiatan/' . $dok) : null;
            $sortDate = $k->updated_at && $k->tanggal_kegiatan
                ? ($k->updated_at->gt($k->tanggal_kegiatan) ? $k->updated_at : $k->tanggal_kegiatan)
                : $k->tanggal_kegiatan;
            return (object) [
                'type' => 'kegiatan',
                'title' => $k->judul,
                'subtitle' => $k->lokasi,
                'date' => $sortDate,
                'image' => $imgUrl,
                'icon' => 'bullhorn',
                'color' => 'primary',
                'description' => $k->deskripsi,
                'id' => $k->id,
            ];
        });

        $feedRapat = $rapatTerbaruData->map(function($m){
            $fotoUrl = $m->foto_anggota ? asset('storage/anggotas/' . $m->foto_anggota) : null;
            $meetingDate = $m->meeting_date ? \Illuminate\Support\Carbon::parse($m->meeting_date) : null;
            $sortDate = ($m->updated_at && $meetingDate)
                ? ($m->updated_at->gt($meetingDate) ? $m->updated_at : $meetingDate)
                : ($meetingDate ?: $m->updated_at);
            return (object) [
                'type' => 'rapat',
                'title' => $m->project_name,
                'subtitle' => $m->topic,
                'date' => $sortDate,
                'image' => $fotoUrl,
                'icon' => 'file-alt',
                'color' => 'success',
            ];
        });

        $combined = $feedKegiatan->concat($feedRapat)
            ->sortByDesc(function($i){ return $i->date; })
            ->values();

        $perPage = 10;
        $page = (int) request()->query('page', 1);
        $total = $combined->count();
        $items = $combined->slice(($page - 1) * $perPage, $perPage)->values();
        $updateTerbaru = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        $absensiTerbaru = \App\Models\AbsensiKegiatan::with(['riwayatKegiatan', 'anggota'])
            ->orderBy('waktu_absen', 'desc')
            ->limit(30)
            ->get()
            ->filter(function($item){
                $bukti = $item->bukti_kehadiran ?? null;
                if (!$bukti) return false;
                $ext = strtolower(pathinfo($bukti, PATHINFO_EXTENSION));
                return in_array($ext, ['jpg','jpeg','png','gif','webp']);
            })
            ->take(20);

        $allAnggota = \App\Models\Anggota::aktif()->get();
        $ranked = $allAnggota->map(function($a) {
            $absensiCount = \Illuminate\Support\Facades\DB::table('absensi_kegiatans')
                ->where('anggota_id', $a->id)
                ->count();
            $meetingCount = \App\Models\MeetingNote::whereNotNull('attendance')
                ->where('attendance', 'LIKE', '%' . $a->nama . '%')
                ->count();
            $a->skor_keaktifan = $absensiCount + $meetingCount;
            return $a;
        })->sortByDesc('skor_keaktifan')->values();

        $anggotaList = $ranked->take(10);

        $upcomingBirthdays = \App\Models\Anggota::aktif()
            ->whereNotNull('tanggal_lahir')
            ->get()
            ->map(function($a){
                $today = now();
                $birthday = $a->tanggal_lahir ? $a->tanggal_lahir->copy()->year($today->year) : null;
                if ($birthday) {
                    if ($birthday->isPast()) {
                        $birthday->addYear();
                    }
                    $a->days_until_birthday = $today->diffInDays($birthday);
                    $a->next_birthday_date = $birthday;
                    $a->formatted_birthday = $a->tanggal_lahir->format('d/m');
                } else {
                    $a->days_until_birthday = null;
                }
                return $a;
            })
            ->filter(function($a){ return $a->days_until_birthday !== null; })
            ->sortBy('days_until_birthday')
            ->take(5);

        return view('anggota.beranda', compact('anggota', 'updateTerbaru', 'absensiTerbaru', 'anggotaList', 'upcomingBirthdays'));
    }

    public function editProfile()
    {
        $anggota = Auth::guard('anggota')->user();
        return view('anggota.edit-profile', compact('anggota'));
    }

    public function updateProfile(Request $request)
    {
        \Log::info('=== UPDATE PROFILE START ===');
        \Log::info('Request has file: ' . ($request->hasFile('foto') ? 'YES' : 'NO'));
        \Log::info('Request all files: ' . json_encode($request->allFiles()));
        \Log::info('Request input foto: ' . ($request->input('foto') ?? 'NULL'));
        
        $anggota = Auth::guard('anggota')->user();
        \Log::info('Anggota ID: ' . $anggota->id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:anggotas,email,' . $anggota->id,
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'pekerjaan' => 'nullable|string|max:255',
            'jabatan' => 'nullable|in:Ketua umum,Wakil ketua,Sekretaris,Bendahara,Bidang kesekretariatan,Bidang kemitraan dan legal,Bidang program dan aptika,Bidang penelitian dan pengembangan sumber daya manusia,Bidang komunikasi publik',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'keterangan' => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        
        \Log::info('Validation passed');

        $data = $request->except(['password', 'password_confirmation']);
        \Log::info('Data to update: ' . json_encode(array_keys($data)));

        // Handle password update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            \Log::info('=== UPLOAD FOTO START ===');
            try {
                $foto = $request->file('foto');
                \Log::info('File received: ' . $foto->getClientOriginalName());
                \Log::info('File size: ' . $foto->getSize() . ' bytes');
                \Log::info('File mime: ' . $foto->getMimeType());
                \Log::info('File temp path: ' . $foto->getRealPath());
                \Log::info('PHP Version: ' . PHP_VERSION);
                \Log::info('Laravel Base Path: ' . base_path());
                \Log::info('Storage Path Result: ' . storage_path());
                
                // Validate file
                if (!$foto->isValid()) {
                    \Log::error('File is not valid!');
                    throw new \Exception('File upload tidak valid');
                }
                \Log::info('File is valid: true');
                
                // Generate filename - ONLY FILENAME, NO PATH
                $fotoName = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
                \Log::info('Generated filename (ONLY NAME): ' . $fotoName);
                
                // Ensure directory exists with absolute path
                $uploadPath = storage_path('app/public/anggotas');
                \Log::info('Upload directory (full path): ' . $uploadPath);
                \Log::info('Upload directory (realpath): ' . realpath(storage_path('app/public')));
                
                if (!file_exists($uploadPath)) {
                    \Log::info('Directory does not exist, creating...');
                    $mkdirResult = mkdir($uploadPath, 0755, true);
                    \Log::info('mkdir result: ' . ($mkdirResult ? 'SUCCESS' : 'FAILED'));
                    if (!$mkdirResult) {
                        throw new \Exception('Gagal membuat directory: ' . $uploadPath);
                    }
                }
                
                // Check if writable
                $isWritable = is_writable($uploadPath);
                \Log::info('Directory writable: ' . ($isWritable ? 'YES' : 'NO'));
                \Log::info('Directory permissions: ' . substr(sprintf('%o', fileperms($uploadPath)), -4));
                
                if (!$isWritable) {
                    throw new \Exception('Directory tidak writable: ' . $uploadPath);
                }
                
                // Delete old foto if exists
                if ($anggota->foto) {
                    // Extract only filename from old foto (in case it contains path)
                    $oldFotoFilename = basename($anggota->foto);
                    $oldFotoPath = storage_path('app/public/anggotas/' . $oldFotoFilename);
                    \Log::info('Deleting old foto: ' . $oldFotoPath);
                    if (file_exists($oldFotoPath)) {
                        $unlinkResult = @unlink($oldFotoPath);
                        \Log::info('Old foto deleted: ' . ($unlinkResult ? 'YES' : 'NO'));
                    } else {
                        \Log::info('Old foto not found at path: ' . $oldFotoPath);
                    }
                }
                
                // Move uploaded file
                $fullTargetPath = $uploadPath . DIRECTORY_SEPARATOR . $fotoName;
                \Log::info('Moving file to: ' . $fullTargetPath);
                \Log::info('Directory separator: ' . DIRECTORY_SEPARATOR);
                
                $moveResult = $foto->move($uploadPath, $fotoName);
                \Log::info('File move result: ' . ($moveResult ? get_class($moveResult) : 'FAILED'));
                \Log::info('Move result path: ' . ($moveResult ? $moveResult->getPathname() : 'N/A'));
                
                // Verify file exists after move
                $fileExists = file_exists($fullTargetPath);
                \Log::info('File exists after move: ' . ($fileExists ? 'YES' : 'NO'));
                
                if ($fileExists) {
                    $fileSize = filesize($fullTargetPath);
                    \Log::info('Final file size: ' . $fileSize . ' bytes');
                    \Log::info('Final file full path: ' . $fullTargetPath);
                    \Log::info('Final file realpath: ' . realpath($fullTargetPath));
                } else {
                    throw new \Exception('File tidak ditemukan setelah move: ' . $fullTargetPath);
                }
                
                // CRITICAL: Save ONLY the filename, NOT the full path!
                $data['foto'] = $fotoName;
                \Log::info('Foto data set to (ONLY FILENAME): ' . $fotoName);
                \Log::info('=== IMPORTANT: Saving ONLY filename to database, NOT full path ===');
            } catch (\Exception $e) {
                \Log::error('=== UPLOAD FOTO ERROR ===');
                \Log::error('Error message: ' . $e->getMessage());
                \Log::error('Error trace: ' . $e->getTraceAsString());
                return back()->with('error', 'Gagal upload foto: ' . $e->getMessage());
            }
        } else {
            \Log::info('No file uploaded in request');
        }

        \Log::info('Updating anggota with data: ' . json_encode($data));
        $anggota->update($data);
        \Log::info('Anggota updated successfully');
        \Log::info('=== UPDATE PROFILE END ===');

        return redirect()->route('anggota.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }
    
    /**
     * Serve foto anggota
     * Fallback method untuk serve foto jika symlink tidak tersedia di production
     */
    public function serveFoto($id)
    {
        $anggota = Anggota::findOrFail($id);
        
        if (!$anggota->foto) {
            abort(404, 'Foto tidak ditemukan');
        }
        
        $fotoFilename = basename($anggota->foto);
        $fotoPath = storage_path('app/public/anggotas/' . $fotoFilename);
        
        if (!file_exists($fotoPath)) {
            abort(404, 'File foto tidak ditemukan');
        }
        
        $mimeType = mime_content_type($fotoPath);
        
        return response()->file($fotoPath, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
}
