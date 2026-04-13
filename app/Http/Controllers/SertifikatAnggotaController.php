<?php

namespace App\Http\Controllers;

use App\Models\SertifikatAnggota;
use App\Models\Anggota;
use App\Models\RiwayatKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SertifikatAnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sertifikats = SertifikatAnggota::with(['anggota', 'riwayatKegiatan'])
            ->orderBy('tanggal_terbit', 'desc')
            ->paginate(10);

        return view('admin.sertifikat.index', compact('sertifikats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anggotas = Anggota::aktif()->orderBy('nama')->get();
        return view('admin.sertifikat.create', compact('anggotas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'riwayat_kegiatan_id' => 'required|exists:riwayat_kegiatans,id',
            'nomor_sertifikat' => 'nullable|string|max:255',
            'tanggal_terbit' => 'required|date',
            'penyelenggara' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('file_sertifikat')) {
            $file = $request->file('file_sertifikat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('sertifikats', $filename, 'public');
            $validated['file_sertifikat'] = $filename;
        }

        SertifikatAnggota::create($validated);

        return redirect()->route('admin.sertifikat.index')
            ->with('success', 'Sertifikat berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SertifikatAnggota $sertifikat)
    {
        $sertifikat->load(['anggota', 'riwayatKegiatan']);
        return view('admin.sertifikat.show', compact('sertifikat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SertifikatAnggota $sertifikat)
    {
        $anggotas = Anggota::aktif()->orderBy('nama')->get();
        $sertifikat->load(['anggota', 'riwayatKegiatan']);
        return view('admin.sertifikat.edit', compact('sertifikat', 'anggotas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SertifikatAnggota $sertifikat)
    {
        $validated = $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'riwayat_kegiatan_id' => 'required|exists:riwayat_kegiatans,id',
            'nomor_sertifikat' => 'nullable|string|max:255',
            'tanggal_terbit' => 'required|date',
            'penyelenggara' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

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

        return redirect()->route('admin.sertifikat.index')
            ->with('success', 'Sertifikat berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SertifikatAnggota $sertifikat)
    {
        // Delete file if exists
        if ($sertifikat->file_sertifikat) {
            Storage::disk('public')->delete('sertifikats/' . $sertifikat->file_sertifikat);
        }

        $sertifikat->delete();

        return redirect()->route('admin.sertifikat.index')
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
     * Get kegiatan details for a specific anggota
     */
    public function getAnggotaSertifikats($anggotaId)
    {
        $sertifikats = SertifikatAnggota::with('riwayatKegiatan')
            ->where('anggota_id', $anggotaId)
            ->orderBy('tanggal_terbit', 'desc')
            ->get();

        return response()->json($sertifikats);
    }

    /**
     * Download sertifikat file
     */
    public function download($id)
    {
        $sertifikat = SertifikatAnggota::findOrFail($id);
        
        if (!$sertifikat->file_sertifikat) {
            return back()->with('error', 'Sertifikat ini tidak memiliki file.');
        }
        
        $filename = basename($sertifikat->file_sertifikat);
        $relativePath = 'sertifikats/' . $filename;
        
        if (!\Storage::disk('public')->exists($relativePath)) {
            return back()->with('error', 'File sertifikat tidak ditemukan. File mungkin telah dihapus atau belum diupload.');
        }
        
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
