<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;

class WilayahController extends Controller
{
    /**
     * Menampilkan semua provinsi.
     */
    public function provinsi(){
        $provinsi = Provinsi::all();
        return response()->json(['success' => true, 'data' => $provinsi], 200);
    }

    /**
     * Menampilkan semua kabupaten berdasarkan ID provinsi.
     */
    public function kabupaten(string $id){
        $kabupaten = Kabupaten::where('id_prov', $id)->get();

        if ($kabupaten->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada data kabupaten'], 404);
        }

        return response()->json(['success' => true, 'data' => $kabupaten], 200);
    }

    /**
     * Menampilkan semua kecamatan berdasarkan ID kabupaten.
     */
    public function kecamatan(string $id){
        $kecamatan = Kecamatan::where('id_kab', $id)->get();

        if ($kecamatan->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada data kecamatan'], 404);
        }

        return response()->json(['success' => true, 'data' => $kecamatan], 200);
    }

    /**
     * Menampilkan semua kelurahan berdasarkan ID kecamatan.
     */
    public function kelurahan(string $id){
        $kelurahan = Kelurahan::where('id_kec', $id)->get();

        if ($kelurahan->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada data kelurahan'], 404);
        }

        return response()->json(['success' => true, 'data' => $kelurahan], 200);
    }
}
