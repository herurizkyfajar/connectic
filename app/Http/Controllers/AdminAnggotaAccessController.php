<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAnggotaAccessController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::orderBy('status', 'desc')
                          ->orderBy('nama', 'asc')
                          ->paginate(20);
        
        $totalAnggota = Anggota::count();
        $totalWithAccess = Anggota::where('status', 'Aktif')->count();
        $totalWithoutAccess = Anggota::where('status', 'Tidak Aktif')->count();
        
        return view('admin.anggota-access.index', compact('anggotas', 'totalAnggota', 'totalWithAccess', 'totalWithoutAccess'));
    }
    
    public function toggleStatus($id)
    {
        $anggota = Anggota::findOrFail($id);
        
        $anggota->status = $anggota->status === 'Aktif' ? 'Tidak Aktif' : 'Aktif';
        $anggota->save();
        
        $statusText = $anggota->status === 'Aktif' ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()
            ->with('success', "Akses anggota {$anggota->nama} berhasil {$statusText}!");
    }
    
    public function resetPassword($id)
    {
        $anggota = Anggota::findOrFail($id);
        
        $newPassword = 'password123'; // Default password
        $anggota->password = Hash::make($newPassword);
        $anggota->save();
        
        return redirect()->back()
            ->with('success', "Password {$anggota->nama} berhasil direset ke: {$newPassword}");
    }
    
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedIds = $request->input('selected_anggotas', []);
        
        if (empty($selectedIds)) {
            return redirect()->back()
                ->with('error', 'Pilih minimal satu anggota untuk melakukan aksi.');
        }
        
        $anggotas = Anggota::whereIn('id', $selectedIds);
        
        switch ($action) {
            case 'activate':
                $anggotas->update(['status' => 'Aktif']);
                $message = count($selectedIds) . ' anggota berhasil diaktifkan.';
                break;
                
            case 'deactivate':
                $anggotas->update(['status' => 'Tidak Aktif']);
                $message = count($selectedIds) . ' anggota berhasil dinonaktifkan.';
                break;
                
            case 'reset_password':
                $anggotas->update(['password' => Hash::make('password123')]);
                $message = 'Password ' . count($selectedIds) . ' anggota berhasil direset ke: password123';
                break;
                
            default:
                return redirect()->back()
                    ->with('error', 'Aksi tidak valid.');
        }
        
        return redirect()->back()
            ->with('success', $message);
    }
    
    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);
        $lmsReads = \Illuminate\Support\Facades\DB::table('lms_reads')
            ->join('lms', 'lms_reads.lms_id', '=', 'lms.id')
            ->where('lms_reads.anggota_id', $anggota->id)
            ->orderBy('lms_reads.read_at', 'desc')
            ->select(['lms.title','lms.slug','lms_reads.read_at'])
            ->get();
        
        return view('admin.anggota-access.show', compact('anggota','lmsReads'));
    }
    
    public function updateAccess(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:Aktif,Tidak Aktif',
            'keterangan' => 'nullable|string|max:500',
        ]);
        
        $anggota->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);
        
        $statusText = $anggota->status === 'Aktif' ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()
            ->with('success', "Akses anggota {$anggota->nama} berhasil {$statusText}!");
    }
}
