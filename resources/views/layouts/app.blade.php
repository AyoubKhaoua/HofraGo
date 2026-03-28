<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} </title>
    <style>
        :root {
            --bg: #f4f7fb;
            --card: #ffffff;
            --line: #dbe2ea;
            --text: #122033;
            --muted: #556579;
            --accent: #0f6cbf;
            --danger: #b2292e;
            --success: #247a3d;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .container {
            width: min(1000px, 92vw);
            margin: 0 auto;
        }

        .topbar {
            border-bottom: 1px solid var(--line);
            background: var(--card);
        }

        .topbar-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 14px 0;
        }

        .brand {
            font-weight: 700;
            color: var(--accent);
            text-decoration: none;
        }

        .nav {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .nav a,
        .nav button {
            border: 1px solid var(--line);
            background: white;
            color: var(--text);
            text-decoration: none;
            border-radius: 8px;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 14px;
        }

        .nav button {
            font-family: inherit;
        }

        .page {
            padding: 22px 0 28px;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 16px;
        }

        .grid {
            display: grid;
            gap: 14px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
        }

        input,
        textarea,
        select {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 10px;
            font: inherit;
            background: white;
        }

        textarea {
            min-height: 110px;
        }

        .btn {
            display: inline-block;
            border: 1px solid var(--accent);
            background: var(--accent);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            padding: 10px 14px;
            cursor: pointer;
            font: inherit;
        }

        .btn-outline {
            background: white;
            color: var(--accent);
        }

        .flash {
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 12px;
        }

        .flash-success {
            border: 1px solid #a8d5b5;
            background: #e9f7ee;
            color: var(--success);
        }

        .flash-error {
            border: 1px solid #e3b3b5;
            background: #faebeb;
            color: var(--danger);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            border-bottom: 1px solid var(--line);
            text-align: left;
            padding: 10px;
            vertical-align: top;
        }

        th {
            background: #eef3f8;
        }

        .muted {
            color: var(--muted);
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .inline-form {
            display: inline;
        }
    </style>
</head>

<body>
    <header class="topbar">
        <div class="container topbar-inner">
            <a href="{{ route('home') }}" class="brand">Hofrago </a>
            <nav class="nav">
                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="{{ route('signalements.index') }}">Signalements</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline-form">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login.form') }}">Login</a>
                    <a href="{{ route('register.form') }}">Register</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="page">
        <div class="container">
            @if (session('success'))
                <div class="flash flash-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="flash flash-error">
                    <strong>Please fix these errors:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>

</html>
