<?php

namespace App\Http\Controllers;

use App\Models\employe;
use App\Models\job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class employeController extends Controller
{
    // Menampilkan halaman utama untuk modul employe
    public function index()
    {
        return view('employe.index');
    }

    // Mengambil data employe dan relasi untuk DataTables
    public function list()
    {
        $id_company = Auth::guard('web')->user()->id_company; // Mengambil ID perusahaan dari user yang sedang login

        // Mengambil data employe dan data terkait menggunakan join
        $all = employe::select([
            'employe.*',
            'job.nama as job',
            'provinsi.nama as provinsi',
            'kabupaten.nama as kabupaten',
            'kecamatan.nama as kecamatan',
            'kelurahan.nama as kelurahan'
        ])
            ->leftJoin('job', 'job.id_job', '=', 'employe.id_job')
            ->leftJoin('kelurahan', 'kelurahan.id_kel', '=', 'employe.id_kel')
            ->leftJoin('kecamatan', 'kecamatan.id_kec', '=', 'kelurahan.id_kec')
            ->leftJoin('kabupaten', 'kabupaten.id_kab', '=', 'kecamatan.id_kab')
            ->leftJoin('provinsi', 'provinsi.id_prov', '=', 'kabupaten.id_prov')
            ->where('employe.id_company', $id_company)
            ->get();

        // Mengembalikan data dalam format JSON untuk DataTables
        return DataTables::of($all)
            ->addIndexColumn() // Menambahkan kolom indeks
            ->addColumn('action', function ($model) {
                // Mengenkripsi ID employe untuk keamanan
                return Crypt::encryptString($model->id_employe);
            })
            ->toJson();
    }

    // Menyimpan data employe baru
    public function store(Request $request)
    {
        // Validasi input dari user
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:200',
            'alamat' => 'required|string|max:200',
            'id_kel' => 'required|string|max:10',
            'telepon' => 'required|string|max:15',
            'id_job' => 'required|integer',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048' // Validasi untuk file foto
        ], [
            'nama.required' => 'Nama employe wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'id_kel.required' => 'Kelurahan wajib diisi.',
            'telepon.required' => 'Telepon wajib diisi.',
            'foto.required' => 'Foto wajib diisi.',
            'foto.image' => 'Foto harus berupa gambar.',
            'foto.mimes' => 'Foto hanya boleh berupa file dengan format JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal adalah 2MB.',
        ]);

        // Jika validasi gagal, kembalikan error
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Proses file foto
        $file = $request->file('foto');
        $extension = $file->getClientOriginalExtension(); // Mendapatkan ekstensi file
        $fileName = now()->format('ymdhis') . '.' . $extension; // Membuat nama file berdasarkan waktu
        $file->storeAs('berkas', $fileName); // Menyimpan file di direktori 'berkas'

        // Simpan data employe ke database
        $employe = new employe();
        $employe->nama = $request->nama;
        $employe->alamat = $request->alamat;
        $employe->id_kel = $request->id_kel;
        $employe->telepon = $request->telepon;
        $employe->id_job = $request->id_job;
        $employe->id_company = Auth::guard('web')->user()->id_company;
        $employe->foto = $fileName; // Menyimpan nama file foto
        $employe->save();
        return response()->json(['success' => true, 'message' => 'Berhasil disimpan'], 200);
    }

    // Memperbarui data employe
    public function update(Request $request, string $id)
    {
        // Validasi input dari user
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:200',
            'alamat' => 'required|string|max:200',
            'id_kel' => 'required|string|max:10',
            'telepon' => 'required|string|max:15',
            'id_job' => 'required|integer',
        ], [
            'nama.required' => 'Nama employe wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'id_kel.required' => 'Kelurahan wajib diisi.',
            'telepon.required' => 'Telepon wajib diisi.',
            'id_job.required' => 'Job wajib diisi.',
        ]);

        // Jika validasi gagal, kembalikan pesan kesalahan
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Dekripsi ID employe untuk mendapatkan ID asli
        $id = Crypt::decryptString($id);

        // Mengambil data employe dari database
        $one = employe::where('id_employe', $id)->first();

        // Memeriksa jika ada file foto baru di request
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension(); // Mendapatkan ekstensi file
            $fileNameBase = $one && $one->foto ? pathinfo($one->foto, PATHINFO_FILENAME) : now()->format('ymdhis');
            $fileName = $fileNameBase . '.' . $extension; // Membuat nama file baru
            $file->storeAs('berkas', $fileName); // Menyimpan file
            $save['foto'] = $fileName; // Menambahkan nama file ke data yang akan disimpan
        }

        // Menyimpan data lain yang diperbarui
        $save['nama'] = $request->nama;
        $save['alamat'] = $request->alamat;
        $save['id_kel'] = $request->id_kel;
        $save['telepon'] = $request->telepon;
        $save['id_job'] = $request->id_job;

        // Memperbarui data di database
        employe::where('id_employe', $id)->update($save);

        return response()->json(['success' => true, 'message' => 'Berhasil perbarui'], 200);
    }

    // Menampilkan detail employe
    public function show(string $id)
    {
        // Dekripsi ID employe untuk mendapatkan ID asli
        $id = Crypt::decryptString($id);
        $id_company = Auth::guard('web')->user()->id_company; // Mendapatkan ID perusahaan
        $employe = employe::select([
            'employe.*',
            'job.nama as job',
            'provinsi.id_prov',
            'kabupaten.id_kab',
            'kecamatan.id_kec',
            'provinsi.nama as provinsi',
            'kabupaten.nama as kabupaten',
            'kecamatan.nama as kecamatan',
            'kelurahan.nama as kelurahan'
        ])
            ->leftJoin('job', 'job.id_job', '=', 'employe.id_job')
            ->leftJoin('kelurahan', 'kelurahan.id_kel', '=', 'employe.id_kel')
            ->leftJoin('kecamatan', 'kecamatan.id_kec', '=', 'kelurahan.id_kec')
            ->leftJoin('kabupaten', 'kabupaten.id_kab', '=', 'kecamatan.id_kab')
            ->leftJoin('provinsi', 'provinsi.id_prov', '=', 'kabupaten.id_prov')
            ->where('employe.id_company', $id_company)
            ->where('employe.id_employe', $id)
            ->first();

        if (!$employe) {
            return response()->json(['success' => false, 'message' => 'Employe tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $employe], 200);
    }

    // Menghapus data employe
    public function destory(string $id)
    {
        $id = Crypt::decryptString($id); // Dekripsi ID employe

        // Cari data employe berdasarkan ID
        $employe = employe::where('id_employe', $id)->first();

        // Jika data employe tidak ditemukan, kembalikan pesan error
        if (!$employe) {
            return response()->json(['success' => false, 'message' => 'Gagal hapus, employe tidak ditemukan'], 404);
        }

        // Hapus data employe
        $employe->delete();

        return response()->json(['success' => true, 'message' => 'Berhasil hapus'], 200);
    }
}
