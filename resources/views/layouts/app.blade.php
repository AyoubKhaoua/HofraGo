<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} </title>
    <!-- زدنا خط Inter العصري -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <style>
        :root {
            --bg: #f8fafc;
            --card: #ffffff;
            --line: #e2e8f0;
            --text: #0f172a;
            --muted: #64748b;
            --accent: #059669;
            /* الأخضر الزمردي */
            --accent-hover: #047857;
            --danger: #ef4444;
            --success: #10b981;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Inter", system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
        }

        .container {
            width: min(1000px, 92vw);
            margin: 0 auto;
        }

        /* Navbar العصرية */
        .topbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
        }

        body.auth-page .topbar {
            background: rgba(248, 250, 252, 0.92);
            border-bottom-color: rgba(148, 163, 184, 0.25);
        }

        body.auth-page .topbar-inner {
            padding: 12px 0;
        }

        .brand {
            font-weight: 800;
            font-size: 24px;
            color: var(--accent);
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .nav {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav a,
        .nav button {
            background: transparent;
            border: none;
            color: var(--muted);
            font-weight: 500;
            text-decoration: none;
            font-size: 15px;
            padding: 8px 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: color 0.2s, background-color 0.2s;
        }

        .nav a:hover,
        .nav button:hover {
            color: var(--accent);
            background: rgba(5, 150, 105, 0.08);
        }

        body.auth-page .nav {
            gap: 12px;
        }

        body.auth-page .nav a,
        body.auth-page .nav button {
            border: 1px solid rgba(148, 163, 184, 0.25);
            padding: 8px 14px;
            border-radius: 999px;
        }

        body.auth-page .nav a:hover,
        body.auth-page .nav button:hover {
            border-color: rgba(5, 150, 105, 0.35);
            background: rgba(5, 150, 105, 0.06);
        }

        .page {
            padding: 60px 0;
            min-height: calc(100vh - 70px);
            display: flex;
            flex-direction: column;
        }

        /* ستايل البطاقة (Card) بحال Dribbble */
        .card {
            background: var(--card);
            border-radius: 24px;
            /* حواف دائرية بزاف */
            padding: 40px;
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .card h1 {
            margin-top: 0;
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .grid {
            display: grid;
            gap: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
            color: var(--text);
        }

        /* ستايل inputs المطرقين */
        input,
        textarea,
        select {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 14px 16px;
            font: inherit;
            background: #f8fafc;
            color: var(--text);
            transition: all 0.2s ease;
            outline: none;
        }

        input:focus,
        textarea:focus {
            background: white;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
            /* ضو أخضر فاش كتكليكي */
        }

        /* ستايل البوطون (Button) الواعر */
        .btn {
            display: inline-block;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px 24px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px 0 rgba(5, 150, 105, 0.39);
            /* ضل أخضر لتحت */
            width: 100%;
        }

        .btn:hover {
            background: var(--accent-hover);
            transform: translateY(-2px);
            /* كتهز شوية ملي كتدوز عليها لاسوري */
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.23);
        }

        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--accent);
            cursor: pointer;
        }

        .muted {
            color: var(--muted);
            font-size: 15px;
        }

        .inline-form {
            display: inline;
        }
    </style>
</head>

<body class="{{ request()->routeIs('login.form', 'register.form') ? 'auth-page' : '' }}">
    <header class="topbar">
        <div class="container topbar-inner">
            <a href="{{ route('home') }}" class="brand">HofraGo</a>
            <nav class="nav">
                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="{{ route('signalements.index') }}">Signalements</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline-form">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @else
                    @if (request()->routeIs('login.form'))
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ route('register.form') }}">Register</a>
                    @elseif (request()->routeIs('register.form'))
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ route('login.form') }}">Login</a>
                    @else
                        <a href="{{ route('login.form') }}">Login</a>
                        <a href="{{ route('register.form') }}">Register</a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    <main class="page">
        <div class="container">
            @yield('content')
        </div>
    </main>
</body>

</html>
