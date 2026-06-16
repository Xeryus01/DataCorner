<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index(){
        $admin = Admin::all();
        $adminLogin = Session::get('adminLogin');
        return view('admin.admin.index', compact('admin', 'adminLogin'));
    }

    public function create(){
        $admin = Admin::all();
        return view('admin.admin.create', compact('admin'));
    }

    public function store(Request $request){
        $request->validate([
            'email' => 'required|unique:admins|string',
            'nama' => 'required|min:2|string',
            'password' => 'required|min:5|string',
        ]);

        Admin::create([
            "email" => $request->email,
            "nama" => $request->nama,
            "password" => Hash::make($request->password),
        ]);
        return redirect()->route('admin.index')->with('success', 'Admin Berhasil Ditambah');
    }

    public function edit($id){
        $admin = Admin::findOrFail($id);
        return view('admin.admin.edit', compact('admin'));
    }


    public function update(Request $request, Admin $admin)
{
    $request->validate([
        'email' => 'required|string|email|unique:admins,email,' . $admin->id,
        'nama' => 'required|string|min:2',
        'password' => 'nullable|string|min:5',
    ]);

    $admin->email = $request->email;
    $admin->nama = $request->nama;

    if ($request->filled('password')) {
        $admin->password = Hash::make($request->password);
    }

    $admin->save();

    return redirect()->route('admin.index')->with('success', 'Admin Berhasil Diubah');
}


    public function destroy($id){
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect()->route('admin.index')->with('success', 'Admin Berhasil Dihapus');
    }
}
