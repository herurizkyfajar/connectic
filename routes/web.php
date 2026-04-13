<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Models\Anggota;
use App\Models\Wilayah;
use App\Models\RiwayatKegiatan;

// Landing page / beranda publik
Route::get('/', function () {
    $anggotaCount = Anggota::aktif()->count();
    $provinsiCount = Wilayah::where('tipe', 'provinsi')->count();
    $cabangCount = Wilayah::where('tipe', 'cabang')->count();
    $komisariatCount = Wilayah::where('tipe', 'komisariat')->count();
    $kegiatanCount = RiwayatKegiatan::terlaksana()->count();
    $latestKegiatans = RiwayatKegiatan::terlaksana()
        ->orderBy('tanggal_kegiatan', 'desc')
        ->limit(3)
        ->get();

    return view('admin.landing', compact(
        'anggotaCount',
        'provinsiCount',
        'cabangCount',
        'komisariatCount',
        'kegiatanCount',
        'latestKegiatans'
    ));
})->name('landing');

Route::get('/kegiatan', [\App\Http\Controllers\RiwayatKegiatanController::class, 'publicIndex'])->name('public.kegiatan.index');

// Admin login page
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    
    Route::middleware(['admin', 'pembina'])->group(function () {
        Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');

        // Admin Nasional Routes
        Route::get('/nasional/dashboard', [\App\Http\Controllers\AdminNasionalController::class, 'dashboard'])->name('admin.nasional.dashboard');
        Route::get('/nasional/account', [\App\Http\Controllers\AdminNasionalController::class, 'account'])->name('admin.nasional.account');
        Route::put('/nasional/account', [\App\Http\Controllers\AdminNasionalController::class, 'updateAccount'])->name('admin.nasional.account.update');
        
        // Analisis Keaktifan Route
        Route::get('/analisis-keaktifan', [AdminAuthController::class, 'analisisKeaktifan'])->name('admin.analisis-keaktifan');
        Route::get('/analisis-keaktifan/export-pdf', [AdminAuthController::class, 'exportAnalisisPDF'])->name('admin.analisis-keaktifan.export-pdf');
        
        // Anggota Routes
        Route::get('anggota/cards-pdf', [\App\Http\Controllers\AnggotaController::class, 'cardsPdf'])->name('anggota.cards-pdf');
        Route::get('anggota/api', [\App\Http\Controllers\AnggotaController::class, 'apiIndex'])->name('anggota.api');
        Route::resource('anggota', \App\Http\Controllers\AnggotaController::class);
        
        // Riwayat Kegiatan CRUD Routes
        Route::get('riwayat-kegiatan/calendar', [\App\Http\Controllers\RiwayatKegiatanController::class, 'calendar'])->name('riwayat-kegiatan.calendar');
        Route::get('riwayat-kegiatan/events', [\App\Http\Controllers\RiwayatKegiatanController::class, 'events'])->name('riwayat-kegiatan.events');
        Route::resource('riwayat-kegiatan', \App\Http\Controllers\RiwayatKegiatanController::class);
        Route::post('riwayat-kegiatan/{id}/store-absensi', [\App\Http\Controllers\RiwayatKegiatanController::class, 'storeAbsensi'])->name('riwayat-kegiatan.store-absensi');
        Route::get('riwayat-kegiatan/{id}/download', [\App\Http\Controllers\RiwayatKegiatanController::class, 'download'])->name('riwayat-kegiatan.download');
        
        // Admin Absensi Routes
        Route::prefix('absensi')->name('admin.absensi.')->group(function () {
            Route::get('/', [\App\Http\Controllers\AdminAbsensiController::class, 'index'])->name('index');
            Route::get('/ranking', [\App\Http\Controllers\AdminAbsensiController::class, 'ranking'])->name('ranking');
            Route::get('/anggota/{anggotaId}', [\App\Http\Controllers\AdminAbsensiController::class, 'anggota'])->name('anggota');
            Route::get('/kegiatan/{kegiatanId}', [\App\Http\Controllers\AdminAbsensiController::class, 'kegiatan'])->name('kegiatan');
            Route::get('/{id}', [\App\Http\Controllers\AdminAbsensiController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\App\Http\Controllers\AdminAbsensiController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\AdminAbsensiController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\AdminAbsensiController::class, 'destroy'])->name('destroy');
        });
        
        // Anggota Access Management Routes
        Route::prefix('anggota-access')->name('anggota-access.')->group(function () {
            Route::get('/', [\App\Http\Controllers\AdminAnggotaAccessController::class, 'index'])->name('index');
            Route::get('/{id}', [\App\Http\Controllers\AdminAnggotaAccessController::class, 'show'])->name('show');
            Route::post('/toggle-status/{id}', [\App\Http\Controllers\AdminAnggotaAccessController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/reset-password/{id}', [\App\Http\Controllers\AdminAnggotaAccessController::class, 'resetPassword'])->name('reset-password');
            Route::post('/bulk-action', [\App\Http\Controllers\AdminAnggotaAccessController::class, 'bulkAction'])->name('bulk-action');
            Route::put('/update-access/{id}', [\App\Http\Controllers\AdminAnggotaAccessController::class, 'updateAccess'])->name('update-access');
        });
        
        // Tentang RTIK Routes
        Route::prefix('tentang')->name('admin.tentang.')->group(function () {
            Route::get('/penjelasan', [\App\Http\Controllers\TentangController::class, 'penjelasan'])->name('penjelasan');
            Route::get('/edit', [\App\Http\Controllers\TentangController::class, 'edit'])->name('edit');
            Route::put('/update', [\App\Http\Controllers\TentangController::class, 'update'])->name('update');
            Route::get('/struktur', [\App\Http\Controllers\TentangController::class, 'struktur'])->name('struktur');
            Route::get('/struktur/edit', [\App\Http\Controllers\TentangController::class, 'editStruktur'])->name('struktur.edit');
            Route::post('/struktur/update', [\App\Http\Controllers\TentangController::class, 'updateStruktur'])->name('struktur.update');
            Route::delete('/struktur/remove', [\App\Http\Controllers\TentangController::class, 'removeStruktur'])->name('struktur.remove');
        });
        
        // Meeting Notes Routes
        Route::get('/meeting-notes/api/anggota', [\App\Http\Controllers\MeetingNoteController::class, 'getAnggota'])->name('meeting-notes.api.anggota');
        Route::get('/meeting-notes-ranking', [\App\Http\Controllers\MeetingNoteController::class, 'ranking'])->name('admin.meeting-notes.ranking');
        Route::resource('meeting-notes', \App\Http\Controllers\MeetingNoteController::class, ['as' => 'admin']);

        // LMS Routes (Admin CRUD)
        Route::resource('lms', \App\Http\Controllers\LmsController::class, ['as' => 'admin']);
        
        // Sertifikat Anggota Routes
        Route::get('/sertifikat/search-kegiatan', [\App\Http\Controllers\SertifikatAnggotaController::class, 'searchKegiatan'])->name('sertifikat.search-kegiatan');
        Route::get('/sertifikat/download/{id}', [\App\Http\Controllers\SertifikatAnggotaController::class, 'download'])->name('admin.sertifikat.download');
        Route::resource('sertifikat', \App\Http\Controllers\SertifikatAnggotaController::class, ['as' => 'admin']);

        // Keuangan Routes
        Route::get('/keuangan/report', [\App\Http\Controllers\KeuanganController::class, 'report'])->name('admin.keuangan.report');
        Route::resource('keuangan', \App\Http\Controllers\KeuanganController::class, ['as' => 'admin']);

        // Pengajuan Routes
        Route::resource('pengajuan', \App\Http\Controllers\PengajuanController::class);
    });

    // Admin Wilayah Routes (only for role admin_wilayah)
    Route::middleware(['admin', 'wilayah'])->group(function () {
        Route::get('/wilayah/dashboard', [\App\Http\Controllers\AdminWilayahController::class, 'dashboard'])->name('admin.wilayah.dashboard');
        Route::resource('wilayah', \App\Http\Controllers\WilayahController::class, ['as' => 'admin']);
    });

    // General Admin Account Routes (Accessible to all admins)
    Route::middleware(['admin'])->group(function () {
        Route::get('/account', [\App\Http\Controllers\AdminAccountController::class, 'index'])->name('admin.account.index');
        Route::put('/account', [\App\Http\Controllers\AdminAccountController::class, 'update'])->name('admin.account.update');
    });
}); 

