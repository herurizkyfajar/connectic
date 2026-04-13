<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use App\Models\Anggota;
use App\Models\RiwayatKegiatan;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;

class AdminWilayahController extends Controller
{
    public function dashboard()
    {
        $adminId = Auth::guard('admin')->id();
        $user = Auth::guard('admin')->user();
        
        $wilayahId = null;

        if ($user->role === 'admin_wilayah') {
            $username = (string) $user->username;
            $matchedProvinsi = null;
            
            if (preg_match('/^provinsi[_-](.+)$/i', $username, $m)) {
                $slug = strtolower($m[1]);
                $nameGuess = ucwords(str_replace(['_', '-'], ' ', $slug));
                $abbrMap = [
                    'jabar' => ['jawa barat'],
                    'jatim' => ['jawa timur'],
                    'jateng' => ['jawa tengah'],
                    'dki' => ['dki jakarta', 'jakarta'],
                    'diy' => ['daerah istimewa yogyakarta', 'yogyakarta'],
                    'sumut' => ['sumatera utara'],
                    'sumsel' => ['sumatera selatan'],
                    'babel' => ['kepulauan bangka belitung', 'bangka belitung'],
                    'ntb' => ['nusa tenggara barat'],
                    'ntt' => ['nusa tenggara timur'],
                    'kalbar' => ['kalimantan barat'],
                    'kalteng' => ['kalimantan tengah'],
                    'kaltim' => ['kalimantan timur'],
                    'kaltara' => ['kalimantan utara'],
                    'sulsel' => ['sulawesi selatan'],
                    'sulbar' => ['sulawesi barat'],
                    'sulteng' => ['sulawesi tengah'],
                    'sultra' => ['sulawesi tenggara'],
                    'gorontalo' => ['gorontalo'],
                    'maluku' => ['maluku'],
                    'malut' => ['maluku utara'],
                    'papbar' => ['papua barat'],
                    'papua' => ['papua'],
                ];
                
                $matchedProvinsi = Wilayah::where('tipe', 'provinsi')
                    ->where(function ($q) use ($slug, $nameGuess, $abbrMap) {
                        $q->whereRaw('LOWER(kode) = ?', [$slug])
                          ->orWhereRaw('LOWER(nama) = ?', [strtolower($nameGuess)]);
                        if (isset($abbrMap[$slug])) {
                            foreach ($abbrMap[$slug] as $full) {
                                $q->orWhereRaw('LOWER(nama) = ?', [strtolower($full)])
                                  ->orWhereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($full) . '%']);
                            }
                        }
                    })
                    ->first();

                if ($matchedProvinsi) {
                    $wilayahId = $matchedProvinsi->id;
                }
            }
        }

        $jumlahWilayahCabang = Wilayah::where('tipe', 'cabang');
        
        if ($wilayahId) {
            $jumlahWilayahCabang->where('parent_id', $wilayahId);
        } else {
            $jumlahWilayahCabang->where('parent_id', $adminId);
        }
            
        $jumlahWilayahCabang = $jumlahWilayahCabang->count();

        $jumlahAnggota = Anggota::where('parent_id', $adminId)
            ->count();

        $jumlahKegiatan = RiwayatKegiatan::where('parent_id', $adminId)
            ->count();

        $pengajuans = Pengajuan::where('parent_id', $adminId)
            ->where('status', 'Pending')
            ->latest()
            ->take(10)
            ->get();

        $kegiatanAkanDatang = RiwayatKegiatan::where('parent_id', $adminId)
            ->akanDatang()
            ->orderBy('tanggal_kegiatan', 'asc')
            ->take(10)
            ->get();

        return view('admin.wilayah.dashboard', compact(
            'jumlahWilayahCabang',
            'jumlahAnggota',
            'jumlahKegiatan',
            'pengajuans',
            'kegiatanAkanDatang'
        ));
    }
}
