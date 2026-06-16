<?php

namespace App\Http\Controllers;

use App\Models\janjitemu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class janjitemuController extends Controller
{

    // public function index(){
    //     $janjitemu = janjitemu::all();
    //     return view('janjitemu.index', compact('janjitemu'));
    // }

    public function index()
    {
        $userId = Session::get('user_id');

        if (!$userId) {
            return redirect()->route('loginUser')
                ->withErrors('Silakan login terlebih dahulu.');
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('loginUser')
                ->withErrors('Data user tidak ditemukan.');
        }

        return view('janjitemu.index', compact('user'));
    }



    // public function indexJadwal()
    // {
    //     $userId = Session::get('user_id');

    //     $janjitemu = janjitemu::where('users_id', $userId)
    //     ->latest()
    //     ->get();
    //     return view('janjitemu.jadwal', compact('janjitemu'));
    // }

    public function indexJadwal()
    {
        $userId = Session::get('user_id');

        if (!$userId) {
            return redirect()->route('loginUser')
                ->withErrors('Silakan login terlebih dahulu.');
        }

        $janjitemu = janjitemu::with('user')
            ->where('users_id', $userId)
            ->latest()
            // ->get();
            ->paginate(10);

        return view('janjitemu.jadwal', compact('janjitemu'));
    }


    // public function store(Request $request)
    // {
    //     // 1. Hapus validasi untuk tanggal dan jam
    //     $request->validate([
    //         'alamat' => 'required|min:3|string',
    //         'keperluan' => 'required|min:3|string',
    //         'jenis' => 'required|in:online,offline',
    //     ], [
    //         'alamat.required' => 'Alamat Tidak Boleh Kosong',
    //         'keperluan.required' => 'Keperluan Tidak Boleh Kosong',
    //         'jenis.required' => 'Jenis Tidak Boleh Kosong',
    //     ]);

    //     $userId = Session::get('user_id');

    //     if (!$userId) {
    //         return redirect()->route('loginUser')->withErrors('Silakan login terlebih dahulu.');
    //     }

    //     janjitemu::create([
    //         'users_id' => $userId,
    //         'alamat' => $request->alamat,
    //         'keperluan' => $request->keperluan,
    //         'jenis' => $request->jenis,
    //         // 2. Hapus 'tanggal' dan 'jam' dari sini. Status akan default 'menunggu'
    //     ]);

    //     return redirect()->route('janjitemu.index')->with('success', 'Permintaan janji temu berhasil dikirim. Harap tunggu konfirmasi dari admin.');
    // }

    public function store(Request $request)
    {
        $userId = Session::get('user_id');

        if (!$userId) {
            return redirect()->route('loginUser')
                ->withErrors('Silakan login terlebih dahulu.');
        }

        $validated = $request->validate([
            'instansi_lembaga' => 'required|string|max:255',
            'jenis' => 'required|in:online,offline',
            'keperluan_data' => 'required|array|min:1',
            'keperluan_data.*' => 'string',
            'layanan_dibutuhkan' => 'required|array|min:1',
            'layanan_dibutuhkan.*' => 'string',
            'data_diminta' => 'required|string',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam' => 'required',
            'jumlah_orang' => 'required|integer|min:1|max:50',
        ], [
            'instansi_lembaga.required' => 'Instansi/Lembaga wajib diisi.',
            'jenis.required' => 'Jenis layanan wajib dipilih.',
            'keperluan_data.required' => 'Keperluan penggunaan data wajib dipilih.',
            'layanan_dibutuhkan.required' => 'Layanan yang dibutuhkan wajib dipilih.',
            'data_diminta.required' => 'Data yang diminta wajib diisi.',
            'tanggal.required' => 'Pilihan hari wajib diisi.',
            'tanggal.after_or_equal' => 'Tanggal tidak boleh sebelum hari ini.',
            'jam.required' => 'Pilihan jam wajib diisi.',
            'jumlah_orang.required' => 'Jumlah orang wajib diisi.',
            'jumlah_orang.min' => 'Jumlah orang minimal 1.',
        ]);

        $keperluanData = implode(', ', $validated['keperluan_data']);
        $layananDibutuhkan = implode(', ', $validated['layanan_dibutuhkan']);

        janjitemu::create([
            'users_id' => $userId,
            'instansi_lembaga' => $validated['instansi_lembaga'],
            'jenis' => $validated['jenis'],
            'keperluan_data' => $keperluanData,
            'data_diminta' => $validated['data_diminta'],
            'tanggal' => $validated['tanggal'],
            'jam' => $validated['jam'],
            'jumlah_orang' => $validated['jumlah_orang'],
            'layanan_dibutuhkan' => $layananDibutuhkan,            

            'status' => 'menunggu',
        ]);

        return redirect()
            ->route('janjitemu.index')
            ->with('success', 'Permintaan janji temu berhasil dikirim. Harap tunggu konfirmasi dari admin.');
    }

    public function edit($id)
    {
        $janjitemu = janjitemu::findOrFail($id);
        return view('janjitemu.edit', compact('janjitemu'));
    }

    // public function update(Request $request, $id)
    // {
    //     $janjitemu = janjitemu::findOrFail($id);

    //     $data = [
    //         'alamat' => $request->alamat,
    //         'keperluan' => $request->keperluan,
    //         'tanggal' => $request->tanggal,
    //         'jam' => $request->jam,
    //         'jenis' => $request->jenis,
    //     ];

    //     $janjitemu->update($data);

    //     return redirect()->route('janjitemu.jadwal')->with('success', 'Data berhasil diperbarui.');
    // }

    public function update(Request $request, $id)
    {
        $janjitemu = janjitemu::findOrFail($id);

        $validated = $request->validate([
            'instansi_lembaga' => 'required|string|max:255',
            'jenis' => 'required|in:online,offline',
            'keperluan_data' => 'required|array|min:1',
            'keperluan_data.*' => 'string',
            'layanan_dibutuhkan' => 'required|array|min:1',
            'layanan_dibutuhkan.*' => 'string',        
            'data_diminta' => 'required|string',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam' => 'required',
            'jumlah_orang' => 'required|integer|min:1|max:50',
        ]);

        $keperluanData = implode(', ', $validated['keperluan_data']);
        $layananDibutuhkan = implode(', ', $validated['layanan_dibutuhkan']);

        $janjitemu->update([
            'instansi_lembaga' => $validated['instansi_lembaga'],
            'jenis' => $validated['jenis'],
            'keperluan_data' => $keperluanData,
            'layanan_dibutuhkan' => $layananDibutuhkan,
            'data_diminta' => $validated['data_diminta'],
            'tanggal' => $validated['tanggal'],
            'jam' => $validated['jam'],
            'jumlah_orang' => $validated['jumlah_orang'],            
        ]);

        return redirect()
            ->route('janjitemu.jadwal')
            ->with('success', 'Data janji temu berhasil diperbarui.');
    }

    public function destroy($id){
        $janjitemu = janjitemu::findOrFail($id);
        $janjitemu->delete();
        return redirect()->route('janjitemu.index')->with('success', 'janjitemu Berhasil Dihapus');
    }

 /**
  * untuk online
  */

    // public function indexOnline()
    // {
    //    $janjitemu = Janjitemu::where('jenis', 'online')->get();
    //     return view('janjitemu.indexOnline', compact('janjitemu'));
    // }

    public function batal(Request $request, $id)
    {
        $request->validate([
            'alasan_batal' => 'required|string|max:255',
        ]);

        $janjitemu = janjitemu::findOrFail($id);
        $janjitemu->status = 'batal';
        $janjitemu->alasan_batal = $request->alasan_batal;
        $janjitemu->save();

        return redirect()->back()->with('success', 'Janji temu berhasil dibatalkan.');
    }




}
