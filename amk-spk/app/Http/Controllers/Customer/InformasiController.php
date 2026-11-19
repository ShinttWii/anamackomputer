<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Kerusakan;

class InformasiController extends Controller
{
    public function index()
    {
        $kerusakans = Kerusakan::with(['penyebabs', 'solusIs'])->orderBy('kode')->get();
        return view('customer.informasi', compact('kerusakans'));
    }
}
