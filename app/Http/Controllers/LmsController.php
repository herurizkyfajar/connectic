<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class LmsController extends Controller
{
    public function index()
    {
        $items = Lms::orderBy('updated_at', 'desc')->paginate(10);
        return view('admin.lms.index', compact('items'));
    }

    public function create()
    {
        return view('admin.lms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:lms,slug',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:50',
            'status' => 'required|in:Draft,Published,Archived',
            'cover' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:4096',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Str::slug($validated['title']) . '-' . substr(uniqid(), -6);
        }

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $name = time() . '_' . $file->getClientOriginalName();
            Storage::disk('public')->putFileAs('lms', $file, $name);
            $validated['cover'] = $name;
        }

        Lms::create($validated);
        return redirect()->route('admin.lms.index')->with('success', 'LMS berhasil ditambahkan');
    }

    public function show(Lms $lm)
    {
        $readers = DB::table('lms_reads')
            ->join('anggotas', 'lms_reads.anggota_id', '=', 'anggotas.id')
            ->where('lms_reads.lms_id', $lm->id)
            ->orderBy('lms_reads.read_at', 'desc')
            ->select(['anggotas.id','anggotas.nama','anggotas.jabatan','anggotas.email','anggotas.foto','lms_reads.read_at'])
            ->get();
        return view('admin.lms.show', ['item' => $lm, 'readers' => $readers]);
    }

    public function edit(Lms $lm)
    {
        return view('admin.lms.edit', ['item' => $lm]);
    }

    public function update(Request $request, Lms $lm)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:lms,slug,' . $lm->id,
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:50',
            'status' => 'required|in:Draft,Published,Archived',
            'cover' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:4096',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Str::slug($validated['title']) . '-' . substr(uniqid(), -6);
        }

        if ($request->hasFile('cover')) {
            if ($lm->cover) {
                Storage::disk('public')->delete('lms/' . $lm->cover);
            }
            $file = $request->file('cover');
            $name = time() . '_' . $file->getClientOriginalName();
            Storage::disk('public')->putFileAs('lms', $file, $name);
            $validated['cover'] = $name;
        }

        $lm->update($validated);
        return redirect()->route('admin.lms.index')->with('success', 'LMS berhasil diperbarui');
    }

    public function destroy(Lms $lm)
    {
        if ($lm->cover) {
            Storage::disk('public')->delete('lms/' . $lm->cover);
        }
        $lm->delete();
        return redirect()->route('admin.lms.index')->with('success', 'LMS berhasil dihapus');
    }
}
