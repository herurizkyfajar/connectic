<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\PageContent;
use Illuminate\Http\Request;

class TentangController extends Controller
{
    /**
     * Display penjelasan RTIK page.
     */
    public function penjelasan()
    {
        $pageContent = PageContent::getByKey('tentang_penjelasan');
        $data = $pageContent ? $pageContent->content : [];

        // Normalize legacy data structure
        $data = $this->normalizeContent($data);
        
        // Pass data directly to view to ensure normalization is used
        // We create a temporary object to mimic PageContent structure if needed, 
        // or just pass 'data' to the view and update view to use it.
        // But the view uses $pageContent->content. 
        // So we should update the view to use $data variable if we pass it, 
        // OR we temporarily modify the $pageContent object.
        
        if ($pageContent) {
            $pageContent->content = $data;
        }

        return view('admin.tentang.penjelasan', compact('pageContent'));
    }

    /**
     * Display struktur organisasi page.
     */
    public function struktur()
    {
        $struktur = $this->getFormattedStruktur();
        return view('admin.tentang.struktur', compact('struktur'));
    }

    /**
     * Show the form for editing the structure.
     */
    public function editStruktur()
    {
        $struktur = $this->getFormattedStruktur();
        $members = Anggota::where('status', 'Aktif')->orderBy('nama')->get();
        
        $positions = [
            'Ketua umum' => 'Ketua Umum',
            'Wakil ketua' => 'Wakil Ketua',
            'Sekretaris' => 'Sekretaris',
            'Bendahara' => 'Bendahara',
            'Bidang kesekretariatan' => 'Bidang Kesekretariatan',
            'Bidang kemitraan dan legal' => 'Bidang Kemitraan & Legal',
            'Bidang program dan aptika' => 'Bidang Program & Aptika',
            'Bidang penelitian dan pengembangan sumber daya manusia' => 'Bidang Penelitian & Pengembangan SDM',
            'Bidang komunikasi publik' => 'Bidang Komunikasi Publik'
        ];

        return view('admin.tentang.edit-struktur', compact('struktur', 'members', 'positions'));
    }

