<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\SertifikatAnggota;
use App\Models\RiwayatKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnggotaSertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggota = Auth::guard('anggota')->user();
        $sertifikats = $anggota->sertifikats()
            ->with('riwayatKegiatan')
            ->orderBy('tanggal_terbit', 'desc')
            ->paginate(10);

        return view('anggota.sertifikat.index', compact('sertifikats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('anggota.sertifikat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $anggota = Auth::guard('anggota')->user();

        $validated = $request->validate([
            'riwayat_kegiatan_id' => 'required|exists:riwayat_kegiatans,id',
            'nomor_sertifikat' => 'nullable|string|max:255',
            'tanggal_terbit' => 'required|date',
            'penyelenggara' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Add anggota_id
        $validated['anggota_id'] = $anggota->id;

        // Handle file upload
        if ($request->hasFile('file_sertifikat')) {
            $file = $request->file('file_sertifikat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('sertifikats', $filename, 'public');
            $validated['file_sertifikat'] = $filename;
        }

        SertifikatAnggota::create($validated);

        return redirect()->route('anggota.sertifikat.index')
            ->with('success', 'Sertifikat berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SertifikatAnggota $sertifikat)
    {
        $anggota = Auth::guard('anggota')->user();

        // Check if sertifikat belongs to current anggota
        if ($sertifikat->anggota_id !== $anggota->id) {
            abort(403, 'Unauthorized access');
        }

        $sertifikat->load('riwayatKegiatan');
        return view('anggota.sertifikat.show', compact('sertifikat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SertifikatAnggota $sertifikat)
    {
        $anggota = Auth::guard('anggota')->user();

        // Check if sertifikat belongs to current anggota
        if ($sertifikat->anggota_id !== $anggota->id) {
            abort(403, 'Unauthorized access');
        }

        $sertifikat->load('riwayatKegiatan');
        return view('anggota.sertifikat.edit', compact('sertifikat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SertifikatAnggota $sertifikat)
    {
        $anggota = Auth::guard('anggota')->user();

        // Check if sertifikat belongs to current anggota
        if ($sertifikat->anggota_id !== $anggota->id) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'riwayat_kegiatan_id' => 'required|exists:riwayat_kegiatans,id',
            'nomor_sertifikat' => 'nullable|string|max:255',
            'tanggal_terbit' => 'required|date',
            'penyelenggara' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Handle file upload
        if ($request->hasFile('file_sertifikat')) {
            // Delete old file if exists
            if ($sertifikat->file_sertifikat) {
                Storage::disk('public')->delete('sertifikats/' . $sertifikat->file_sertifikat);
            }

            $file = $request->file('file_sertifikat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('sertifikats', $filename, 'public');
            $validated['file_sertifikat'] = $filename;
        }

        $sertifikat->update($validated);

        return redirect()->route('anggota.sertifikat.index')
            ->with('success', 'Sertifikat berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $anggota = Auth::guard('anggota')->user();
    
        // Ambil sertifikat hanya jika milik anggota yang login
        $sertifikat = SertifikatAnggota::where('id', $id)
            ->where('anggota_id', $anggota->id)
            ->first();
    
        if (!$sertifikat) {
            \Log::warning('Anggota sertifikat delete denied: not found or not owned', [
                'requested_id' => $id,
                'logged_in_anggota_id' => $anggota->id,
                'logged_in_anggota_email' => $anggota->email ?? null,
                'logged_in_anggota_nama' => $anggota->nama ?? null,
            ]);
            abort(403, 'Unauthorized access');
        }
    
        // Hapus file jika ada (disanitasi)
        if ($sertifikat->file_sertifikat) {
            $filename = basename($sertifikat->file_sertifikat);
            \Storage::disk('public')->delete('sertifikats/' . $filename);
        }
    
        $sertifikat->delete();
    
        return redirect()->route('anggota.sertifikat.index')
            ->with('success', 'Sertifikat berhasil dihapus!');
    }

    /**
     * Search kegiatan for autocomplete
     */
    public function searchKegiatan(Request $request)
    {
        $search = $request->get('q');
        
        $kegiatans = RiwayatKegiatan::where('judul', 'LIKE', "%{$search}%")
            ->orderBy('tanggal_kegiatan', 'desc')
            ->limit(10)
            ->get(['id', 'judul', 'tanggal_kegiatan', 'jenis_kegiatan', 'penyelenggara']);

        return response()->json($kegiatans);
    }

    /**
     * Download sertifikat file
     */
    public function download($id)
    {
        $anggota = Auth::guard('anggota')->user();
        if (!$anggota) {
            return redirect()->route('anggota.login')->with('error', 'Silakan login sebagai anggota.');
        }
    
        // Pastikan sertifikat memang milik anggota yang login
        $sertifikat = SertifikatAnggota::where('id', $id)
            ->where('anggota_id', $anggota->id)
            ->firstOrFail();
    
        if (!$sertifikat->file_sertifikat) {
            return back()->with('error', 'Sertifikat ini tidak memiliki file.');
        }
    
        // Hindari path traversal
        $filename = basename($sertifikat->file_sertifikat);
        $relativePath = 'sertifikats/' . $filename;
    
        // Cek file via Storage disk 'public'
        if (!\Storage::disk('public')->exists($relativePath)) {
            return back()->with('error', 'File sertifikat tidak ditemukan. File mungkin telah dihapus atau belum diupload.');
        }
    
        // Unduh file via Storage (Laravel akan set header Content-Type otomatis jika perlu)
        // Jika ingin memaksa content type, bisa atur manual seperti di bawah.
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
        ];
        $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';
    
        return \Storage::disk('public')->download($relativePath, $filename, [
            'Content-Type' => $contentType,
        ]);
    }
}
