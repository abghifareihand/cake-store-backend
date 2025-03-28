<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * ✅ REGISTER API
     * Endpoint: POST /api/register
     * Fungsi: Mendaftarkan user baru ke sistem
     */
    public function register(Request $request)
    {

        // Custom message untuk validasi
        $messages = [
            'email.unique' => 'Email sudah digunakan',
            'email.email' => 'Format email tidak valid',
            'password.min' => 'Password minimal harus 6 karakter',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => collect($validator->errors()->all())->first(),
            ], 422);
        }


        // Membuat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status' => 'success',
            'message' => 'Register berhasil',
            'token' => $token,
            'user' => $user
        ], 201);
    }

    /**
     * ✅ LOGIN API (Login dengan Email atau Username & Password)
     * Endpoint: POST /api/login
     * Fungsi: Login user dan mengembalikan token autentikasi
     */
    public function login(Request $request)
    {
        // Validasi input dari request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        // Jika user tidak ditemukan
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email tidak ditemukan'
            ], 401);
        }

        // Jika password salah
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password salah'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => $user
        ], 200);
    }

    /**
     * ✅ LOGOUT API
     * Endpoint: POST /api/logout
     * Fungsi: Logout user dengan menghapus semua token aktif
     * Akses: Hanya untuk user yang sudah login (Harus pakai token)
     */
    public function logout(Request $request)
    {
        // Hapus semua token yang dimiliki oleh user
        $request->user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil'
        ], 200);
    }

    /**
     * ✅ GET AUTHENTICATED USER API
     * Endpoint: GET /api/user
     * Fungsi: Mengambil informasi user yang sedang login
     * Akses: Hanya untuk user yang sudah login (Harus pakai token)
     */
    public function getUser(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Data user berhasil diambill',
            'user' => $request->user()
        ], 200);
    }
}
