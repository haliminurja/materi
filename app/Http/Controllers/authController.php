<?php

namespace App\Http\Controllers;

use App\Models\company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class authController extends Controller
{
    // Menampilkan halaman login
    public function login()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    // Proses login dan autentikasi pengguna
    public function logindb(Request $request)
    {
        // Validasi inputan
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Jika validasi gagal, kembalikan kesalahan
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // Kode status 422 jika validasi gagal
        }

        // Proses autentikasi dengan guard khusus (company)
        if (Auth::guard('web')->attempt([
            'username' => $request->username,
            'password' => $request->password
        ], $request->has('remember'))) {
            // Jika login sukses
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil'
            ], 200); // Status HTTP 200 OK
        }

        // Jika login gagal karena kredensial salah
        return response()->json([
            'success' => false,
            'message' => 'Username atau password salah'
        ], 401); // Status HTTP 401 Unauthorized
    }

    // Menampilkan halaman registrasi
    public function register()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register'); // Perbaikan: arahkan ke halaman register, bukan login
    }

    // Proses pendaftaran pengguna baru
    public function registerdb(Request $request)
    {
        // Validasi inputan
        $validator = Validator::make($request->all(), [
            'company' => 'required|string|max:100',
            'email' => 'required|email',
            'username' => 'required|string|max:50',
            'password' => 'required|string|min:6',
            'telepon' => 'required|string|max:15',
        ], [
            'company.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 6 karakter.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'telepon.max' => 'Nomor telepon tidak boleh lebih dari 15 karakter.',
        ]);

        // Jika validasi gagal, kembalikan kesalahan
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // Kode status 422 jika validasi gagal
        }

        // Menyimpan data pengguna yang sudah tervalidasi
        $save = [
            'company' => $request->company,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'username' => $request->username,
            'password' => bcrypt($request->password), // Menggunakan bcrypt untuk password hashing
        ];

        // Simpan data ke database
        company::create($save);

        // Mengembalikan respons sukses
        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil'
        ], 201);  // Status HTTP 201 untuk data yang berhasil dibuat
    }

    public function logout()
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            session()->flush();
        }

        return redirect()->route('login');
    }

    public function dashboard(){
        return view('auth.dashboard');
    }
}
