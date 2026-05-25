@extends('layouts.app')

@section('title', 'Login - AgriMandi')

@section('content')
<style>
    :root {
        --primary-green: #10b981;
        --dark-green: #065f46;
        --accent-gold: #f59e0b;
        --bg-gradient: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        --glass-bg: rgba(255, 255, 255, 0.92);
        --text-main: #1f2937;
        --text-muted: #4b5563;
    }

 
    .agri-login-wrapper {
        display: flex;
        min-height: 85vh;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        background: var(--glass-bg);
        backdrop-filter: blur(8px);
        margin: 20px auto;
        max-width: 1100px;
        animation: slideUpFade 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

  
    .agri-visual-panel {
        flex: 1;
        background: linear-gradient(to bottom, rgba(6, 95, 70, 0.3), rgba(6, 95, 70, 0.85)), 
                    url('https://subsistencefarming.in/wp-content/uploads/2026/02/subsistence_farming1.jpg');
        background-size: cover;
        background-position: center;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 40px;
        color: #ffffff;
        position: relative;
    }

    .agri-visual-panel::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: radial-gradient(circle at top left, rgba(245, 158, 11, 0.2), transparent 60%);
    }

    .panel-headline {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .panel-sub {
        font-size: 15px;
        color: #e6f4ea;
        z-index: 1;
        opacity: 0.9;
    }

    /* Right Side: Enhanced core form container */
    .auth-card.card {
        flex: 1;
        padding: 50px 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: #ffffff;
        border: none !important;
        box-shadow: none !important;
    }

    .eyebrow {
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 12px;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 6px;
        animation: fadeIn 0.5s ease out 0.2s both;
    }

    .auth-card h1 {
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .muted {
        color: var(--text-muted);
        font-size: 15px;
        margin-bottom: 32px;
    }

    /* Input Styling & Interactive Animations */
    .field {
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
    }

    .field label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 8px;
        transition: color 0.2s;
    }

    .field:focus-within label {
        color: var(--primary-green);
    }

    .input {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: #f9fafb;
        box-sizing: border-box;
    }

    .input:focus {
        outline: none;
        border-color: var(--primary-green);
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        transform: translateY(-1px);
    }

    /* Custom Vibrant Action Buttons */
    .actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        align-items: center;
    }

    .button {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 14px 24px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        text-align: center;
    }

    .button[type="submit"] {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }

    .button[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
        filter: brightness(1.05);
    }

    .button.secondary {
        background: #ffffff;
        color: var(--text-main);
        border: 2px solid #e5e7eb;
    }

    .button.secondary:hover {
        background: #f9fafb;
        border-color: #d1d5db;
        transform: translateY(-2px);
    }

    /* Vibrant Seed Account Badge Panel */
    .empty.seed-badge-container {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border: 1px dashed var(--accent-gold);
        border-radius: 12px;
        padding: 14px 16px;
        color: #92400e;
        font-size: 13px;
        line-height: 1.5;
        font-family: monospace;
    }

    /* Structural CSS Keyframe Animations */
    @keyframes slideUpFade {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Mobile Responsive Adjustments */
    @media (max-width: 768px) {
        .agri-login-wrapper {
            flex-direction: column;
            margin: 10px;
        }
        .agri-visual-panel {
            min-height: 180px;
            padding: 24px;
        }
        .auth-card.card {
            padding: 32px 24px;
        }
        .actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="agri-login-wrapper">
    <!-- Left Hero Brand Column -->
    <div class="agri-visual-panel">
        <h2 class="panel-headline">Connecting Fields to Markets</h2>
        <p class="panel-sub">Empowering farmers and buyers across the nation with transparent, digital trading.</p>
    </div>

    <!-- Right Core Form Column (Preserved original attributes intact) -->
    <section class="auth-card card">
        <p class="eyebrow">Welcome back</p>
        <h1 style="font-size: 34px;">Login</h1>
        <p class="muted">Use your farmer or buyer account.</p>

        <form method="post" action="{{ route('login.store') }}">
            @csrf
            
            <div class="field">
                <label for="email">Email Address</label>
                <input class="input" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
            </div>
            
            <div class="field">
                <label for="password">Password</label>
                <input class="input" id="password" name="password" type="password" required placeholder="••••••••">
            </div>
            
            <div class="actions" style="margin-top: 18px;">
                <button class="button" type="submit">Login to Mandi</button>
                <a class="button secondary" href="{{ route('register') }}">Create Account</a>
            </div>
        </form>

 
        </div>
    </section>
</div>
@endsection