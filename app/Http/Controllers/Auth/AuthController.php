<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JwtAuth\Facades\JwtAuth;
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
     * Handle login request
     */
    public function login(Request $request)
    {
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
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        // Check if user is active
        if ($user->status !== 'active') {
            throw ValidationException::withMessages([
                'email' => ['Akun Anda sedang dinonaktifkan.'],
            ]);
        }

        // Generate JWT token
        $token = JwtAuth::fromUser($user);

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role->name ?? 'affiliate',
            ]
        ], 200);
    }

    /**
     * Handle register request
     */
    public function register(Request $request)
    {
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

        // Get affiliate role
        $affiliateRole = \App\Models\Role::where('name', 'affiliate')->first();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $affiliateRole->id ?? 1,
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Generate JWT token (auto login after register)
        $token = JwtAuth::fromUser($user);

        return response()->json([
            'message' => 'Pendaftaran berhasil! Selamat datang di Affillink',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role->name ?? 'affiliate',
            ]
        ], 201);
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        JwtAuth::invalidate(JwtAuth::getToken());

        return response()->json([
            'message' => 'Logout berhasil'
        ], 200);
    }

    /**
     * Refresh token
     */
    public function refresh()
    {
        $token = JwtAuth::refresh(JwtAuth::getToken());

        return response()->json([
            'message' => 'Token refreshed successfully',
            'token' => $token,
        ], 200);
    }

    /**
     * Get current user
     */
    public function me()
    {
        $user = JwtAuth::parseToken()->authenticate();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role->name ?? 'affiliate',
                'commission_rate' => $user->commission_rate,
            ]
        ], 200);
    }
}
