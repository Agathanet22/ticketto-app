<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse; // Pastikan ini di-import
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    //Display the login view.
   
    public function create(): View
    {
        return view('auth.login');
    }

    //Handle an incoming authentication request.
    
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // LOGIKA BARU UNTUK REDIRECT BERDASARKAN PERAN
        if ($request->user()->is_admin) {
            return redirect()->intended(route('admin.dashboard'));
        }

        // PERBAIKAN: Redirect default untuk user reguler langsung ke '/dashboard'
        return redirect()->intended('/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
