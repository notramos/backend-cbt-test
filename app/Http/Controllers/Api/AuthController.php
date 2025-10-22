<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (!Auth::attempt($request->only('email', 'password'))) {
                throw ValidationException::withMessages([
                    'email' => ['Kredensial tidak valid.'],
                ]);
            }

            $user = Auth::user();
            $token = $user->createToken('cbt-token')->plainTextToken;

            return response()->json([
                'message' => 'Login berhasil',
                'token'
                => $token,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat login',
            ], 500);
        }
    }
    public function logout(Request $request)
    {
        try {
            // Hapus semua token user (atau hanya token saat ini)
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Berhasil logout'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal logout'
            ], 500);
        }
    }
}
