<?php

namespace App\Http\Controllers;

use App\Models\mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeoMitraController extends Controller
{
    //
    public function index()
    {

        $mitras = Mitra::with('kategori')
                    ->whereNotNull('latitude')
                    ->whereNotNull('longtitude')
                    ->get();
        $listMitra = Mitra::latest()->paginate(10);
        $topNegara = mitra::select('negara', DB::raw('count(*) as total'))
                        ->groupBy('negara')
                        ->orderBy('total', 'desc')
                        ->limit(10)
                        ->get();

        return view('Analitik.geo-mitra.index', compact('mitras', 'listMitra', 'topNegara'));
    }
}
