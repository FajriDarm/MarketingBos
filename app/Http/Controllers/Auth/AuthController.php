<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Show register form
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle login request - API
     */
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|string|min:8',
            ], [
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email tidak valid',
                'email.exists' => 'Email tidak terdaftar',
                'password.required' => 'Password harus diisi',
                'password.min' => 'Password minimal 8 karakter',
            ]);

            $user = User::where('email', $validated['email'])->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password salah',
                    'errors' => ['email' => ['Email atau password salah']]
                ], 401);
            }

            // Check if user is active
            if ($user->status !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda sedang dinonaktifkan',
                    'errors' => ['email' => ['Akun Anda sedang dinonaktifkan']]
                ], 403);
            }

            // Generate JWT token using auth()
            $token = Auth::guard('api')->login($user);

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role->name ?? 'affiliate',
                ]
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle register request - API
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ], [
                'name.required' => 'Nama lengkap harus diisi',
                'name.max' => 'Nama maksimal 255 karakter',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'password.required' => 'Password harus diisi',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Password tidak sesuai dengan konfirmasi password',
            ]);

            // Get or create affiliate role
            $affiliateRole = Role::firstOrCreate(
                ['name' => 'affiliate'],
                ['description' => 'Affiliate User']
            );

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $affiliateRole->id,
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            // Generate JWT token using auth()
            $token = Auth::guard('api')->login($user);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil! Selamat datang di Affillink',
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role->name ?? 'affiliate',
                ]
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        try {
            Auth::guard('api')->logout();

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Refresh token
     */
    public function refresh()
    {
        try {
            $token = Auth::guard('api')->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Token berhasil di-refresh',
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get current user
     */
    public function me()
    {
        try {
            $user = Auth::guard('api')->user();

            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role->name ?? 'affiliate',
                    'commission_rate' => $user->commission_rate ?? 0,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak terautentikasi: ' . $e->getMessage(),
            ], 401);
        }
    }
}

