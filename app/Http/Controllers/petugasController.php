<?php

namespace App\Http\Controllers;

use App\Models\konsultan;
use App\Models\petugas;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class petugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
    {
    $konsultan = Konsultan::all();
    $petugas = Petugas::with('konsultan')->orderBy('tanggal', 'desc')->get();
    $query = Petugas::query()->with('konsultan');

        // Logika Filter
        if ($request->has('tanggal') && $request->tanggal != null) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->has('bulan') && $request->bulan != null) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->has('tahun') && $request->tahun != null) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $petugas = $query->orderBy('tanggal', 'desc')->get();

    return view('admin.petugas.index', compact('konsultan', 'petugas'));
}

    /**
     * Show the form for creating a new resource.
     */
public function store(Request $request)
{
    $request->validate([
        'konsultan_id' => 'required|exists:konsultans,id',
        'tanggal' => 'required|date',
    ]);

    Petugas::create([
        'konsultan_id' => $request->konsultan_id,
        'tanggal' => $request->tanggal,
    ]);

    return redirect()->route('petugas.index')->with('success', 'Petugas berhasil ditambahkan.');
}

public function exportPdf(Request $request)
    {
        // 1. Mengambil data berdasarkan filter dari request
        $petugas = Petugas::with('konsultan')
            ->when($request->tanggal, function ($query, $tanggal) {
                return $query->whereDate('tanggal', $tanggal);
            })
            ->when($request->bulan, function ($query, $bulan) {
                return $query->whereMonth('tanggal', $bulan);
            })
            ->when($request->tahun, function ($query, $tahun) {
                return $query->whereYear('tanggal', $tahun);
            })
            ->orderBy('tanggal', 'asc')
            ->get();

        // 2. Memproses data untuk rekapitulasi kehadiran
        // Rekapitulasi per petugas (untuk tabel pertama)
        $kehadiranPerPetugas = $petugas->groupBy('konsultan.nama')->map->count();

        // Rekapitulasi per bulan (per individu konsultan)
        $kehadiranPerBulan = $petugas->groupBy(function($item) {
            return Carbon::parse($item->tanggal)->locale('id')->isoFormat('MMMM Y');
        })->map(function ($items) {
            return $items->groupBy('konsultan.nama')->map->count();
        });

        // Rekapitulasi per tahun (per individu konsultan)
        $kehadiranPerTahun = $petugas->groupBy(function($item) {
            return Carbon::parse($item->tanggal)->locale('id')->isoFormat('Y');
        })->map(function ($items) {
            return $items->groupBy('konsultan.nama')->map->count();
        });

        // 3. Memuat view dan membuat file PDF
        $pdf = PDF::loadView('admin.petugas.pdf', [
            'petugas' => $petugas,
            'kehadiranPerPetugas' => $kehadiranPerPetugas,
            'filters' => $request->all(),
            'kehadiranPerBulan' => $kehadiranPerBulan,
            'kehadiranPerTahun' => $kehadiranPerTahun,
        ]);

        // 4. Mengembalikan respons untuk mengunduh file
        return $pdf->download('laporan-petugas-mingguan.pdf');
    }

public function update(Request $request, $id)
{
    $request->validate([
        'konsultan_id' => 'required|exists:konsultans,id',
        'tanggal' => 'required|date',
    ]);

    $petugas = Petugas::findOrFail($id);
    $petugas->update([
        'konsultan_id' => $request->konsultan_id,
        'tanggal' => $request->tanggal,
    ]);

    return redirect()->route('petugas.index')->with('success', 'Data petugas berhasil diperbarui.');
}

public function create()
{
    $konsultan = Konsultan::all();
    return view('admin.petugas.create', compact('konsultan'));
}

public function edit($id)
{
    $petugas = Petugas::findOrFail($id);
    $konsultan = Konsultan::all();

    return view('admin.petugas.edit', compact('petugas', 'konsultan'));
}


public function destroy($id)
{
    $petugas = Petugas::findOrFail($id);
    $petugas->delete();

    return redirect()->route('petugas.index')->with('success', 'Data petugas berhasil dihapus.');
}

// public function destroyAll(Request $request)
//     {
//         try {
//             // Ini adalah cara paling efisien untuk menghapus semua data
//             // Jika Anda tidak memiliki foreign key constraints pada tabel ini.
//             Petugas::truncate();

//             // Alternatifnya, jika ada foreign key, gunakan:
//             // Petugas::query()->delete();

//             return redirect()->route('petugas.index')->with('success', 'Semua data petugas berhasil dihapus!');
//         } catch (\Exception $e) {
//             // Log error untuk debugging
//             \Log::error('Gagal menghapus semua data petugas: ' . $e->getMessage());
//             return redirect()->route('petugas.index')->with('error', 'Terjadi kesalahan saat menghapus semua data petugas.');
//         }
//     }


}