    /**
     * Update the structure (assign member to position).
     */
    public function updateStruktur(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:anggotas,id',
            'jabatan' => 'required|string'
        ]);

        $member = Anggota::findOrFail($request->member_id);
        
        // If position is singular (Ketua, Wakil, Sekretaris, Bendahara), 
        // remove existing holder of that position
        $singularPositions = ['Ketua umum', 'Wakil ketua', 'Sekretaris', 'Bendahara'];
        if (in_array($request->jabatan, $singularPositions)) {
            Anggota::where('jabatan', $request->jabatan)->update(['jabatan' => null]);
        }

        $member->jabatan = $request->jabatan;
        $member->save();

        return redirect()->back()->with('success', 'Struktur organisasi berhasil diperbarui.');
    }

    /**
     * Remove member from structure.
     */
    public function removeStruktur(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:anggotas,id'
        ]);

        $member = Anggota::findOrFail($request->member_id);
        $member->jabatan = null;
        $member->save();

        return redirect()->back()->with('success', 'Anggota berhasil dihapus dari struktur.');
    }

    /**
     * Helper to get formatted structure data
     */
    private function getFormattedStruktur()
    {
        $pengurus = Anggota::where('status', 'Aktif')
            ->whereNotNull('jabatan')
            ->get();

        $struktur = [];
        
        foreach ($pengurus as $p) {
            $jabatan = strtolower($p->jabatan);
            
            // Map jabatan to key
            if ($jabatan == 'ketua umum') $struktur['ketua_umum'] = $p;
            elseif ($jabatan == 'wakil ketua') $struktur['wakil_ketua'] = $p;
            elseif ($jabatan == 'sekretaris') $struktur['sekretaris'] = $p;
            elseif ($jabatan == 'bendahara') $struktur['bendahara'] = $p;
            elseif (str_contains($jabatan, 'kesekretariatan')) $struktur['kesekretariatan'][] = $p;
            elseif (str_contains($jabatan, 'kemitraan')) $struktur['kemitraan_legal'][] = $p;
            elseif (str_contains($jabatan, 'program')) $struktur['program_aptika'][] = $p;
            elseif (str_contains($jabatan, 'penelitian')) $struktur['penelitian_sdm'][] = $p;
            elseif (str_contains($jabatan, 'komunikasi')) $struktur['komunikasi_publik'][] = $p;
        }

        return $struktur;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $pageContent = PageContent::getByKey('tentang_penjelasan');
        $data = $pageContent ? $pageContent->content : [];
        
        // Normalize legacy data structure
        $data = $this->normalizeContent($data);

        return view('admin.tentang.edit', compact('data'));
    }

    /**
     * Helper to normalize content data structure
     */
    private function normalizeContent($data)
    {
        // Handle Visi
        if (isset($data['visi']) && is_array($data['visi'])) {
            $data['visi'] = $data['visi']['content'] ?? '';
        }

        // Handle Misi
        if (isset($data['misi']) && is_array($data['misi']) && isset($data['misi']['items'])) {
            $data['misi'] = $data['misi']['items'];
        }

        // Handle Pengertian mapping to Intro
        if (isset($data['pengertian']) && is_array($data['pengertian'])) {
             if (!isset($data['intro_title'])) $data['intro_title'] = $data['pengertian']['title'] ?? '';
             if (!isset($data['intro_subtitle'])) $data['intro_subtitle'] = $data['pengertian']['subtitle'] ?? '';
             if (!isset($data['intro_desc'])) $data['intro_desc'] = $data['pengertian']['content'] ?? '';
        }
        
        // Handle Tujuan if it's in legacy format (though example didn't show nested structure for purpose, checking just in case)
        // Based on dump, 'program' and 'nilai' existed but 'tujuan' was not in the dump. 
        // If 'tujuan' is missing, it falls back to default in view.

        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->input('content');
        
        // Ensure array inputs are properly indexed
        if (isset($data['bidang_kegiatan'])) {
            $data['bidang_kegiatan'] = array_values($data['bidang_kegiatan']);
        }
        if (isset($data['misi'])) {
            $data['misi'] = array_values($data['misi']);
        }
        if (isset($data['tujuan'])) {
            $data['tujuan'] = array_values($data['tujuan']);
        }
        
        PageContent::updateOrCreateByKey('tentang_penjelasan', [
            'title' => 'Tentang RTIK',
            'content' => $data,
            'is_active' => true
        ]);

        return redirect()->route('admin.tentang.penjelasan')->with('success', 'Konten berhasil diperbarui.');
    }

    /**
     * Display penjelasan RTIK page for anggota.
     */
    public function penjelasanAnggota()
    {
        $pageContent = PageContent::getByKey('tentang_penjelasan');
        $data = $pageContent ? $pageContent->content : [];

        // Normalize legacy data structure
        $data = $this->normalizeContent($data);
        
        if ($pageContent) {
            $pageContent->content = $data;
        }

        return view('anggota.tentang.penjelasan', compact('pageContent'));
    }

    /**
     * Display struktur organisasi page for anggota.
     */
    public function strukturAnggota()
    {
        // Get all active members with their positions
        $pengurus = Anggota::where('status', 'Aktif')
            ->whereNotNull('jabatan')
            ->orderByRaw("FIELD(jabatan, 
                'Ketua umum', 
                'Wakil ketua', 
                'Sekretaris', 
                'Bendahara', 
                'Bidang kesekretariatan', 
                'Bidang kemitraan dan legal', 
                'Bidang program dan aptika', 
                'Bidang penelitian dan pengembangan sumber daya manusia', 
                'Bidang komunikasi publik'
            )")
            ->get();
        
        return view('anggota.tentang.struktur', compact('pengurus'));
    }
}
