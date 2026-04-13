<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminNasionalController extends Controller
{
    public function dashboard()
    {
        // Replicating logic for independence
        $topMeetingAttendance = $this->getTopMeetingAttendance();
        $analisisKeaktifan = $this->getAnalisisKeaktifan();
        
        return view('admin.nasional.dashboard', compact('topMeetingAttendance', 'analisisKeaktifan'));
    }

    public function account()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.nasional.account', compact('user'));
    }

    public function updateAccount(Request $request)
    {
        $user = Auth::guard('admin')->user();
        
        $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('admins')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admins')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->username = $request->username;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.nasional.account')->with('success', 'Akun berhasil diperbarui.');
    }

    // Helper methods (copied from AdminAuthController)
    private function getTopMeetingAttendance()
    {
        $meetings = \App\Models\MeetingNote::whereNotNull('attendance')
                               ->where('attendance', '!=', '')
                               ->get();
        
        $attendanceCount = [];
        
        foreach ($meetings as $meeting) {
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
        
        arsort($attendanceCount);
        
        return array_slice($attendanceCount, 0, 5, true);
    }

    private function getAnalisisKeaktifan()
    {
        $totalAnggota = \App\Models\Anggota::count();
        $activeAnggota = \App\Models\Anggota::where('status', 'Aktif')->count();
        $inactiveAnggota = $totalAnggota - $activeAnggota;
        
        return [
            'total' => $totalAnggota,
            'active' => $activeAnggota,
            'inactive' => $inactiveAnggota,
            'active_percentage' => $totalAnggota > 0 ? round(($activeAnggota / $totalAnggota) * 100) : 0
        ];
    }
}
