<?php

namespace App\Http\Controllers;

use App\Models\job;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class JobController extends Controller
{
    /**
     * Menampilkan halaman utama untuk job.
     */
    public function index()
    {
        // Mengembalikan view untuk halaman index job
        return view('job.index');
    }

    /**
     * Mengambil semua data job untuk DataTables.
     */
    public function list()
    {
        // Ambil semua data job dan urutkan berdasarkan id_job secara ascending
        $all = job::orderBy('id_job', 'asc')->get();

        // Mengembalikan data dalam format DataTables
        return DataTables::of($all)
            ->addIndexColumn() // Menambahkan kolom indeks
            ->addColumn('action', function ($model) {
                // Mengenkripsi id_job untuk keamanan
                return Crypt::encryptString($model->id_job);
            })
            ->toJson(); // Mengubah data menjadi JSON
    }

    /**
     * Menyimpan data job baru.
     */
    public function store(Request $request)
    {
        // Validasi input dari user
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100', // Nama wajib diisi, tipe string, max 255 karakter
        ], [
            'nama.required' => 'Nama job wajib diisi.', // Pesan error kustom
        ]);

        // Jika validasi gagal, kembalikan pesan kesalahan
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Simpan data job ke database
        $job = new job();
        $job->nama = $request->nama;
        $job->save();

        // Respon berhasil
        return response()->json(['success' => true, 'message' => 'Berhasil simpan'], 201);
    }

    /**
     * Memperbarui data job berdasarkan ID.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
        ], [
            'nama.required' => 'Nama job wajib diisi.',
        ]);

        // Jika validasi gagal, kembalikan pesan kesalahan
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Dekripsi ID untuk mendapatkan ID job asli
        $id = Crypt::decryptString($id);

        // Cek apakah nama job sudah ada di database untuk ID lain
        $exists = job::where('nama', $request->nama)
                     ->where('id_job', '!=', $id)
                     ->exists();

        if ($exists) {
            // Jika nama job sudah ada, kembalikan pesan error
            return response()->json(['success' => false, 'message' => 'Nama job sudah ada'], 400);
        }

        // Perbarui data job
        job::where('id_job', $id)->update([
            'nama' => $request->nama,
        ]);

        // Respon berhasil
        return response()->json(['success' => true, 'message' => 'Berhasil perbarui'], 200);
    }

    /**
     * Menampilkan detail job berdasarkan ID.
     */
    public function show(string $id)
    {
        // Dekripsi ID
        $id = Crypt::decryptString($id);

        // Ambil data job berdasarkan ID
        $job = job::where('id_job', $id)->first();

        // Jika data tidak ditemukan, kembalikan error
        if (!$job) {
            return response()->json(['success' => false, 'message' => 'Job tidak ditemukan'], 404);
        }

        // Respon berhasil
        return response()->json(['success' => true, 'data' => $job], 200);
    }

    /**
     * Menghapus job berdasarkan ID.
     */
    public function destory(string $id)
    {
        // Dekripsi ID
        $id = Crypt::decryptString($id);

        // Cari job berdasarkan ID
        $job = job::where('id_job', $id)->first();

        // Jika job tidak ditemukan, kembalikan pesan error
        if (!$job) {
            return response()->json(['success' => false, 'message' => 'Gagal hapus, job tidak ditemukan'], 404);
        }

        // Hapus job
        $job->delete();

        // Respon berhasil
        return response()->json(['success' => true, 'message' => 'Berhasil hapus'], 200);
    }

    /**
     * Membuat api job
     */
    public function job(){
        $job = job::orderBy('id_job', 'asc')->get();
        return response()->json(['success' => true, 'data' => $job], 200);
    }
}
