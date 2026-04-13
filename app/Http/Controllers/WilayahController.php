<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use App\Models\Admin;
use App\Models\Anggota;
use App\Models\RiwayatKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WilayahController extends Controller
{
    public function index(Request $request)
    {
        $query = Wilayah::query();

        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();

            // Filter untuk role admin_nasional hanya menampilkan tipe provinsi (wilayah)
            if ($user->role === 'admin_nasional') {
                $query->where('tipe', 'provinsi');
            }
            // Filter untuk role admin_wilayah hanya menampilkan tipe cabang
            elseif ($user->role === 'admin_wilayah') {
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
            }
            
            if ($matchedProvinsi) {
                $query->where('parent_id', $matchedProvinsi->id);
            } else {
                $query->whereHas('parent', function ($q) {
                    $q->where('tipe', 'provinsi');
                });
            }
            }
        }

        if ($search = $request->get('search')) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('kode', 'like', "%{$search}%")
                  ->orWhere('tipe', 'like', "%{$search}%");
        }

        if ($tipe = $request->get('tipe')) {
            $query->where('tipe', $tipe);
        }

        $wilayahs = $query->orderBy('nama')->paginate(12)->appends($request->query());
        $tipeOptions = ['provinsi', 'wilayah', 'cabang', 'komisariat'];

        return view('admin.wilayah.index', compact('wilayahs', 'tipeOptions'));
    }

    public function create()
    {
        $tipeOptions = ['provinsi', 'wilayah', 'cabang', 'komisariat'];
        $parents = Wilayah::orderBy('nama')->get();
        $admins = Admin::orderBy('name')->get();
        return view('admin.wilayah.create', compact('tipeOptions', 'parents', 'admins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'string', 'in:provinsi,wilayah,cabang,komisariat'],
            'kode' => ['nullable', 'string', 'max:50'],
            'parent_id' => ['nullable', 'exists:wilayahs,id'],
            'parent_id_cabang' => ['nullable', 'exists:admins,id'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:Aktif,Nonaktif'],
            // Admin wilayah fields
            'admin_name' => ['required', 'string', 'max:255'],
            'admin_username' => ['required', 'string', 'max:255', Rule::unique('admins', 'username')],
            'admin_email' => ['required', 'string', 'email', 'max:255', Rule::unique('admins', 'email')],
            'admin_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $validated['status'] = $validated['status'] ?? 'Aktif';

        DB::transaction(function () use ($validated) {
            $role = 'admin_wilayah'; // Default role (for provinsi)
            if ($validated['tipe'] === 'cabang') {
                $role = 'admin_cabang';
            } elseif ($validated['tipe'] === 'komisariat') {
                $role = 'admin_komisariat';
            }

            $admin = Admin::create([
                'name' => $validated['admin_name'],
                'username' => $validated['admin_username'],
                'email' => $validated['admin_email'],
                'password' => Hash::make($validated['admin_password']),
                'role' => $role,
            ]);

            $wilayah = Wilayah::create([
                'nama' => $validated['nama'],
                'tipe' => $validated['tipe'],
                'kode' => $validated['kode'] ?? null,
                'parent_id' => $validated['parent_id'] ?? null,
                'parent_id_cabang' => $admin->id,
                'deskripsi' => $validated['deskripsi'] ?? null,
                'status' => $validated['status'],
            ]);
        });

        return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah berhasil ditambahkan.');
    }

    public function show($id)
    {
        $wilayah = Wilayah::findOrFail($id);
        $anggotaCabang = collect();
        $kegiatanCabang = collect();
        $anggotaCount = 0;
        $kegiatanCount = 0;
        if ($wilayah->parent_id_cabang) {
            $anggotaCabang = Anggota::where('parent_id_cabang', $wilayah->parent_id_cabang)->orderBy('nama')->get();
            $kegiatanCabang = RiwayatKegiatan::where('parent_id_cabang', $wilayah->parent_id_cabang)->orderBy('tanggal_kegiatan', 'desc')->get();
            $anggotaCount = $anggotaCabang->count();
            $kegiatanCount = $kegiatanCabang->count();
        }
        return view('admin.wilayah.show', compact('wilayah', 'anggotaCabang', 'kegiatanCabang', 'anggotaCount', 'kegiatanCount'));
    }

    public function edit($id)
    {
        $wilayah = Wilayah::findOrFail($id);
        $tipeOptions = ['provinsi', 'cabang', 'komisariat'];
        $parents = Wilayah::where('id', '!=', $wilayah->id)->orderBy('nama')->get();
        $admins = Admin::orderBy('name')->get();
        return view('admin.wilayah.edit', compact('wilayah', 'tipeOptions', 'parents', 'admins'));
    }

    public function update(Request $request, $id)
    {
        $wilayah = Wilayah::findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'string', 'in:provinsi,wilayah,cabang,komisariat'],
            'kode' => ['nullable', 'string', 'max:50'],
            'parent_id' => ['nullable', 'exists:wilayahs,id', 'not_in:'.$wilayah->id],
            'parent_id_cabang' => ['nullable', 'exists:admins,id'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:Aktif,Nonaktif'],
        ]);

        $wilayah->update($validated);

        return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $wilayah = Wilayah::findOrFail($id);
        
        DB::transaction(function () use ($wilayah) {
            // Delete associated admin if exists
            if ($wilayah->parent_id_cabang) {
                $admin = Admin::find($wilayah->parent_id_cabang);
                if ($admin) {
                    $admin->delete();
                }
            }
            
            $wilayah->delete();
        });

        return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah dan akun admin terkait berhasil dihapus.');
    }
}
