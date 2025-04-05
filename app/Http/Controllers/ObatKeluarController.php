<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\ObatKeluar;
use App\Models\Pasien;
use Illuminate\Http\Request;

class ObatKeluarController extends Controller
{
    public function index()
    {
        $pasien = Pasien::paginate(5);
    $obat = Obat::paginate(5);

    return view('obatkeluar', compact('pasien', 'obat'));
    }
}
