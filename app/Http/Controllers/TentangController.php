<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\maklumat;
use App\Models\Standar;

class TentangController extends Controller
{
    public function index()
    {
        //Ambil data dari database
        $maklumat = maklumat::latest()->get();
        $standar  = Standar::latest()->get();

        //Kirim ke view
        return view('user.tentang', compact('maklumat', 'standar'));
    }
}