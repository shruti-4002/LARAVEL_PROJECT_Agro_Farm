<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use RuntimeException;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (session('user')) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        try {
            $user = User::findByEmail($credentials['email']);
        } catch (RuntimeException $exception) {
            return back()->withErrors(['email' => $exception->getMessage()])->withInput();
        }

        if (! $user || ! Hash::check($credentials['password'], $user['password'])) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
        }

        $request->session()->regenerate();
        $request->session()->put('user', User::safe($user));

        return redirect()->route($user['role'] === 'farmer' ? 'farmer.marketplace' : 'buyer.marketplace');
    }

    public function showRegister(): View|RedirectResponse
    {
        if (session('user')) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'email', 'max:120'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', Rule::in(['farmer', 'buyer'])],
            'region' => ['required', 'string', 'max:80'],
        ]);

        try {
            if (User::findByEmail($data['email'])) {
                return back()->withErrors(['email' => 'This email is already registered.'])->withInput();
            }

            $user = User::create($data);
        } catch (RuntimeException $exception) {
            return back()->withErrors(['email' => $exception->getMessage()])->withInput();
        }

        $request->session()->regenerate();
        $request->session()->put('user', $user);

        return redirect()->route($user['role'] === 'farmer' ? 'farmer.marketplace' : 'buyer.marketplace');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Logged out successfully.');
    }
}
