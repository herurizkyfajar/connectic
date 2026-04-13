<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pengajuan::query();

        // Role based filtering
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            if ($user->role === 'admin_wilayah') {
                // Assuming admin_wilayah sees what they created or related to them
                // Based on previous tasks, usually filter by parent_id = user id
                $query->where('parent_id', $user->id);
            } elseif ($user->role === 'admin_cabang') {
                $query->where('parent_id_cabang', $user->id);
            }
        }

        $pengajuans = $query->latest()->paginate(10);

        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $adminWilayahs = \App\Models\Admin::where('role', 'admin_wilayah')->orderBy('name')->get();
        $adminCabangs = \App\Models\Admin::where('role', 'admin_cabang')->orderBy('name')->get();
        
        $user = Auth::guard('admin')->user();
        $autoFill = [];
        
        if ($user) {
            if ($user->role === 'admin_wilayah') {
                $autoFill['parent_id'] = $user->id;
            } elseif ($user->role === 'admin_cabang') {
                $autoFill['parent_id_cabang'] = $user->id;
                // Cari parent wilayah
                $wilayah = \App\Models\Wilayah::where('parent_id_cabang', $user->id)->first();
                if ($wilayah && $wilayah->parent) {
                    $autoFill['parent_id'] = $wilayah->parent->parent_id_cabang;
                }
            }
        }

        return view('admin.pengajuan.create', compact('adminWilayahs', 'adminCabangs', 'autoFill'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_pengajuan' => 'required|string|max:255',
            'tanggal_pengajuan' => 'required|date',
            'status' => 'required|string|in:Pending,Disetujui,Ditolak',
            'deskripsi' => 'nullable|string',
            'parent_id' => 'nullable|exists:admins,id',
            'parent_id_cabang' => 'nullable|exists:admins,id',
            'link_berkas' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        
        // Auto assign parent IDs based on role
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            if ($user->role === 'admin_wilayah') {
                $data['parent_id'] = $user->id;
            } elseif ($user->role === 'admin_cabang') {
                $data['parent_id_cabang'] = $user->id;
                // Try to find associated wilayah parent
                $wilayah = \App\Models\Wilayah::where('parent_id_cabang', $user->id)->first();
                if ($wilayah && $wilayah->parent && $wilayah->parent->parent_id_cabang) {
                    $data['parent_id'] = $wilayah->parent->parent_id_cabang;
                }
            }
        }

        Pengajuan::create($data);

        return redirect()->route('pengajuan.index')
            ->with('success', 'Pengajuan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengajuan $pengajuan)
    {
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengajuan $pengajuan)
    {
        $adminWilayahs = \App\Models\Admin::where('role', 'admin_wilayah')->orderBy('name')->get();
        $adminCabangs = \App\Models\Admin::where('role', 'admin_cabang')->orderBy('name')->get();
        
        $user = Auth::guard('admin')->user();
        $autoFill = [];
        
        if ($user) {
            if ($user->role === 'admin_wilayah') {
                $autoFill['parent_id'] = $user->id;
            } elseif ($user->role === 'admin_cabang') {
                $autoFill['parent_id_cabang'] = $user->id;
                // Jika parent_id kosong, coba isi otomatis
                if (!$pengajuan->parent_id) {
                    $wilayah = \App\Models\Wilayah::where('parent_id_cabang', $user->id)->first();
                    if ($wilayah && $wilayah->parent) {
                        $autoFill['parent_id'] = $wilayah->parent->parent_id_cabang;
                    }
                } else {
                    $autoFill['parent_id'] = $pengajuan->parent_id;
                }
            }
        }
        
        return view('admin.pengajuan.edit', compact('pengajuan', 'adminWilayahs', 'adminCabangs', 'autoFill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'judul_pengajuan' => 'required|string|max:255',
            'tanggal_pengajuan' => 'required|date',
            'status' => 'required|string|in:Pending,Disetujui,Ditolak',
            'deskripsi' => 'nullable|string',
            'parent_id' => 'nullable|exists:admins,id',
            'parent_id_cabang' => 'nullable|exists:admins,id',
            'link_berkas' => 'nullable|string|max:255',
        ]);

        $data = $request->all();

        // Enforce parent IDs based on role
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            if ($user->role === 'admin_wilayah') {
                $data['parent_id'] = $user->id;
            } elseif ($user->role === 'admin_cabang') {
                $data['parent_id_cabang'] = $user->id;
                // Force correct wilayah parent
                $wilayah = \App\Models\Wilayah::where('parent_id_cabang', $user->id)->first();
                if ($wilayah && $wilayah->parent && $wilayah->parent->parent_id_cabang) {
                    $data['parent_id'] = $wilayah->parent->parent_id_cabang;
                }
            }
        }

        $pengajuan->update($data);

        return redirect()->route('pengajuan.index')
            ->with('success', 'Pengajuan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengajuan $pengajuan)
    {
        $pengajuan->delete();

        return redirect()->route('pengajuan.index')
            ->with('success', 'Pengajuan berhasil dihapus.');
    }
}
