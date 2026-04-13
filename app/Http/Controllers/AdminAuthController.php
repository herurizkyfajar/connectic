<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Anggota;
use App\Models\MeetingNote;
use App\Models\RiwayatKegiatan;
use App\Models\AbsensiKegiatan;
use App\Models\SertifikatAnggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        // If user is already logged in, redirect to dashboard
        if (Auth::guard('admin')->check()) {
            if (Auth::guard('admin')->user()->role === 'admin_nasional') {
                return redirect()->route('admin.nasional.dashboard');
            }
            if (Auth::guard('admin')->user()->role === 'admin_wilayah') {
                return redirect()->route('admin.wilayah.dashboard');
            }
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();
            
            if ($admin->role === 'admin_nasional') {
                return redirect()->route('admin.nasional.dashboard');
            }

            if ($admin->role === 'admin_wilayah') {
                return redirect()->route('admin.wilayah.dashboard');
            }

            return redirect()->intended('/admin/dashboard');
        }

        throw ValidationException::withMessages([
            'username' => ['Kredensial yang diberikan tidak valid.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }

    public function dashboard()
    {
        $user = Auth::guard('admin')->user();

        // Redirect admin nasional to their specific dashboard
        if ($user->role === 'admin_nasional') {
            return redirect()->route('admin.nasional.dashboard');
        }

        if ($user->role === 'admin_wilayah') {
            return redirect()->route('admin.wilayah.dashboard');
        }

        // Calculate statistics
        if ($user->role === 'admin_cabang') {
            $anggotaCount = Anggota::where('parent_id_cabang', $user->id)->count();
            $kegiatanCount = RiwayatKegiatan::where('parent_id_cabang', $user->id)->count();
            $absensiCount = AbsensiKegiatan::whereHas('riwayatKegiatan', function($q) use ($user) {
                $q->where('parent_id_cabang', $user->id);
            })->count();
            $sertifikatCount = SertifikatAnggota::whereHas('riwayatKegiatan', function($q) use ($user) {
                $q->where('parent_id_cabang', $user->id);
            })->count();
        } else {
            $anggotaCount = Anggota::count();
            $kegiatanCount = RiwayatKegiatan::count();
            $absensiCount = AbsensiKegiatan::count();
            $sertifikatCount = SertifikatAnggota::count();
        }

        // Get top 5 anggota paling aktif hadir meeting
        $topMeetingAttendance = $this->getTopMeetingAttendance();
        
        // Get analisis keaktifan anggota
        $analisisKeaktifan = $this->getAnalisisKeaktifan();
        
        return view('admin.dashboard', compact(
            'topMeetingAttendance', 
            'analisisKeaktifan',
            'anggotaCount',
            'kegiatanCount',
            'absensiCount',
            'sertifikatCount'
        ));
    }

    /**
     * Get top 5 anggota paling aktif hadir meeting
     */
    private function getTopMeetingAttendance()
    {
        // Get all meeting notes dengan attendance
        $meetings = MeetingNote::whereNotNull('attendance')
                               ->where('attendance', '!=', '')
                               ->get();
        
        // Count attendance frequency
        $attendanceCount = [];
        
        foreach ($meetings as $meeting) {
            // Parse attendance (comma-separated)
            $attendees = array_map('trim', explode(',', $meeting->attendance));
            
            foreach ($attendees as $attendee) {
                if (!empty($attendee)) {
                    if (!isset($attendanceCount[$attendee])) {
                        $attendanceCount[$attendee] = 0;
                    }
                    $attendanceCount[$attendee]++;
                }
            }
        }
        
        // Sort by count descending
        arsort($attendanceCount);
        
        // Take top 5
        $topAttendees = array_slice($attendanceCount, 0, 5, true);
        
        // Get anggota details
        $topMeetingAttendance = [];
        foreach ($topAttendees as $name => $count) {
            $anggota = Anggota::where('nama', $name)->first();
            
            $topMeetingAttendance[] = [
                'nama' => $name,
                'count' => $count,
                'anggota' => $anggota, // Null if not found in anggota table
                'foto' => $anggota ? $anggota->foto : null,
                'jabatan' => $anggota ? $anggota->jabatan : '-',
            ];
        }
        
        return $topMeetingAttendance;
    }
    
    /**
     * Get analisis keaktifan anggota
     */
    private function getAnalisisKeaktifan()
    {
        $totalAnggota = Anggota::where('status', 'Aktif')->count();
        
        // Hitung anggota yang pernah absen kegiatan (30 hari terakhir)
        $anggotaAktifKegiatan = DB::table('absensi_kegiatans')
            ->where('waktu_absen', '>=', now()->subDays(30))
            ->distinct('anggota_id')
            ->count('anggota_id');
        
        // Hitung anggota yang pernah hadir meeting (30 hari terakhir)
        $recentMeetings = MeetingNote::where('meeting_date', '>=', now()->subDays(30))
                                     ->whereNotNull('attendance')
                                     ->where('attendance', '!=', '')
                                     ->get();
        
        $anggotaAktifMeeting = [];
        foreach ($recentMeetings as $meeting) {
            $attendees = array_map('trim', explode(',', $meeting->attendance));
            foreach ($attendees as $attendee) {
                if (!empty($attendee)) {
                    $anggotaAktifMeeting[$attendee] = true;
                }
            }
        }
        $anggotaAktifMeetingCount = count($anggotaAktifMeeting);
        
        // Hitung anggota yang memiliki sertifikat
        $anggotaDenganSertifikat = DB::table('sertifikat_anggotas')
            ->distinct('anggota_id')
            ->count('anggota_id');
        
        // Hitung tingkat keaktifan
        $tingkatKeaktifanKegiatan = $totalAnggota > 0 ? round(($anggotaAktifKegiatan / $totalAnggota) * 100, 1) : 0;
        $tingkatKeaktifanMeeting = $totalAnggota > 0 ? round(($anggotaAktifMeetingCount / $totalAnggota) * 100, 1) : 0;
        $tingkatSertifikasi = $totalAnggota > 0 ? round(($anggotaDenganSertifikat / $totalAnggota) * 100, 1) : 0;
        
        // Kategori keaktifan
        $kategoriKeaktifan = $this->getKategoriKeaktifan();
        
        return [
            'total_anggota' => $totalAnggota,
            'anggota_aktif_kegiatan' => $anggotaAktifKegiatan,
            'anggota_aktif_meeting' => $anggotaAktifMeetingCount,
            'anggota_dengan_sertifikat' => $anggotaDenganSertifikat,
            'tingkat_keaktifan_kegiatan' => $tingkatKeaktifanKegiatan,
            'tingkat_keaktifan_meeting' => $tingkatKeaktifanMeeting,
            'tingkat_sertifikasi' => $tingkatSertifikasi,
            'kategori' => $kategoriKeaktifan,
        ];
    }
    
    /**
     * Get kategori keaktifan anggota (Sangat Aktif, Aktif, Kurang Aktif, Tidak Aktif)
     */
    private function getKategoriKeaktifan()
    {
        $anggotaAktif = Anggota::where('status', 'Aktif')->get();
        
        $kategori = [
            'sangat_aktif' => 0,
            'aktif' => 0,
            'kurang_aktif' => 0,
            'tidak_aktif' => 0,
        ];
        
        foreach ($anggotaAktif as $anggota) {
            // Hitung kehadiran kegiatan (30 hari terakhir)
            $kehadiranKegiatan = DB::table('absensi_kegiatans')
                ->where('anggota_id', $anggota->id)
                ->where('waktu_absen', '>=', now()->subDays(30))
                ->count();
            
            // Hitung kehadiran meeting (30 hari terakhir)
            $kehadiranMeeting = MeetingNote::where('meeting_date', '>=', now()->subDays(30))
                ->whereNotNull('attendance')
                ->where('attendance', 'LIKE', '%' . $anggota->nama . '%')
                ->count();
            
            // Total skor keaktifan
            $skor = $kehadiranKegiatan + $kehadiranMeeting;
            
            // Kategorikan berdasarkan skor
            if ($skor >= 5) {
                $kategori['sangat_aktif']++;
            } elseif ($skor >= 3) {
                $kategori['aktif']++;
            } elseif ($skor >= 1) {
                $kategori['kurang_aktif']++;
            } else {
                $kategori['tidak_aktif']++;
            }
        }
        
        return $kategori;
    }
    
    /**
     * Halaman detail analisis keaktifan anggota
     */
    public function analisisKeaktifan(Request $request)
    {
        $adminUser = Auth::guard('admin')->user();
        // Get filter parameters
        $filterPeriode = $request->get('periode', '30_hari'); // Default: 30 hari
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun', now()->year);
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        // Determine date range based on filter
        $dateFrom = null;
        $dateTo = null;
        $periodeLabel = '';
        
        switch ($filterPeriode) {
            case '7_hari':
                $dateFrom = now()->subDays(7);
                $dateTo = now();
                $periodeLabel = '7 Hari Terakhir';
                break;
            case '30_hari':
                $dateFrom = now()->subDays(30);
                $dateTo = now();
                $periodeLabel = '30 Hari Terakhir';
                break;
            case '90_hari':
                $dateFrom = now()->subDays(90);
                $dateTo = now();
                $periodeLabel = '90 Hari Terakhir';
                break;
            case 'bulan':
                if ($bulan && $tahun) {
                    $dateFrom = \Carbon\Carbon::createFromFormat('Y-m', $tahun . '-' . $bulan)->startOfMonth();
                    $dateTo = \Carbon\Carbon::createFromFormat('Y-m', $tahun . '-' . $bulan)->endOfMonth();
                    $periodeLabel = \Carbon\Carbon::createFromFormat('Y-m', $tahun . '-' . $bulan)->format('F Y');
                }
                break;
            case 'tahun':
                if ($tahun) {
                    $dateFrom = \Carbon\Carbon::createFromFormat('Y', $tahun)->startOfYear();
                    $dateTo = \Carbon\Carbon::createFromFormat('Y', $tahun)->endOfYear();
                    $periodeLabel = 'Tahun ' . $tahun;
                }
                break;
            case 'rentang':
                if ($startDate && $endDate) {
                    $dateFrom = \Carbon\Carbon::parse($startDate);
                    $dateTo = \Carbon\Carbon::parse($endDate);
                    $periodeLabel = $dateFrom->format('d/m/Y') . ' - ' . $dateTo->format('d/m/Y');
                }
                break;
            case 'semua':
                $dateFrom = null;
                $dateTo = null;
                $periodeLabel = 'Semua Waktu';
                break;
        }
        
        $anggotaQuery = Anggota::where('status', 'Aktif');
        if ($adminUser && $adminUser->role === 'admin_wilayah') {
            $anggotaQuery->where('parent_id', $adminUser->id);
        }
        $anggotaAktif = $anggotaQuery->get();
        
        $dataAnalisis = [];
        
        foreach ($anggotaAktif as $anggota) {
            // Hitung kehadiran kegiatan (periode filter)
            $queryKegiatan = DB::table('absensi_kegiatans')
                ->where('anggota_id', $anggota->id);
            
            if ($dateFrom && $dateTo) {
                $queryKegiatan->whereBetween('waktu_absen', [$dateFrom, $dateTo]);
            }
            
            $kehadiranKegiatan = $queryKegiatan->count();
            
            // Hitung kehadiran kegiatan (total)
            $totalKehadiranKegiatan = DB::table('absensi_kegiatans')
                ->where('anggota_id', $anggota->id)
                ->count();
            
            // Hitung kehadiran meeting (periode filter)
            $queryMeeting = MeetingNote::whereNotNull('attendance')
                ->where('attendance', 'LIKE', '%' . $anggota->nama . '%');
            
            if ($dateFrom && $dateTo) {
                $queryMeeting->whereBetween('meeting_date', [$dateFrom, $dateTo]);
            }
            
            $kehadiranMeeting = $queryMeeting->count();
            
            // Hitung kehadiran meeting (total)
            $totalKehadiranMeeting = MeetingNote::whereNotNull('attendance')
                ->where('attendance', 'LIKE', '%' . $anggota->nama . '%')
                ->count();
            
            // Hitung sertifikat
            $jumlahSertifikat = DB::table('sertifikat_anggotas')
                ->where('anggota_id', $anggota->id)
                ->count();
            
            // Total skor keaktifan (periode filter)
            $skor = $kehadiranKegiatan + $kehadiranMeeting;
            
            // Tentukan kategori
            if ($skor >= 5) {
                $kategori = 'Sangat Aktif';
                $badge = 'success';
            } elseif ($skor >= 3) {
                $kategori = 'Aktif';
                $badge = 'info';
            } elseif ($skor >= 1) {
                $kategori = 'Kurang Aktif';
                $badge = 'warning';
            } else {
                $kategori = 'Tidak Aktif';
                $badge = 'danger';
            }
            
            // Hitung persentase keaktifan
            $totalKegiatan = DB::table('riwayat_kegiatans')
                ->where('created_at', '>=', $anggota->created_at)
                ->count();
            
            $persentaseKehadiran = $totalKegiatan > 0 
                ? round(($totalKehadiranKegiatan / $totalKegiatan) * 100, 1) 
                : 0;
            
            $dataAnalisis[] = [
                'anggota' => $anggota,
                'kehadiran_kegiatan' => $kehadiranKegiatan,
                'kehadiran_meeting' => $kehadiranMeeting,
                'total_kehadiran_kegiatan' => $totalKehadiranKegiatan,
                'total_kehadiran_meeting' => $totalKehadiranMeeting,
                'jumlah_sertifikat' => $jumlahSertifikat,
                'skor' => $skor,
                'kategori' => $kategori,
                'badge' => $badge,
                'persentase_kehadiran' => $persentaseKehadiran,
            ];
        }
        
        // Sort by skor descending
        usort($dataAnalisis, function($a, $b) {
            return $b['skor'] - $a['skor'];
        });
        
        return view('admin.analisis-keaktifan', compact('dataAnalisis', 'filterPeriode', 'periodeLabel', 'bulan', 'tahun', 'startDate', 'endDate'));
    }
    
    /**
     * Export analisis keaktifan ke PDF (Print-friendly view)
     */
    public function exportAnalisisPDF(Request $request)
    {
        $adminUser = Auth::guard('admin')->user();
        // Get filter parameters (sama seperti analisisKeaktifan)
        $filterPeriode = $request->get('periode', '30_hari');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun', now()->year);
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        // Determine date range
        $dateFrom = null;
        $dateTo = null;
        $periodeLabel = '';
        
        switch ($filterPeriode) {
            case '7_hari':
                $dateFrom = now()->subDays(7);
                $dateTo = now();
                $periodeLabel = '7 Hari Terakhir';
                break;
            case '30_hari':
                $dateFrom = now()->subDays(30);
                $dateTo = now();
                $periodeLabel = '30 Hari Terakhir';
                break;
            case '90_hari':
                $dateFrom = now()->subDays(90);
                $dateTo = now();
                $periodeLabel = '90 Hari Terakhir';
                break;
            case 'bulan':
                if ($bulan && $tahun) {
                    $dateFrom = \Carbon\Carbon::createFromFormat('Y-m', $tahun . '-' . $bulan)->startOfMonth();
                    $dateTo = \Carbon\Carbon::createFromFormat('Y-m', $tahun . '-' . $bulan)->endOfMonth();
                    $periodeLabel = \Carbon\Carbon::createFromFormat('Y-m', $tahun . '-' . $bulan)->format('F Y');
                }
                break;
            case 'tahun':
                if ($tahun) {
                    $dateFrom = \Carbon\Carbon::createFromFormat('Y', $tahun)->startOfYear();
                    $dateTo = \Carbon\Carbon::createFromFormat('Y', $tahun)->endOfYear();
                    $periodeLabel = 'Tahun ' . $tahun;
                }
                break;
            case 'rentang':
                if ($startDate && $endDate) {
                    $dateFrom = \Carbon\Carbon::parse($startDate);
                    $dateTo = \Carbon\Carbon::parse($endDate);
                    $periodeLabel = $dateFrom->format('d/m/Y') . ' - ' . $dateTo->format('d/m/Y');
                }
                break;
            case 'semua':
                $dateFrom = null;
                $dateTo = null;
                $periodeLabel = 'Semua Waktu';
                break;
        }
        
        $anggotaQuery = Anggota::where('status', 'Aktif');
        if ($adminUser && $adminUser->role === 'admin_wilayah') {
            $anggotaQuery->where('parent_id', $adminUser->id);
        }
        $anggotaAktif = $anggotaQuery->get();
        
        $dataAnalisis = [];
        
        foreach ($anggotaAktif as $anggota) {
            $queryKegiatan = DB::table('absensi_kegiatans')
                ->where('anggota_id', $anggota->id);
            
            if ($dateFrom && $dateTo) {
                $queryKegiatan->whereBetween('waktu_absen', [$dateFrom, $dateTo]);
            }
            
            $kehadiranKegiatan = $queryKegiatan->count();
            
            $totalKehadiranKegiatan = DB::table('absensi_kegiatans')
                ->where('anggota_id', $anggota->id)
                ->count();
            
            $queryMeeting = MeetingNote::whereNotNull('attendance')
                ->where('attendance', 'LIKE', '%' . $anggota->nama . '%');
            
            if ($dateFrom && $dateTo) {
                $queryMeeting->whereBetween('meeting_date', [$dateFrom, $dateTo]);
            }
            
            $kehadiranMeeting = $queryMeeting->count();
            
            $totalKehadiranMeeting = MeetingNote::whereNotNull('attendance')
                ->where('attendance', 'LIKE', '%' . $anggota->nama . '%')
                ->count();
            
            $jumlahSertifikat = DB::table('sertifikat_anggotas')
                ->where('anggota_id', $anggota->id)
                ->count();
            
            $skor = $kehadiranKegiatan + $kehadiranMeeting;
            
            if ($skor >= 5) {
                $kategori = 'Sangat Aktif';
                $badge = 'success';
            } elseif ($skor >= 3) {
                $kategori = 'Aktif';
                $badge = 'info';
            } elseif ($skor >= 1) {
                $kategori = 'Kurang Aktif';
                $badge = 'warning';
            } else {
                $kategori = 'Tidak Aktif';
                $badge = 'danger';
            }
            
            $totalKegiatan = DB::table('riwayat_kegiatans')
                ->where('created_at', '>=', $anggota->created_at)
                ->count();
            
            $persentaseKehadiran = $totalKegiatan > 0 
                ? round(($totalKehadiranKegiatan / $totalKegiatan) * 100, 1) 
                : 0;
            
            $dataAnalisis[] = [
                'anggota' => $anggota,
                'kehadiran_kegiatan' => $kehadiranKegiatan,
                'kehadiran_meeting' => $kehadiranMeeting,
                'total_kehadiran_kegiatan' => $totalKehadiranKegiatan,
                'total_kehadiran_meeting' => $totalKehadiranMeeting,
                'jumlah_sertifikat' => $jumlahSertifikat,
                'skor' => $skor,
                'kategori' => $kategori,
                'badge' => $badge,
                'persentase_kehadiran' => $persentaseKehadiran,
            ];
        }
        
        usort($dataAnalisis, function($a, $b) {
            return $b['skor'] - $a['skor'];
        });
        
        // Hitung statistik summary
        $totalAnggota = count($dataAnalisis);
        $sangat_aktif = count(array_filter($dataAnalisis, fn($d) => $d['kategori'] == 'Sangat Aktif'));
        $aktif = count(array_filter($dataAnalisis, fn($d) => $d['kategori'] == 'Aktif'));
        $kurang_aktif = count(array_filter($dataAnalisis, fn($d) => $d['kategori'] == 'Kurang Aktif'));
        $tidak_aktif = count(array_filter($dataAnalisis, fn($d) => $d['kategori'] == 'Tidak Aktif'));
        
        return view('admin.analisis-keaktifan-pdf', compact(
            'dataAnalisis', 
            'periodeLabel', 
            'totalAnggota',
            'sangat_aktif',
            'aktif',
            'kurang_aktif',
            'tidak_aktif'
        ));
    }
}