// Anggota Routes
Route::prefix('anggota')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AnggotaAuthController::class, 'showLoginForm'])->name('anggota.login');
    Route::post('/login', [\App\Http\Controllers\AnggotaAuthController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\AnggotaAuthController::class, 'logout'])->name('anggota.logout');
    
    // Serve foto anggota (fallback jika symlink tidak tersedia)
    Route::get('/foto/{id}', [\App\Http\Controllers\AnggotaAuthController::class, 'serveFoto'])->name('anggota.foto');
    
        Route::middleware(['anggota'])->group(function () {
            Route::get('/beranda', [\App\Http\Controllers\AnggotaAuthController::class, 'beranda'])->name('anggota.beranda');
            Route::get('/profile', [\App\Http\Controllers\AnggotaAuthController::class, 'profile'])->name('anggota.profile');
            Route::get('/edit-profile', [\App\Http\Controllers\AnggotaAuthController::class, 'editProfile'])->name('anggota.edit-profile');
            Route::put('/update-profile', [\App\Http\Controllers\AnggotaAuthController::class, 'updateProfile'])->name('anggota.update-profile');
            Route::get('/academy', function(){
                $items = \App\Models\Lms::where('status','Published')
                    ->orderBy('updated_at','desc')
                    ->paginate(12);
                $anggotaId = \Illuminate\Support\Facades\Auth::guard('anggota')->id();
                $readIds = [];
                if ($anggotaId) {
                    $readIds = \Illuminate\Support\Facades\DB::table('lms_reads')
                        ->where('anggota_id', $anggotaId)
                        ->pluck('lms_id')
                        ->toArray();
                }
                return view('anggota.academy', compact('items','readIds'));
            })->name('anggota.academy');
            Route::get('/academy/{slug}', function(string $slug){
                $item = \App\Models\Lms::where('slug',$slug)->firstOrFail();
                $anggotaId = \Illuminate\Support\Facades\Auth::guard('anggota')->id();
                $hasRead = false;
                if ($anggotaId) {
                    $hasRead = \Illuminate\Support\Facades\DB::table('lms_reads')
                        ->where('lms_id', $item->id)
                        ->where('anggota_id', $anggotaId)
                        ->exists();
                }
                return view('anggota.academy-show', compact('item','hasRead'));
            })->name('anggota.academy.show');

            Route::post('/academy/{slug}/read', function(string $slug){
                $item = \App\Models\Lms::where('slug',$slug)->firstOrFail();
                $anggotaId = \Illuminate\Support\Facades\Auth::guard('anggota')->id();
                if (!$anggotaId) {
                    return redirect()->route('anggota.academy.show', $slug)->with('error', 'Anda harus login sebagai anggota.');
                }
                $exists = \Illuminate\Support\Facades\DB::table('lms_reads')
                    ->where('lms_id', $item->id)
                    ->where('anggota_id', $anggotaId)
                    ->exists();
                if (!$exists) {
                    \Illuminate\Support\Facades\DB::table('lms_reads')->insert([
                        'lms_id' => $item->id,
                        'anggota_id' => $anggotaId,
                        'read_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                return redirect()->route('anggota.academy.show', $slug)->with('success', 'Ditandai sudah membaca.');
            })->name('anggota.academy.read');
            Route::get('/anggota-list', function(){
                $query = \App\Models\Anggota::where('status', 'Aktif');
                if(request('nama')){
                    $nama = request('nama');
                    $query->where('nama', 'LIKE', "%{$nama}%");
                }
                if(request('jabatan')){
                    $jabatan = request('jabatan');
                    $query->where('jabatan', 'LIKE', "%{$jabatan}%");
                }
                $anggotas = $query->orderBy('nama')->paginate(12)->appends(request()->query());
                $jabatanOptions = \App\Models\Anggota::whereNotNull('jabatan')
                    ->where('status','Aktif')
                    ->select('jabatan')->distinct()->orderBy('jabatan')->pluck('jabatan');
                return view('anggota.anggota-list', compact('anggotas','jabatanOptions'));
            })->name('anggota.anggota-list');

            Route::get('/anggota/{id}', function($id){
                $anggota = \App\Models\Anggota::findOrFail($id);
                $sertifikats = $anggota->sertifikats()
                    ->with('riwayatKegiatan')
                    ->orderBy('tanggal_terbit', 'desc')
                    ->get();
                $riwayatKegiatans = \App\Models\AbsensiKegiatan::where('anggota_id', $anggota->id)
                    ->with('riwayatKegiatan')
                    ->orderBy('waktu_absen', 'desc')
                    ->limit(10)
                    ->get()
                    ->pluck('riwayatKegiatan')
                    ->unique('id');
                return view('anggota.anggota-show', compact('anggota','sertifikats','riwayatKegiatans'));
            })->name('anggota.show');
            
            // Kalender Kegiatan Routes
            Route::get('/kegiatan/calendar', [\App\Http\Controllers\Anggota\KegiatanController::class, 'calendar'])->name('anggota.kegiatan.calendar');
            Route::get('/kegiatan/events', [\App\Http\Controllers\Anggota\KegiatanController::class, 'events'])->name('anggota.kegiatan.events');
            Route::get('/kegiatan/{id}', [\App\Http\Controllers\Anggota\KegiatanController::class, 'show'])->name('anggota.kegiatan.show');

            // Absensi Kegiatan Routes
            Route::resource('absensi-kegiatan', \App\Http\Controllers\AbsensiKegiatanController::class);
            Route::get('/absensi-kegiatan-search', [\App\Http\Controllers\AbsensiKegiatanController::class, 'searchKegiatan'])->name('absensi-kegiatan.search');
            
            // Sertifikat Routes (Anggota CRUD)
            Route::get('/sertifikat/search-kegiatan', [\App\Http\Controllers\Anggota\AnggotaSertifikatController::class, 'searchKegiatan'])->name('anggota.sertifikat.search-kegiatan');
            Route::get('/sertifikat/download/{id}', [\App\Http\Controllers\Anggota\AnggotaSertifikatController::class, 'download'])->name('anggota.sertifikat.download');
            Route::resource('sertifikat', \App\Http\Controllers\Anggota\AnggotaSertifikatController::class, ['as' => 'anggota']);
            
            // Tentang RTIK Routes
            Route::get('/tentang/penjelasan', [\App\Http\Controllers\TentangController::class, 'penjelasanAnggota'])->name('anggota.tentang.penjelasan');
            Route::get('/tentang/struktur', [\App\Http\Controllers\TentangController::class, 'strukturAnggota'])->name('anggota.tentang.struktur');
            
            // Meeting Notes Routes (Read-only)
            Route::get('/meeting-notes', [\App\Http\Controllers\MeetingNoteController::class, 'indexAnggota'])->name('anggota.meeting-notes.index');
            Route::get('/meeting-notes/{meetingNote}', [\App\Http\Controllers\MeetingNoteController::class, 'showAnggota'])->name('anggota.meeting-notes.show');
        });
});

// Profil anggota publik (read-only, tanpa autentikasi)
Route::get('/anggota/profil/{id}', function($id){
    $anggota = \App\Models\Anggota::findOrFail($id);
    return view('anggota.public-profile', compact('anggota'));
})->name('anggota.profil');

// Keep welcome page accessible for reference
Route::get('/welcome', function () {
    return view('welcome');
});

// Dokumentasi DOCX
Route::get('/docs/RTIK-App-Documentation.docx', [\App\Http\Controllers\DocsController::class, 'docx'])->name('docs.app.docx');

// Detail kegiatan publik (tanpa login)
Route::get('/kegiatan/{id}', [\App\Http\Controllers\RiwayatKegiatanController::class, 'publicShow'])->name('public.kegiatan.show');

// Serve featured image dokumentasi kegiatan (public)
Route::get('/riwayat-kegiatan/image/{id}', [\App\Http\Controllers\RiwayatKegiatanController::class, 'serveImage'])->name('riwayat-kegiatan.image');
