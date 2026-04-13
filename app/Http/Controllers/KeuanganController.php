<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class KeuanganController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Keuangan::query();

        // Buat query terpisah untuk total yang mengikuti semua filter
        $totalQuery = Keuangan::query();

        // Filter by parent_id for admin_wilayah
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admin_wilayah') {
            $adminId = Auth::guard('admin')->id();
            $query->where('parent_id', $adminId);
            $totalQuery->where('parent_id', $adminId);
        }

        // Search functionality - gunakan filled() untuk memastikan nilai ada dan tidak kosong
        if ($request->filled('search')) {
            $search = trim($request->search);
            
            $query->where(function($q) use ($search) {
                $q->where('keterangan', 'LIKE', "%{$search}%")
                  ->orWhere('kategori', 'LIKE', "%{$search}%")
                  ->orWhere('sumber', 'LIKE', "%{$search}%")
                  ->orWhere('penerima', 'LIKE', "%{$search}%");
            });
            
            // Apply to total query
            $totalQuery->where(function($q) use ($search) {
                $q->where('keterangan', 'LIKE', "%{$search}%")
                  ->orWhere('kategori', 'LIKE', "%{$search}%")
                  ->orWhere('sumber', 'LIKE', "%{$search}%")
                  ->orWhere('penerima', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
            $totalQuery->where('jenis', $request->jenis);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
            $totalQuery->where('kategori', $request->kategori);
        }

        // Filter berdasarkan rentang waktu
        if ($request->filled('rentang')) {
            if ($request->rentang === 'custom' && $request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
                $totalQuery->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            } elseif ($request->rentang !== 'custom') {
                $query->rentangWaktu($request->rentang);
                $totalQuery->rentangWaktu($request->rentang);
            }
        }

        // Filter berdasarkan tanggal manual (jika tidak ada rentang)
        if (!$request->filled('rentang') && $request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            $totalQuery->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        $keuangans = $query->orderBy('tanggal', 'desc')->paginate(15)->appends($request->query());

        // Hitung total berdasarkan filter yang diterapkan
        $totalMasuk = (clone $totalQuery)->where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = (clone $totalQuery)->where('jenis', 'keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        // Kategori options
        $kategoriOptions = [
            'Iuran Anggota',
            'Donasi',
            'Sponsor',
            'Penjualan',
            'Operasional',
            'Kegiatan',
            'Peralatan',
            'Transportasi',
            'Konsumsi',
            'Lainnya'
        ];

        return view('admin.keuangan.index', compact(
            'keuangans',
            'totalMasuk',
            'totalKeluar',
            'saldo',
            'kategoriOptions'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriOptions = [
            'Iuran Anggota',
            'Donasi',
            'Sponsor',
            'Penjualan',
            'Operasional',
            'Kegiatan',
            'Peralatan',
            'Transportasi',
            'Konsumsi',
            'Lainnya'
        ];

        return view('admin.keuangan.create', compact('kategoriOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Normalize currency input like "1.400.000" or "1.400.000,50" to numeric
        if ($request->has('jumlah')) {
            $request->merge(['jumlah' => $this->normalizeCurrency($request->input('jumlah'))]);
        }

        $request->validate([
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
            'sumber' => 'nullable|string|max:255',
            'penerima' => 'nullable|string|max:255',
            'bukti' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ]);

        $data = $request->all();

        // Set parent_id if admin_wilayah
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admin_wilayah') {
            $data['parent_id'] = Auth::guard('admin')->id();
        }

        // Handle file upload
        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $data['bukti'] = Storage::disk('public')->putFileAs('keuangan', $file, $fileName);
        }

        Keuangan::create($data);

        return redirect()->route('admin.keuangan.index')
            ->with('success', 'Data keuangan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        
        // Check access
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admin_wilayah') {
            if ($keuangan->parent_id != Auth::guard('admin')->id()) {
                abort(403);
            }
        }

        return view('admin.keuangan.show', compact('keuangan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $keuangan = Keuangan::findOrFail($id);

        // Check access
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admin_wilayah') {
            if ($keuangan->parent_id != Auth::guard('admin')->id()) {
                abort(403);
            }
        }

        $kategoriOptions = [
            'Iuran Anggota',
            'Donasi',
            'Sponsor',
            'Penjualan',
            'Operasional',
            'Kegiatan',
            'Peralatan',
            'Transportasi',
            'Konsumsi',
            'Lainnya'
        ];

        return view('admin.keuangan.edit', compact('keuangan', 'kategoriOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $keuangan = Keuangan::findOrFail($id);

        // Check access
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admin_wilayah') {
            if ($keuangan->parent_id != Auth::guard('admin')->id()) {
                abort(403);
            }
        }

        // Normalize currency input before validation
        if ($request->has('jumlah')) {
            $request->merge(['jumlah' => $this->normalizeCurrency($request->input('jumlah'))]);
        }

        $request->validate([
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
            'sumber' => 'nullable|string|max:255',
            'penerima' => 'nullable|string|max:255',
            'bukti' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ]);

        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('bukti')) {
            // Delete old file
            if ($keuangan->bukti) {
                Storage::disk('public')->delete($keuangan->bukti);
            }

            $file = $request->file('bukti');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $data['bukti'] = Storage::disk('public')->putFileAs('keuangan', $file, $fileName);
        }

        $keuangan->update($data);

        return redirect()->route('admin.keuangan.index')
            ->with('success', 'Data keuangan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);

        // Check access
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admin_wilayah') {
            if ($keuangan->parent_id != Auth::guard('admin')->id()) {
                abort(403);
            }
        }

        // Delete file if exists
        if ($keuangan->bukti) {
            Storage::disk('public')->delete($keuangan->bukti);
        }

        $keuangan->delete();

        return redirect()->route('admin.keuangan.index')
            ->with('success', 'Data keuangan berhasil dihapus!');
    }

    /**
     * Get financial report data for charts
     */
    public function report(Request $request)
    {
        $rentang = $request->get('rentang', 'bulan');
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->endOfMonth()->toDateString());

        // Data untuk grafik pendapatan dan pengeluaran
        $chartData = $this->getChartData($rentang, $startDate, $endDate);

        // Data untuk grafik berdasarkan kategori
        $kategoriData = $this->getKategoriData($rentang, $startDate, $endDate);

        // Summary data
        $summary = $this->getSummaryData($startDate, $endDate);

        return view('admin.keuangan.report', compact(
            'chartData',
            'kategoriData',
            'summary',
            'rentang',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Get data untuk grafik pendapatan dan pengeluaran
     */
    private function getChartData($rentang, $startDate, $endDate)
    {
        $data = [];
        $labels = [];

        if ($rentang === 'custom') {
            // Custom range - group by month
            $months = $this->applyAccessFilter(Keuangan::whereBetween('tanggal', [$startDate, $endDate]))
                ->selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as month, jenis, SUM(jumlah) as total')
                ->groupBy('month', 'jenis')
                ->orderBy('month')
                ->get();

            $groupedData = [];
            foreach ($months as $month) {
                $key = $month->month;
                if (!isset($groupedData[$key])) {
                    $groupedData[$key] = ['masuk' => 0, 'keluar' => 0];
                }
                $groupedData[$key][$month->jenis] = (float) $month->total;
            }

            foreach ($groupedData as $month => $totals) {
                $labels[] = Carbon::createFromFormat('Y-m', $month)->format('M Y');
                $data[] = [
                    'masuk' => $totals['masuk'],
                    'keluar' => $totals['keluar']
                ];
            }
        } else {
            // Predefined ranges
            $periods = $this->getPeriods($rentang, $startDate, $endDate);

            foreach ($periods as $period) {
                $labels[] = $period['label'];

                $masuk = $this->applyAccessFilter(Keuangan::masuk()->whereBetween('tanggal', [$period['start'], $period['end']]))->sum('jumlah');
                $keluar = $this->applyAccessFilter(Keuangan::keluar()->whereBetween('tanggal', [$period['start'], $period['end']]))->sum('jumlah');

                $data[] = [
                    'masuk' => (float) $masuk,
                    'keluar' => (float) $keluar
                ];
            }
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Pemasukan',
                    'data' => array_column($data, 'masuk'),
                    'backgroundColor' => 'rgba(40, 167, 69, 0.8)',
                    'borderColor' => 'rgba(40, 167, 69, 1)',
                    'borderWidth' => 2
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => array_column($data, 'keluar'),
                    'backgroundColor' => 'rgba(220, 53, 69, 0.8)',
                    'borderColor' => 'rgba(220, 53, 69, 1)',
                    'borderWidth' => 2
                ]
            ]
        ];
    }

    /**
     * Get data untuk grafik berdasarkan kategori
     */
    private function getKategoriData($rentang, $startDate, $endDate)
    {
        $masuk = $this->applyAccessFilter(Keuangan::masuk()->whereBetween('tanggal', [$startDate, $endDate]))
            ->selectRaw('kategori, SUM(jumlah) as total')
            ->groupBy('kategori')
            ->orderBy('total', 'desc')
            ->get();

        $keluar = $this->applyAccessFilter(Keuangan::keluar()->whereBetween('tanggal', [$startDate, $endDate]))
            ->selectRaw('kategori, SUM(jumlah) as total')
            ->groupBy('kategori')
            ->orderBy('total', 'desc')
            ->get();

        return [
            'masuk' => [
                'labels' => $masuk->pluck('kategori')->toArray(),
                'data' => $masuk->pluck('total')->map(fn($val) => (float) $val)->toArray(),
                'colors' => $this->generateColors($masuk->count())
            ],
            'keluar' => [
                'labels' => $keluar->pluck('kategori')->toArray(),
                'data' => $keluar->pluck('total')->map(fn($val) => (float) $val)->toArray(),
                'colors' => $this->generateColors($keluar->count())
            ]
        ];
    }

    /**
     * Get summary data
     */
    private function getSummaryData($startDate, $endDate)
    {
        $totalMasuk = $this->applyAccessFilter(Keuangan::masuk()->whereBetween('tanggal', [$startDate, $endDate]))->sum('jumlah');
        $totalKeluar = $this->applyAccessFilter(Keuangan::keluar()->whereBetween('tanggal', [$startDate, $endDate]))->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        return [
            'totalMasuk' => (float) $totalMasuk,
            'totalKeluar' => (float) $totalKeluar,
            'saldo' => (float) $saldo,
            'formattedMasuk' => 'Rp ' . number_format($totalMasuk, 0, ',', '.'),
            'formattedKeluar' => 'Rp ' . number_format($totalKeluar, 0, ',', '.'),
            'formattedSaldo' => 'Rp ' . number_format($saldo, 0, ',', '.'),
        ];
    }

    /**
     * Generate periods berdasarkan rentang waktu
     */
    private function getPeriods($rentang, $startDate, $endDate)
    {
        $periods = [];
        $now = now();

        switch ($rentang) {
            case 'hari':
                for ($i = 6; $i >= 0; $i--) {
                    $date = $now->copy()->subDays($i);
                    $periods[] = [
                        'label' => $date->format('d M'),
                        'start' => $date->toDateString(),
                        'end' => $date->toDateString()
                    ];
                }
                break;
            case 'minggu':
                for ($i = 11; $i >= 0; $i--) {
                    $startOfWeek = $now->copy()->subWeeks($i)->startOfWeek();
                    $endOfWeek = $now->copy()->subWeeks($i)->endOfWeek();
                    $periods[] = [
                        'label' => 'W' . $startOfWeek->weekOfYear . ' ' . $startOfWeek->format('M'),
                        'start' => $startOfWeek->toDateString(),
                        'end' => $endOfWeek->toDateString()
                    ];
                }
                break;
            case 'bulan':
                for ($i = 11; $i >= 0; $i--) {
                    $date = $now->copy()->subMonths($i);
                    $periods[] = [
                        'label' => $date->format('M Y'),
                        'start' => $date->startOfMonth()->toDateString(),
                        'end' => $date->endOfMonth()->toDateString()
                    ];
                }
                break;
            case 'tahun':
                for ($i = 4; $i >= 0; $i--) {
                    $year = $now->copy()->subYears($i);
                    $periods[] = [
                        'label' => $year->format('Y'),
                        'start' => $year->startOfYear()->toDateString(),
                        'end' => $year->endOfYear()->toDateString()
                    ];
                }
                break;
        }

        return $periods;
    }

    /**
     * Generate random colors untuk chart
     */
    private function generateColors($count)
    {
        $colors = [];
        $baseColors = [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 205, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)',
            'rgba(199, 199, 199, 0.8)',
            'rgba(83, 102, 255, 0.8)',
            'rgba(255, 99, 255, 0.8)',
            'rgba(99, 255, 132, 0.8)'
        ];

        for ($i = 0; $i < $count; $i++) {
            $colors[] = $baseColors[$i % count($baseColors)];
        }

        return $colors;
    }

    /**
     * Normalize localized currency string to plain numeric.
     * Examples: "1.400.000" -> 1400000, "1.400.000,50" -> 1400000.50
     */
    private function normalizeCurrency($value)
    {
        if (is_null($value)) {
            return $value;
        }

        if (is_string($value)) {
            // Keep only digits, comma, and dot
            $sanitized = preg_replace('/[^\d,\.]/', '', $value);
            // Remove thousand separators, treat comma as decimal
            $sanitized = str_replace('.', '', $sanitized);
            $sanitized = str_replace(',', '.', $sanitized);
            return $sanitized;
        }

        return $value;
    }

    /**
     * Apply access filter for admin_wilayah
     */
    private function applyAccessFilter($query)
    {
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admin_wilayah') {
            $query->where('parent_id', Auth::guard('admin')->id());
        }
        return $query;
    }
}

