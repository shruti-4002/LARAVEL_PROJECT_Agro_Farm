@extends('layouts.app')

@section('title', 'Register - AgriMandi')

@section('content')
    <section class="auth-card card">
        <p class="eyebrow">New account</p>
        <h1 style="font-size: 34px;">Register</h1>
        <p class="muted">Choose one role. Farmer accounts can sell and order from other farmers.</p>

        <form method="post" action="{{ route('register.store') }}">
            @csrf
            <div class="field">
                <label for="name">Name</label>
                <input class="input" id="name" name="name" value="{{ old('name') }}" required autofocus>
            </div>
            <div class="field">
                <label for="email">Email</label>
                <input class="input" id="email" name="email" type="email" value="{{ old('email') }}" required>
            </div>
            <div class="grid two">
                <div class="field">
                    <label for="role">Role</label>
                    <select class="select" id="role" name="role" required>
                        <option value="farmer" @selected(old('role') === 'farmer')>Farmer</option>
                        <option value="buyer" @selected(old('role') === 'buyer')>Buyer</option>
                    </select>
                </div>
                <div class="field">
                    <label for="region">Region</label>
                    <input class="input" id="region" name="region" value="{{ old('region') }}" placeholder="Punjab" required>
                </div>
            </div>
            <div class="grid two">
                <div class="field">
                    <label for="password">Password</label>
                    <input class="input" id="password" name="password" type="password" required>
                </div>
                <div class="field">
                    <label for="password_confirmation">Confirm Password</label>
                    <input class="input" id="password_confirmation" name="password_confirmation" type="password" required>
                </div>
            </div>
            <div class="actions" style="margin-top: 18px;">
                <button class="button" type="submit">Register</button>
                <a class="button secondary" href="{{ route('login') }}">Login</a>
            </div>
        </form>
    </section>
@endsection
