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

        // Cek apakah user sudah pernah download dokumen ini
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
    public function laporanBulanan()
    {
        $tahun = request('tahun', date('Y'));
        $laporan = LaporanBulanan::where('user_id', Auth::id())
                                 ->where('jenis_laporan', 'unduhan')
                                 ->where('tahun', $tahun)
                                 ->orderBy('bulan')
                                 ->get();

        // Buat laporan otomatis jika belum ada
        $this->generateLaporanBulanan($tahun);

        $laporan = LaporanBulanan::where('user_id', Auth::id())
                                 ->where('jenis_laporan', 'unduhan')
                                 ->where('tahun', $tahun)
                                 ->orderBy('bulan')
                                 ->get();

        return view('penerbangan.laporan', compact('laporan', 'tahun'));
    }

    // INFO KONTAK
    public function infoKontak()
    {
        $kontak = Kontak::first();
        return view('penerbangan.kontak', compact('kontak'));
    }

    // Helper function untuk generate laporan bulanan
    private function generateLaporanBulanan($tahun)
    {
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $existing = LaporanBulanan::where([
                'user_id' => Auth::id(),
                'tahun' => $tahun,
                'bulan' => $bulan,
                'jenis_laporan' => 'unduhan'
            ])->first();

            if (!$existing) {
                $totalUnduhan = RiwayatUnduhan::where('user_id', Auth::id())
                                             ->whereYear('tanggal_unduh', $tahun)
                                             ->whereMonth('tanggal_unduh', $bulan)
                                             ->count();

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