<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MeetingNote;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = MeetingNote::orderBy('meeting_date', 'desc')
                            ->orderBy('created_at', 'desc');
        
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admin_wilayah') {
            $query->where('parent_id', Auth::guard('admin')->id());
        }
        
        $meetings = $query->paginate(10);
        
        return view('admin.meeting-notes.index', compact('meetings'));
    }

    /**
     * Get anggota list for autocomplete
     */
    public function getAnggota(Request $request)
    {
        $search = $request->get('q');
        
        $anggotas = Anggota::aktif()
                           ->when($search, function ($query, $search) {
                               return $query->where('nama', 'LIKE', "%{$search}%");
                           })
                           ->select('id', 'nama', 'jabatan')
                           ->orderBy('nama')
                           ->limit(20)
                           ->get();
        
        $results = $anggotas->map(function ($anggota) {
            return [
                'id' => $anggota->nama, // Gunakan nama sebagai value
                'text' => $anggota->nama . ' (' . $anggota->jabatan . ')'
            ];
        });
        
        return response()->json(['results' => $results]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextDocNo = MeetingNote::generateDocumentNo();
        $anggotas = Anggota::aktif()->orderBy('nama')->get();
        return view('admin.meeting-notes.create', compact('nextDocNo', 'anggotas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'document_no' => 'required|string|unique:meeting_notes,document_no|max:255',
            'project_name' => 'required|string|max:255',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required|string|max:255',
            'meeting_location' => 'required|string|max:255',
            'type_of_meeting' => 'required|string|max:255',
            'meeting_called_by' => 'required|string|max:255',
            'attendance' => 'required|array|min:1',
            'attendance.*' => 'required|string',
            'note_taker' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'meeting_result' => 'nullable|string',
            'on_progress' => 'nullable|string',
            'akan_dilakukan' => 'nullable|string',
        ]);

        // Convert attendance array to comma-separated string
        $validated['attendance'] = implode(', ', $request->attendance);
        $validated['parent_id'] = Auth::guard('admin')->id();

        MeetingNote::create($validated);

        return redirect()->route('admin.meeting-notes.index')
                        ->with('success', 'Meeting note berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MeetingNote $meetingNote)
    {
        return view('admin.meeting-notes.show', compact('meetingNote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MeetingNote $meetingNote)
    {
        $anggotas = Anggota::aktif()->orderBy('nama')->get();
        return view('admin.meeting-notes.edit', compact('meetingNote', 'anggotas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MeetingNote $meetingNote)
    {
        $validated = $request->validate([
            'document_no' => 'required|string|max:255|unique:meeting_notes,document_no,' . $meetingNote->id,
            'project_name' => 'required|string|max:255',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required|string|max:255',
            'meeting_location' => 'required|string|max:255',
            'type_of_meeting' => 'required|string|max:255',
            'meeting_called_by' => 'required|string|max:255',
            'attendance' => 'required|array|min:1',
            'attendance.*' => 'required|string',
            'note_taker' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'meeting_result' => 'nullable|string',
            'on_progress' => 'nullable|string',
            'akan_dilakukan' => 'nullable|string',
        ]);

        // Convert attendance array to comma-separated string
        $validated['attendance'] = implode(', ', $request->attendance);

        $meetingNote->update($validated);

        return redirect()->route('admin.meeting-notes.index')
                        ->with('success', 'Meeting note berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MeetingNote $meetingNote)
    {
        $meetingNote->delete();

        return redirect()->route('admin.meeting-notes.index')
                        ->with('success', 'Meeting note berhasil dihapus!');
    }

    /**
     * Display meeting notes for anggota (read-only)
     */
    public function indexAnggota()
    {
        $meetings = MeetingNote::orderBy('meeting_date', 'desc')
                               ->orderBy('created_at', 'desc')
                               ->paginate(10);
        
        return view('anggota.meeting-notes.index', compact('meetings'));
    }

    /**
     * Display meeting note detail for anggota (read-only)
     */
    public function showAnggota(MeetingNote $meetingNote)
    {
        return view('anggota.meeting-notes.show', compact('meetingNote'));
    }

    /**
     * Display ranking anggota berdasarkan meeting attendance
     */
    public function ranking()
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
        
        // Get anggota details with pagination
        $rankingData = [];
        foreach ($attendanceCount as $name => $count) {
            $anggota = Anggota::where('nama', $name)->first();
            
            $rankingData[] = [
                'nama' => $name,
                'count' => $count,
                'anggota' => $anggota,
                'foto' => $anggota ? $anggota->foto : null,
                'jabatan' => $anggota ? $anggota->jabatan : '-',
                'email' => $anggota ? $anggota->email : '-',
                'id' => $anggota ? $anggota->id : null,
            ];
        }

        // Convert to collection for pagination
        $perPage = 20;
        $currentPage = request()->get('page', 1);
        $collection = collect($rankingData);
        
        $ranking = new \Illuminate\Pagination\LengthAwarePaginator(
            $collection->forPage($currentPage, $perPage),
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        // Use custom pagination view
        $ranking->onEachSide(1);

        // Statistik
        $totalAnggota = count($attendanceCount);
        $totalMeetings = $meetings->count();
        $totalAttendance = array_sum($attendanceCount);

        return view('admin.meeting-notes.ranking', compact('ranking', 'totalAnggota', 'totalMeetings', 'totalAttendance'));
    }
}
