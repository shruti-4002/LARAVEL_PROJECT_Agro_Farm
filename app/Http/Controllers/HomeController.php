<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View|RedirectResponse
    {
        $user = session('user');

        if (($user['role'] ?? null) === 'farmer') {
            return redirect()->route('farmer.marketplace');
        }

        if (($user['role'] ?? null) === 'buyer') {
            return redirect()->route('buyer.marketplace');
        }

        return view('welcome');
    }
}
