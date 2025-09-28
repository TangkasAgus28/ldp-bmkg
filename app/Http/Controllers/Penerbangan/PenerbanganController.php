<?php

namespace App\Http\Controllers\Penerbangan;

use App\Http\Controllers\Controller;
use App\Models\DokumenHarian;
use App\Models\RiwayatUnduhan;
use App\Models\LaporanBulanan;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use PDF;

class PenerbanganController extends Controller
{
    public function dashboard()
    {
        $totalDokumen = DokumenHarian::count();
        $totalUnduhan = RiwayatUnduhan::where('user_id', Auth::id())->count();
        
        return view('penerbangan.dashboard', compact('totalDokumen', 'totalUnduhan'));
    }

    // DOKUMEN HARIAN
    public function dokumenHarian()
    {
        $dokumen = DokumenHarian::with('forecaster')
                                ->orderBy('tanggal_upload', 'desc')
                                ->paginate(10);
        return view('penerbangan.dokumen.index', compact('dokumen'));
    }

    public function downloadDokumen($id)
    {
        $dokumen = DokumenHarian::findOrFail($id);
        $user = Auth::user();

        // Cek user sudah/belum download dokumen ini
        $sudahDownload = RiwayatUnduhan::where([
            'dokumen_id' => $dokumen->id,
            'user_id' => $user->id
        ])->exists();

        if (!$sudahDownload) {
            // Catat riwayat unduhan
            RiwayatUnduhan::create([
                'dokumen_id' => $dokumen->id,
                'user_id' => $user->id,
                'maskapai_id' => $user->maskapai_id,
                'tanggal_unduh' => now(),
            ]);
        }

        $filePath = storage_path('app/public/' . $dokumen->file_path);
        
        if (!file_exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath, $dokumen->judul . '.' . pathinfo($filePath, PATHINFO_EXTENSION));
    }

    // RIWAYAT UNDUHAN
    public function riwayatUnduhan()
    {
        $riwayat = RiwayatUnduhan::with(['dokumen', 'maskapai'])
                                ->where('user_id', Auth::id())
                                ->orderBy('tanggal_unduh', 'desc')
                                ->paginate(15);
        
        return view('penerbangan.riwayat', compact('riwayat'));
    }

    // LAPORAN BULANAN
    public function laporanBulanan(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        
        // Buat laporan otomatis jika belum ada
        $this->generateLaporanBulanan($tahun);

        $laporan = LaporanBulanan::where('user_id', Auth::id())
                                 ->where('jenis_laporan', 'unduhan')
                                 ->where('tahun', $tahun)
                                 ->orderBy('bulan')
                                 ->get();

        // Jika request download
        if ($request->has('export')) {
            if ($request->get('export') === 'pdf') {
                return $this->downloadLaporanPDF($laporan, $tahun);
            } elseif ($request->get('export') === 'excel') {
                return $this->downloadLaporanExcel($laporan, $tahun);
            }
        }

        return view('penerbangan.laporan', compact('laporan', 'tahun'));
    }

    // Download Laporan PDF
    private function downloadLaporanPDF($laporan, $tahun)
    {
        $user = Auth::user();
        $maskapai = $user->maskapai;
        $totalUnduhan = $laporan->sum('total');
        $bulanAktif = $laporan->where('total', '>', 0)->count();
        
        $data = [
            'laporan' => $laporan,
            'tahun' => $tahun,
            'user' => $user,
            'maskapai' => $maskapai,
            'totalUnduhan' => $totalUnduhan,
            'bulanAktif' => $bulanAktif,
            'tanggalGenerate' => now()->format('d F Y H:i')
        ];

        // Filename
        $filename = 'Laporan_Unduhan_' . ($maskapai->kode ?? 'Unknown') . '_' . $tahun . '.html';
        
        // Return HTML sebagai PDF dari browser
        return response()
            ->view('penerbangan.laporan-pdf', $data)
            ->header('Content-Type', 'text/html; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    // Download Laporan pdf
    private function downloadLaporanExcel($laporan, $tahun)
    {
        $user = Auth::user();
        $maskapai = $user->maskapai;
        
        $csvData = "LAPORAN BULANAN UNDUHAN DOKUMEN\n";
        $csvData .= "Maskapai: " . ($maskapai->nama ?? 'Unknown') . " (" . ($maskapai->kode ?? 'N/A') . ")\n";
        $csvData .= "Tahun: " . $tahun . "\n";
        $csvData .= "Diunduh pada: " . now()->format('d F Y H:i') . "\n\n";
        
        $csvData .= "Bulan,Tahun,Total Unduhan,Status\n";
        
        foreach ($laporan as $item) {
            $bulan = \DateTime::createFromFormat('!m', $item->bulan)->format('F');
            $status = $item->total > 0 ? 'Aktif' : 'Tidak Ada';
            $csvData .= $bulan . "," . $item->tahun . "," . $item->total . "," . $status . "\n";
        }
        
        $csvData .= "\nRINGKASAN:\n";
        $csvData .= "Total Unduhan," . $laporan->sum('total') . "\n";
        $csvData .= "Bulan Aktif," . $laporan->where('total', '>', 0)->count() . "\n";
        
        $filename = 'Laporan_Unduhan_' . ($maskapai->kode ?? 'Unknown') . '_' . $tahun . '.csv';
        
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    // INFO KONTAK
    public function infoKontak()
    {
        $kontak = Kontak::first();
        return view('penerbangan.kontak', compact('kontak'));
    }

    // Helper function untuk generate laporan bulanan (PERBAIKAN)
    private function generateLaporanBulanan($tahun)
    {
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            // Hitung total unduhan untuk bulan ini
            $totalUnduhan = RiwayatUnduhan::where('user_id', Auth::id())
                                         ->whereYear('tanggal_unduh', $tahun)
                                         ->whereMonth('tanggal_unduh', $bulan)
                                         ->count();

            // Cari existing record
            $existing = LaporanBulanan::where([
                'user_id' => Auth::id(),
                'tahun' => $tahun,
                'bulan' => $bulan,
                'jenis_laporan' => 'unduhan'
            ])->first();

            if ($existing) {
                // UPDATE existing record dengan data terbaru
                $existing->update(['total' => $totalUnduhan]);
            } else {
                // CREATE new record
                LaporanBulanan::create([
                    'user_id' => Auth::id(),
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'total' => $totalUnduhan,
                    'jenis_laporan' => 'unduhan'
                ]);
            }
        }
    }
}