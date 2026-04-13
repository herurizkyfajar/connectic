<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Admin;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Anggota::query();
        
        // Base filtering based on role
        if (\Illuminate\Support\Facades\Auth::guard('admin')->check()) {
            $user = \Illuminate\Support\Facades\Auth::guard('admin')->user();
            if ($user->role === 'admin_wilayah') {
                $query->where('parent_id', $user->id);
            } elseif ($user->role === 'admin_cabang') {
                $query->where('parent_id_cabang', $user->id);
            }
        }

        // Clone query for statistics before applying search/filters
        $statsQuery = clone $query;
        $countTotal = $statsQuery->count();
        $countAktif = (clone $statsQuery)->where('status', 'Aktif')->count();
        $countTidakAktif = (clone $statsQuery)->where('status', 'Tidak Aktif')->count();
        $countJabatan = (clone $statsQuery)->whereNotNull('jabatan')->count();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('telepon', 'LIKE', "%{$search}%")
                  ->orWhere('jabatan', 'LIKE', "%{$search}%")
                  ->orWhere('pekerjaan', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', ucfirst($request->status));
        }

        // Jabatan filter
        if ($request->has('jabatan') && !empty($request->jabatan)) {
            $query->where('jabatan', ucfirst($request->jabatan));
        }

        $anggotas = $query->latest()->paginate(10)->appends($request->query());

        return view('admin.anggota.index', compact('anggotas', 'countTotal', 'countAktif', 'countTidakAktif', 'countJabatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admins = Admin::orderBy('name')->get();
        
        $loggedInAdmin = \Illuminate\Support\Facades\Auth::guard('admin')->user();
        $autoFill = [];
        
        if ($loggedInAdmin) {
            if ($loggedInAdmin->role === 'admin_cabang') {
                $autoFill['parent_id_cabang'] = $loggedInAdmin->id;
                // Find parent admin via Wilayah hierarchy
                $wilayah = Wilayah::where('parent_id_cabang', $loggedInAdmin->id)->first();
                if ($wilayah && $wilayah->parent) {
                    $autoFill['parent_id'] = $wilayah->parent->parent_id_cabang;
                }
            } elseif ($loggedInAdmin->role === 'admin_wilayah') {
                $autoFill['parent_id'] = $loggedInAdmin->id;
            }
        }

        return view('admin.anggota.create', compact('admins', 'autoFill'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:anggotas,email',
            'password' => 'required|string|min:8|confirmed',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'pekerjaan' => 'nullable|string|max:255',
            'jabatan' => 'nullable|in:Ketua umum,Wakil ketua,Sekretaris,Bendahara,Bidang kesekretariatan,Bidang kemitraan dan legal,Bidang program dan aptika,Bidang penelitian dan pengembangan sumber daya manusia,Bidang komunikasi publik',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'aktif_di' => 'nullable|array',
            'aktif_di.*' => 'in:nasional,wilayah,cabang,komisariat',
            'keterangan' => 'nullable|string',
            'parent_id' => 'nullable|exists:admins,id',
            'parent_id_cabang' => 'nullable|exists:admins,id',
        ]);

        $data = $request->all();
        $user = \Illuminate\Support\Facades\Auth::guard('admin')->user();

        if ($user) {
            if ($user->role === 'admin_wilayah' && empty($data['parent_id'])) {
                $data['parent_id'] = $user->id;
            } elseif ($user->role === 'admin_cabang') {
                $data['parent_id_cabang'] = $user->id;
                 // Find parent admin
                 $wilayah = Wilayah::where('parent_id_cabang', $user->id)->first();
                 if ($wilayah && $wilayah->parent && empty($data['parent_id'])) {
                      $data['parent_id'] = $wilayah->parent->parent_id_cabang;
                 }
            }
        }

        // Hash password
        $data['password'] = bcrypt($request->password);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            \Log::info('=== ADMIN UPLOAD FOTO START ===');
            try {
                $foto = $request->file('foto');
                \Log::info('File received: ' . $foto->getClientOriginalName());
                
                // Generate unique filename
                $fotoName = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
                
                // Upload directory
                $uploadPath = storage_path('app/public/anggotas');
                
                // Ensure directory exists
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Move file
                $foto->move($uploadPath, $fotoName);
                
                \Log::info('File uploaded successfully: ' . $fotoName);
                $data['foto'] = $fotoName;
            } catch (\Exception $e) {
                \Log::error('Admin upload error: ' . $e->getMessage());
                return back()->with('error', 'Gagal upload foto: ' . $e->getMessage());
            }
        }

        Anggota::create($data);

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);
        
        // Load sertifikat dengan relasi riwayat kegiatan
        $sertifikats = $anggota->sertifikats()
            ->with('riwayatKegiatan')
            ->orderBy('tanggal_terbit', 'desc')
            ->get();
        
        // Load riwayat kegiatan (melalui absensi kegiatan)
        $riwayatKegiatans = \App\Models\AbsensiKegiatan::where('anggota_id', $anggota->id)
            ->with('riwayatKegiatan')
            ->orderBy('waktu_absen', 'desc')
            ->limit(10) // Limit to last 10 activities
            ->get()
            ->pluck('riwayatKegiatan')
            ->unique('id');
        
        return view('admin.anggota.show', compact('anggota', 'sertifikats', 'riwayatKegiatans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        $admins = Admin::orderBy('name')->get();
        return view('admin.anggota.edit', compact('anggota', 'admins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:anggotas,email,' . $anggota->id,
            'password' => 'nullable|string|min:8|confirmed',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'pekerjaan' => 'nullable|string|max:255',
            'jabatan' => 'nullable|in:Ketua umum,Wakil ketua,Sekretaris,Bendahara,Bidang kesekretariatan,Bidang kemitraan dan legal,Bidang program dan aptika,Bidang penelitian dan pengembangan sumber daya manusia,Bidang komunikasi publik',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'aktif_di' => 'nullable|array',
            'aktif_di.*' => 'in:nasional,wilayah,cabang,komisariat',
            'keterangan' => 'nullable|string',
            'parent_id' => 'nullable|exists:admins,id',
            'parent_id_cabang' => 'nullable|exists:admins,id',
        ]);

        $data = $request->except(['password', 'password_confirmation']);

        // Update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            \Log::info('=== ADMIN UPDATE FOTO START ===');
            try {
                $foto = $request->file('foto');
                \Log::info('File received: ' . $foto->getClientOriginalName());
                
                // Generate unique filename
                $fotoName = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
                
                // Upload directory
                $uploadPath = storage_path('app/public/anggotas');
                
                // Ensure directory exists
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Delete old foto
                if ($anggota->foto) {
                    $oldFotoPath = storage_path('app/public/anggotas/' . $anggota->foto);
                    if (file_exists($oldFotoPath)) {
                        @unlink($oldFotoPath);
                        \Log::info('Old foto deleted: ' . $anggota->foto);
                    }
                }
                
                // Move file
                $foto->move($uploadPath, $fotoName);
                
                \Log::info('File uploaded successfully: ' . $fotoName);
                $data['foto'] = $fotoName;
            } catch (\Exception $e) {
                \Log::error('Admin update foto error: ' . $e->getMessage());
                return back()->with('error', 'Gagal upload foto: ' . $e->getMessage());
            }
        }

        $anggota->update($data);

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        
        // Delete foto if exists
        if ($anggota->foto) {
            $fotoPath = storage_path('app/public/anggotas/' . $anggota->foto);
            if (file_exists($fotoPath)) {
                @unlink($fotoPath);
                \Log::info('Foto deleted during member removal: ' . $anggota->foto);
            }
        }

        $anggota->delete();

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil dihapus!');
    }
}
