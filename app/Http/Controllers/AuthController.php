<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Rules\HybridCaptchaRule;
use App\Services\HybridCaptchaService;

class AuthController extends Controller
{
    private $hybridCaptchaService;

    public function __construct()
    {
        $this->hybridCaptchaService = new HybridCaptchaService();
    }

    /**
     * Login form.
     */
    public function login(): View
    {
        // tampilkan form login
        $pengaturan = \App\Models\Pengaturan::first();
        $recaptchaSiteKey = $this->hybridCaptchaService->getSiteKey();
        $showNumericCaptcha = $this->hybridCaptchaService->shouldShowAlphanumericCaptcha();

        return view('auth.login', compact('pengaturan', 'recaptchaSiteKey', 'showNumericCaptcha'));
    }

    /**
     * Login authentication.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        try {
            // validasi form termasuk hybrid CAPTCHA
            $credentials = $request->validate([
                'username' => 'required',
                'password' => 'required',
                'g-recaptcha-response' => 'recaptcha',
            ], [
                'username.required' => 'Username tidak boleh kosong.',
                'password.required' => 'Password tidak boleh kosong.',
                'g-recaptcha-response.recaptcha' => 'Silakan centang captcha untuk membuktikan Anda bukan robot.',
              
            ]);

            // jika login berhasil
            $remember = $request->filled('remember');
            if (Auth::attempt($request->only('username', 'password'), $remember)) {
                $request->session()->regenerate();
                // Reset CAPTCHA state setelah login berhasil
                $this->hybridCaptchaService->reset();
                return redirect()->intended(route('dashboard.index'));
            }

            // jika login gagal (username/password salah)
            return back()
                ->withInput($request->only('username')) // hanya preserve username, tidak preserve captcha
                ->with('error', 'Username atau Password salah. Cek kembali Username dan Password Anda.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // jika validasi gagal (termasuk CAPTCHA)
            return back()
                ->withInput($request->only('username')) // hanya preserve username, tidak preserve captcha
                ->withErrors($e->errors());
        }
    }

    /**
     * Logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // redirect ke halaman login dan tampilkan pesan berhasil logout
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
