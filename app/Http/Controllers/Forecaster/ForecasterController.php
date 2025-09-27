<?php

namespace App\Http\Controllers\Forecaster;

use App\Http\Controllers\Controller;
use App\Models\DokumenHarian;
use App\Models\RiwayatUnduhan;
use App\Models\LaporanBulanan;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ForecasterController extends Controller
{
    public function dashboard()
    {
        $totalDokumen = DokumenHarian::where('forecaster_id', Auth::id())->count();
        $totalUnduhan = RiwayatUnduhan::whereHas('dokumen', function($query) {
            $query->where('forecaster_id', Auth::id());
        })->count();
        
        return view('forecaster.dashboard', compact('totalDokumen', 'totalUnduhan'));
    }

    // DOKUMEN HARIAN
    public function dokumenHarian()
    {
        $dokumen = DokumenHarian::where('forecaster_id', Auth::id())
                                ->orderBy('tanggal_upload', 'desc')
                                ->paginate(10);
        return view('forecaster.dokumen.index', compact('dokumen'));
    }

    public function createDokumen()
    {
        return view('forecaster.dokumen.create');
    }

    public function storeDokumen(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:150',
            'deskripsi' => 'required',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // Max 10MB
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('dokumen', $filename, 'public');

        DokumenHarian::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'tanggal_upload' => now()->toDateString(),
            'forecaster_id' => Auth::id(),
        ]);

        return redirect()->route('forecaster.dokumen.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    public function editDokumen($id)
    {
        $dokumen = DokumenHarian::where('forecaster_id', Auth::id())->findOrFail($id);
        return view('forecaster.dokumen.edit', compact('dokumen'));
    }

    public function updateDokumen(Request $request, $id)
    {
        $dokumen = DokumenHarian::where('forecaster_id', Auth::id())->findOrFail($id);

        $request->validate([
            'judul' => 'required|max:150',
            'deskripsi' => 'required',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $updateData = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($dokumen->file_path) {
                Storage::disk('public')->delete($dokumen->file_path);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('dokumen', $filename, 'public');
            $updateData['file_path'] = $filePath;
        }

        $dokumen->update($updateData);

        return redirect()->route('forecaster.dokumen.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function deleteDokumen($id)
    {
        $dokumen = DokumenHarian::where('forecaster_id', Auth::id())->findOrFail($id);
        
        // Hapus file
        if ($dokumen->file_path) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        $dokumen->delete();

        return redirect()->route('forecaster.dokumen.index')->with('success', 'Dokumen berhasil dihapus.');
    }

    // RIWAYAT UNDUHAN
    public function riwayatUnduhan()
    {
        $riwayat = RiwayatUnduhan::with(['dokumen', 'user', 'maskapai'])
                                 ->whereHas('dokumen', function($query) {
                                     $query->where('forecaster_id', Auth::id());
                                 })
                                 ->orderBy('tanggal_unduh', 'desc')
                                 ->paginate(15);
        
        return view('forecaster.riwayat', compact('riwayat'));
    }

    // LAPORAN BULANAN 
public function laporanBulanan(Request $request)
{
    $tahun = $request->get('tahun', date('Y'));
    
    // Generate laporan otomatis
    $this->generateLaporanBulanan($tahun);
    
    $laporan = LaporanBulanan::where('user_id', Auth::id())
                             ->where('jenis_laporan', 'unggahan')
                             ->where('tahun', $tahun)
                             ->orderBy('bulan')
                             ->get();

    // Jika request download PDF
    if ($request->has('export') && $request->get('export') === 'pdf') {
        return $this->downloadLaporanPDF($laporan, $tahun);
    }

    return view('forecaster.laporan', compact('laporan', 'tahun'));
}

// Download Laporan PDF untuk Forecaster
private function downloadLaporanPDF($laporan, $tahun)
{
    $user = Auth::user();
    $totalUnggahan = $laporan->sum('total');
    $bulanAktif = $laporan->where('total', '>', 0)->count();
    
    $data = [
        'laporan' => $laporan,
        'tahun' => $tahun,
        'user' => $user,
        'totalUnggahan' => $totalUnggahan,
        'bulanAktif' => $bulanAktif,
        'tanggalGenerate' => now()->format('d F Y H:i')
    ];

    $filename = 'Laporan_Unggahan_Forecaster_' . $tahun . '.html';
    
    return response()
        ->view('forecaster.laporan-pdf', $data)
        ->header('Content-Type', 'text/html; charset=utf-8')
        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
}

// Generate laporan unggahan untuk Forecaster
private function generateLaporanBulanan($tahun)
{
    for ($bulan = 1; $bulan <= 12; $bulan++) {
        // Hitung total unggahan untuk bulan ini
        $totalUnggahan = DokumenHarian::where('forecaster_id', Auth::id())
                                     ->whereYear('tanggal_upload', $tahun)
                                     ->whereMonth('tanggal_upload', $bulan)
                                     ->count();

        // Cari existing record
        $existing = LaporanBulanan::where([
            'user_id' => Auth::id(),
            'tahun' => $tahun,
            'bulan' => $bulan,
            'jenis_laporan' => 'unggahan'
        ])->first();

        if ($existing) {
            // UPDATE existing record dengan data terbaru
            $existing->update(['total' => $totalUnggahan]);
        } else {
            // CREATE new record
            LaporanBulanan::create([
                'user_id' => Auth::id(),
                'bulan' => $bulan,
                'tahun' => $tahun,
                'total' => $totalUnggahan,
                'jenis_laporan' => 'unggahan'
            ]);
        }
    }
}

    // INFO KONTAK
    public function infoKontak()
    {
        $kontak = Kontak::first();
        return view('forecaster.kontak', compact('kontak'));
    }
}