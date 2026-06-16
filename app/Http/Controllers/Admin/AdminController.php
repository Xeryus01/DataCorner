<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Models\Artikel;
use App\Models\Infografis;
use Illuminate\Http\Request;
use App\Models\PendaftaranRiset;
use App\Models\PendaftaranMagang;
use App\Models\VideoPembelajaran;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\KuisReguler\KuisReguler;
use App\Models\TantanganBulanan\Periode;
use App\Models\ProgresBelajar\ArtikelDibaca;
use App\Models\TantanganBulanan\KuisTantanganBulanan;
use App\Models\TantanganBulanan\HasilKuisTantanganBulanan;
use App\Models\WilayahBps;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::with('roles')->get();
        return view('admin.index', compact('admins'));
    }

    public function dashboard()
    {
        $artikel_populer = Artikel::select('*')
            ->selectRaw('(SELECT COUNT(*) FROM artikel_dibacas WHERE artikel_dibacas.id_artikel = artikels.id) as total_dibaca')
            ->orderByDesc('total_dibaca')
            ->first();


        $video_populer = VideoPembelajaran::select('*')
            ->selectRaw('(SELECT COUNT(*) FROM video_dilihats WHERE video_dilihats.id_video = video_pembelajarans.id) as total_dilihat')
            ->orderByDesc('total_dilihat')
            ->first();

        $infografis_populer = Infografis::select('*')
            ->selectRaw('(SELECT COUNT(*) FROM infografis_dilihats WHERE infografis_dilihats.id_infografis = infografis.id) as total_dilihat')
            ->orderByDesc('total_dilihat')
            ->first();

        $periode = Periode::where('status_leaderboard', 'aktif')->first();

        if (!$periode) {
            return view('admin.dashboard', [
                'user' => User::count(),
                'pendaftar_magang' => PendaftaranMagang::where('status', 'diproses')->count(),
                'pendaftar_riset' => PendaftaranRiset::where('status', 'diproses')->count(),
                'artikel' => Artikel::count(),
                'video' => VideoPembelajaran::count(),
                'infografis' => Infografis::count(),
                'kuis_reguler' => KuisReguler::count(),
                'kuis_tantangan' => KuisTantanganBulanan::count(),
                'artikel_populer' => $artikel_populer,
                'video_populer' => $video_populer,
                'infografis_populer' => $infografis_populer,
                'top_users' => [],
                'periode' => null
            ]);
        }

        // Ambil semua id kuis dalam periode aktif
        $kuisId = KuisTantanganBulanan::where('id_periode', $periode->id)->pluck('id');
        // Ambil top 10 user berdasarkan total skor dari seluruh kuis dalam periode
        $topUsers = HasilKuisTantanganBulanan::select('id_user', DB::raw('SUM(skor) as total_skor'))
            ->whereIn('id_kuis_tantangan_bulanan', $kuisId)
            ->groupBy('id_user')
            ->orderByDesc('total_skor')
            ->with('user')
            ->take(10)
            ->get();
        return view('admin.dashboard', [
            'user' => User::count(),
            'pendaftar_magang' => PendaftaranMagang::where('status', 'diproses')->count(),
            'pendaftar_riset' => PendaftaranRiset::where('status', 'diproses')->count(),
            'artikel' => Artikel::count(),
            'video' => VideoPembelajaran::count(),
            'infografis' => Infografis::count(),
            'kuis_reguler' => KuisReguler::count(),
            'kuis_tantangan' => KuisTantanganBulanan::count(),
            'artikel_populer' => $artikel_populer,
            'video_populer' => $video_populer,
            'infografis_populer' => $infografis_populer,
            'top_users' => $topUsers,
            'periode' => $periode
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('guard_name', 'admin')->get();
        $wilayah = WilayahBps::all();

        return view('admin.create', compact('roles', 'wilayah'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:admins,username',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|exists:roles,name',
            'wilayah_id' => 'nullable|exists:wilayah_bps,id'
        ]);

        // 🔥 Validasi: operator wajib punya wilayah
        if (in_array($request->role, ['operator magang', 'operator kepegawaian']) && !$request->wilayah_id) {
            return back()->withErrors(['wilayah_id' => 'Wilayah wajib diisi'])->withInput();
        }

        $admin = Admin::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'wilayah_id' => $request->wilayah_id
        ]);

        $admin->assignRole($request->role);

        return redirect()->route('admin_data-admin.index')->with('success', 'Admin berhasil ditambahkan');
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
    public function edit(Admin $data_admin)
    {
        $roles = Role::where('guard_name', 'admin')->get();
        $wilayah = WilayahBps::all();
        return view('admin.edit', compact('data_admin', 'roles', 'wilayah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $data_admin)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'nullable|min:6|confirmed', // hanya jika ingin ganti password
            'role' => 'required|exists:roles,name',
            'wilayah_id' => 'nullable|exists:wilayah_bps,id'
        ]);
        
        $data_admin->username = $request->username;
        
        if ($request->filled('password')) {
            $data_admin->password = Hash::make($request->password);
        }
        $data_admin->wilayah_id = $request->wilayah_id;
        $data_admin->save();    
        $data_admin->syncRoles([$request->role]);

        return redirect()->route('admin_data-admin.index')->with('success', 'Admin berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $data_admin)
    {
        $data_admin->delete();
        return redirect()->route('admin_data-admin.index')->with('success', 'Admin berhasil dihapus.');
    }
}
