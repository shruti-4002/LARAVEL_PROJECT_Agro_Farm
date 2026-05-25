<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>@yield('title', 'AgriMandi')</title>
    <style>
        :root {
            --bg: #f6f5ef;
            --surface: #ffffff;
            --surface-2: #f0f5ee;
            --ink: #1d2b23;
            --muted: #66736b;
            --line: #dfe5dc;
            --primary: #236b45;
            --primary-2: #174d33;
            --accent: #d6942d;
            --blue: #2e6f8f;
            --danger: #a43f3f;
            --shadow: 0 18px 45px rgba(29, 43, 35, .09);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            color: var(--ink);
            background: var(--bg);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            line-height: 1.5;
        }

        a { color: inherit; text-decoration: none; }
        button, input, select, textarea { font: inherit; }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            background: rgba(246, 245, 239, .93);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(14px);
        }

        .nav {
            max-width: 1180px;
            min-height: 70px;
            margin: 0 auto;
            padding: 0 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            letter-spacing: 0;
        }

        .brand-mark {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: grid;
            place-items: center;
            color: white;
            font-size: 17px;
            font-weight: 900;
        }

        .nav-links {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            flex-wrap: wrap;
        }

        .nav-link {
            padding: 9px 12px;
            border-radius: 8px;
            color: var(--muted);
            font-size: 14px;
            font-weight: 700;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--ink);
            background: var(--surface-2);
        }

        .page {
            max-width: 1180px;
            margin: 0 auto;
            padding: 30px 22px 54px;
        }

        .page-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 18px;
            margin-bottom: 22px;
        }

        .eyebrow {
            color: var(--primary);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin: 0 0 6px;
        }

        h1, h2, h3, p { margin-top: 0; }
        h1 { margin-bottom: 8px; font-size: clamp(32px, 5vw, 58px); line-height: 1.02; letter-spacing: 0; }
        h2 { margin-bottom: 14px; font-size: 24px; letter-spacing: 0; }
        h3 { margin-bottom: 8px; font-size: 17px; letter-spacing: 0; }

        .muted { color: var(--muted); }

        .hero {
            min-height: calc(100vh - 120px);
            display: grid;
            align-items: center;
            grid-template-columns: minmax(0, 1.05fr) minmax(320px, .95fr);
            gap: 30px;
        }

        .hero-panel {
            position: relative;
            min-height: 470px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
            background:
                linear-gradient(rgba(22, 43, 32, .2), rgba(22, 43, 32, .62)),
                url("https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=1400&q=80") center/cover;
        }

        .hero-panel-content {
            position: absolute;
            inset: auto 24px 24px 24px;
            color: white;
        }

        .hero-actions, .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .card, .product-card, .table-wrap {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 8px;
            box-shadow: 0 12px 30px rgba(29, 43, 35, .06);
        }

        .card { padding: 22px; }
        .auth-card { max-width: 470px; margin: 38px auto; }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 42px;
            padding: 10px 15px;
            border: 1px solid transparent;
            border-radius: 8px;
            background: var(--primary);
            color: white;
            cursor: pointer;
            font-weight: 800;
            line-height: 1.2;
        }

        .button:hover { background: var(--primary-2); }
        .button.secondary { background: var(--surface); color: var(--ink); border-color: var(--line); }
        .button.secondary:hover { background: var(--surface-2); }
        .button.accent { background: var(--accent); color: #201306; }
        .button.small { min-height: 36px; padding: 8px 11px; font-size: 13px; }

        .field { display: grid; gap: 7px; margin-bottom: 14px; }
        .field label { font-size: 13px; font-weight: 800; color: #32443a; }

        .input, .select, .textarea {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fffef9;
            color: var(--ink);
            padding: 11px 12px;
            outline: none;
        }

        .textarea { min-height: 120px; resize: vertical; }
        .input:focus, .select:focus, .textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(35, 107, 69, .14);
        }

        .grid { display: grid; gap: 16px; }
        .grid.two { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid.three { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid.four { grid-template-columns: repeat(4, minmax(0, 1fr)); }

        .product-card { padding: 18px; display: grid; gap: 13px; }
        .product-meta { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }

        .pill {
            display: inline-flex;
            align-items: center;
            min-height: 27px;
            padding: 4px 9px;
            border-radius: 999px;
            background: var(--surface-2);
            color: #33483d;
            font-size: 12px;
            font-weight: 800;
        }

        .pill.blue { color: var(--blue); background: #e8f2f5; }
        .pill.gold { color: #7a4a00; background: #fff0ce; }
        .price { font-size: 27px; font-weight: 900; color: var(--primary-2); }

        .stat {
            padding: 18px;
            border-radius: 8px;
            background: var(--surface);
            border: 1px solid var(--line);
        }

        .stat-value { font-size: 30px; line-height: 1; font-weight: 900; margin-bottom: 7px; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 680px; }
        th, td { text-align: left; padding: 13px 14px; border-bottom: 1px solid var(--line); vertical-align: middle; }
        th { color: #415247; font-size: 12px; text-transform: uppercase; letter-spacing: .05em; }
        tr:last-child td { border-bottom: 0; }

        .alert {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 8px;
            border: 1px solid var(--line);
            background: #edf7ef;
            color: #244831;
            font-weight: 700;
        }

        .alert.error { background: #fff1ee; color: var(--danger); border-color: #f2c8bf; }

        .bar-row { display: grid; grid-template-columns: 120px 1fr 100px; align-items: center; gap: 12px; margin: 12px 0; }
        .bar-track { height: 13px; background: var(--surface-2); border-radius: 999px; overflow: hidden; }
        .bar-fill { height: 100%; min-width: 5px; background: linear-gradient(90deg, var(--primary), var(--accent)); }
        .split { display: grid; grid-template-columns: minmax(0, 1fr) 360px; gap: 16px; align-items: start; }
        .chat-list { display: grid; gap: 10px; margin-bottom: 16px; }
        .bubble { max-width: 82%; padding: 12px 14px; border-radius: 8px; background: var(--surface-2); white-space: pre-wrap; }
        .bubble.farmer { margin-left: auto; background: #e8f2f5; }
        .bubble.advisor { margin-right: auto; }
        .empty { padding: 22px; border: 1px dashed #c9d4cc; border-radius: 8px; color: var(--muted); background: rgba(255, 255, 255, .55); }

        @media (max-width: 900px) {
            .hero, .grid.two, .grid.three, .grid.four, .split { grid-template-columns: 1fr; }
            .hero { min-height: auto; }
            .hero-panel { min-height: 320px; }
            .page-head, .nav { align-items: flex-start; flex-direction: column; }
            .nav-links { justify-content: flex-start; }
            .bar-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    @php($currentUser = session('user'))
    <header class="topbar">
        <nav class="nav">
            <a class="brand" href="{{ route('home') }}">
                <span class="brand-mark">A</span>
                <span>AgriMandi</span>
            </a>
            <div class="nav-links">
                @if($currentUser)
                    @if($currentUser['role'] === 'farmer')
                        <a class="nav-link {{ request()->routeIs('farmer.marketplace') ? 'active' : '' }}" href="{{ route('farmer.marketplace') }}">Market</a>
                        <a class="nav-link {{ request()->routeIs('farmer.products.create') ? 'active' : '' }}" href="{{ route('farmer.products.create') }}">Add Product</a>
                        <a class="nav-link {{ request()->routeIs('farmer.dashboard') ? 'active' : '' }}" href="{{ route('farmer.dashboard') }}">Dashboard</a>
                        <a class="nav-link {{ request()->routeIs('farmer.advisor') ? 'active' : '' }}" href="{{ route('farmer.advisor') }}">Advisor</a>
                    @else
                        <a class="nav-link {{ request()->routeIs('buyer.marketplace') ? 'active' : '' }}" href="{{ route('buyer.marketplace') }}">Crops</a>
                    @endif
                    <span class="pill">{{ ucfirst($currentUser['role']) }}: {{ $currentUser['name'] }}</span>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="button secondary small" type="submit">Logout</button>
                    </form>
                @else
                    <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                    <a class="button small" href="{{ route('register') }}">Register</a>
                @endif
            </div>
        </nav>
    </header>

    <main class="page">
        @include('partials.flash')
        @yield('content')
    </main>
</body>
</html>
