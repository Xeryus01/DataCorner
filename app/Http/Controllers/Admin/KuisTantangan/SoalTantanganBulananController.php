<?php

namespace App\Http\Controllers\Admin\KuisTantangan;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Imports\SoalTantanganBulananImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Models\TantanganBulanan\KuisTantanganBulanan;
use App\Models\TantanganBulanan\SoalKuisTantanganBulanan;
use App\Models\TantanganBulanan\OpsiSoalKuisTantanganBulanan;

class SoalTantanganBulananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id_kuis, Request $request)
    {
        $search = $request->input('search');
        $soal = SoalKuisTantanganBulanan::with('opsi')
            ->where('id_kuis_tantangan_bulanan', $id_kuis)
            ->when($search, function ($query, $search) {
                $query->whereHas('kuis_tantangan_bulanan', function ($q) use ($search) {
                    $q->where('judul', 'like', '%' . $search . '%');
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        $kuis_tantangan_bulanan = KuisTantanganBulanan::findOrFail($id_kuis);

        return view('admin.kuis-tantangan-bulanan.soal-kuis.index', compact('soal', 'kuis_tantangan_bulanan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id_kuis)
    {
        $kuis_tantangan_bulanan = KuisTantanganBulanan::with('periode')
            ->where('id', $id_kuis)
            ->first();
        return view('admin.kuis-tantangan-bulanan.soal-kuis.create', compact('kuis_tantangan_bulanan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kuis_tantangan_bulanan' => 'required|exists:kuis_tantangan_bulanans,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png',
            'soal' => 'required|string',
            'tipe_soal' => 'required|in:Pilihan Ganda,Isian Singkat',
            'jawaban' => 'required|string',
        ]);

        $filePath = null;

        if ($request->hasFile('gambar')) {
            $filePath = $request->file('gambar')->store('gambar_soal_kuis_tantangan_bulanan', 'public');
        }

        // Simpan ke tabel soal_kuis_regulers
        $soal = SoalKuisTantanganBulanan::create([
            'id_kuis_tantangan_bulanan' => $request->id_kuis_tantangan_bulanan,
            'gambar' => $filePath,
            'soal' => $request->soal,
            'tipe_soal' => $request->tipe_soal,
            'jawaban' => $request->jawaban,
        ]);

        // Jika pilihan ganda, simpan opsi-opsinya
        if ($request->tipe_soal === 'Pilihan Ganda' && $request->has('options')) {
            foreach ($request->options as $label => $text) {
                if (!empty($text)) {
                    OpsiSoalKuisTantanganBulanan::create([
                        'id_soal_tantangan' => $soal->id,
                        'label' => $label,       // A, B, C, D
                        'teks_opsi' => $text,    // Isi teks jawaban
                    ]);
                }
            }
        }

        return redirect()->route('admin_soal-kuis-tantangan-bulanan.index', $request->id_kuis_tantangan_bulanan)->with('success', 'Soal berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $soal = SoalKuisTantanganBulanan::with(['opsi', 'kuis_tantangan_bulanan'])->findOrFail($id);
        // ubah opsi jadi array: ['A' => 'teks A', 'B' => 'teks B', ...]
        $opsi = $soal->opsi->pluck('teks_opsi', 'label')->toArray();
        return view('admin.kuis-tantangan-bulanan.soal-kuis.edit', compact('soal', 'opsi'));
    }

    // public function editBatch($batchId)
    // {
    //     $kuis_tantangan_bulanan = KuisTantanganBulanan::with('periode')->get();
    //     $batch = SoalKuisTantanganBulanan::where('upload_batch_id', $batchId)->firstOrFail();

    //     return view('admin.kuis-tantangan-bulanan.soal-kuis.edit', compact('batch', 'kuis_tantangan_bulanan'));
    // }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $soal = SoalKuisTantanganBulanan::findOrFail($id);
        $request->validate([
            'id_kuis_tantangan_bulanan' => 'required|exists:kuis_tantangan_bulanans,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png',
            'soal' => 'required|string',
            'tipe_soal' => 'required|in:Pilihan Ganda,Isian Singkat',
            'jawaban' => 'required',
        ]);

        if ($request->hasFile('gambar')) {
            if ($soal->gambar) {
                Storage::disk('public')->delete($soal->gambar);
            }
            $filePath = $request->file('gambar')->store('gambar_soal_kuis_tantangan_bulanan', 'public');
            $soal->gambar = $filePath;
        }

        $soal->update([
            'id_kuis_tantangan_bulanan' => $request->id_kuis_tantangan_bulanan,
            'soal' => $request->soal,
            'tipe_soal' => $request->tipe_soal,
            'jawaban' => $request->jawaban,
        ]);

        // Kalau tipe soal pilihan ganda → update opsi
        if ($request->tipe_soal === 'Pilihan Ganda' && $request->has('options')) {
            foreach ($request->options as $label => $teks_opsi) {
                $soal->opsi()->updateOrCreate(
                    ['label' => $label], // cari berdasarkan label (A, B, C, D)
                    [
                        'teks_opsi' => $teks_opsi,
                        'id_soal_tantangan' => $soal->id // penting supaya tidak null
                    ]
                );
            }
        } else {
            // Kalau bukan pilihan ganda, hapus opsi lama supaya tidak nyangkut
            $soal->opsi()->delete();
        }

        return redirect()->route('admin_soal-kuis-tantangan-bulanan.index', $request->id_kuis_tantangan_bulanan)->with('success', 'Soal berhasil diperbarui.');
    }

    // public function updateBatch(Request $request, $batchId)
    // {
    //     $request->validate([
    //         'id_kuis_tantangan_bulanan' => 'required|exists:kuis_tantangan_bulanans,id',
    //         'file' => 'required|file|mimes:xlsx',
    //         'images.*' => 'image|mimes:jpg,jpeg,png',
    //     ]);

    //     // Ambil semua soal lama berdasarkan batch
    //     $oldSoal = SoalKuisTantanganBulanan::where('upload_batch_id', $batchId)->get();

    //     // Ambil nama file excel lama
    //     $oldFile = optional($oldSoal->first())->file_soal;

    //     // Ambil semua gambar yang digunakan dalam batch ini
    //     $gambarLama = $oldSoal->pluck('gambar')->filter()->unique();

    //     // Hapus semua soal dan opsi pilihan gandanya
    //     foreach ($oldSoal as $soal) {
    //         if ($soal->tipe_soal === 'Pilihan Ganda') {
    //             $soal->opsi()->delete();
    //         }
    //         $soal->delete();
    //     }

    //     // Hapus file excel lama
    //     if ($oldFile) {
    //         Storage::disk('public')->delete('file_soal_kuis_tantangan_bulanan/' . $oldFile);
    //     }

    //     // Hapus gambar lama dari storage jika tidak dipakai soal lain
    //     foreach ($gambarLama as $gambar) {
    //         $masihDipakai = SoalKuisTantanganBulanan::where('gambar', $gambar)->exists();
    //         if (!$masihDipakai) {
    //             Storage::disk('public')->delete('gambar_soal_kuis_tantangan_bulanan/' . $gambar);
    //         }
    //     }

    //     // Simpan file excel baru
    //     $uploadedFile = $request->file('file');
    //     $filename = time() . '_' . $uploadedFile->getClientOriginalName();
    //     Storage::disk('public')->putFileAs('file_soal_kuis_tantangan_bulanan', $uploadedFile, $filename);

    //     // Upload gambar baru
    //     $imageMap = [];
    //     if ($request->hasFile('images')) {
    //         foreach ($request->file('images') as $image) {
    //             $imageName = $image->getClientOriginalName();
    //             Storage::disk('public')->putFileAs('gambar_soal_kuis_tantangan_bulanan', $image, $imageName);
    //             $imageMap[$imageName] = $imageName;
    //         }
    //     }

    //     // Import data baru dengan batch ID lama
    //     Excel::import(
    //         new SoalTantanganBulananImport(
    //             $request->id_kuis_tantangan_bulanan,
    //             $filename,
    //             $imageMap,
    //             $batchId
    //         ),
    //         $uploadedFile
    //     );

    //     return redirect()->route('admin_soal-kuis-tantangan-bulanan.index')->with('success', 'Soal kuis berhasil diperbarui.');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SoalKuisTantanganBulanan $soal_kuis_tantangan_bulanan)
    {
        if ($soal_kuis_tantangan_bulanan->gambar) {
            Storage::disk('public')->delete($soal_kuis_tantangan_bulanan->gambar);
        }
        $soal_kuis_tantangan_bulanan->delete();
        return redirect()->route('admin_soal-kuis-tantangan-bulanan.index', $soal_kuis_tantangan_bulanan->id_kuis_tantangan_bulanan)->with('success', 'Soal berhasil dihapus.');
    }

    // public function destroyBatch($batchId)
    // {
    //     // Ambil semua soal dalam batch
    //     $soalBatch = SoalKuisTantanganBulanan::where('upload_batch_id', $batchId)->get();

    //     foreach ($soalBatch as $soal) {
    //         // Hapus gambar jika ada
    //         if ($soal->gambar) {
    //             Storage::disk('public')->delete('gambar_soal_kuis_tantangan_bulanan/' . $soal->gambar);
    //         }

    //         // Hapus opsi jika tipe soal pilihan ganda
    //         if ($soal->tipe_soal === 'Pilihan Ganda') {
    //             $soal->opsi()->delete();
    //         }

    //         // Hapus soal
    //         $soal->delete();
    //     }

    //     // Hapus file Excel (gunakan file dari soal pertama)
    //     if ($soalBatch->isNotEmpty()) {
    //         Storage::disk('public')->delete('file_soal_kuis_tantangan_bulanan/' . $soalBatch[0]->file_soal);
    //     }

    //     return redirect()->route('admin_soal-kuis-tantangan-bulanan.index')
    //         ->with('success', 'Batch soal berhasil dihapus.');
    // }
}
