@extends('layouts.app')

@section('content')
    <style>
        /* ─── Layout ─────────────────────────────────────────────── */
        .dashboard-wrap {
            display: grid;
            gap: 28px;
        }

        /* ─── Hero welcome banner ────────────────────────────────── */
        .hero-card {
            background: linear-gradient(135deg, #064e3b 0%, #059669 60%, #34d399 100%);
            border-radius: 24px;
            padding: 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            flex-wrap: wrap;
            box-shadow: 0 20px 50px -10px rgba(5, 150, 105, 0.45);
            position: relative;
            overflow: hidden;
        }

        .hero-card::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 240px;
            height: 240px;
            background: rgba(255, 255, 255, 0.07);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-card::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: 30%;
            width: 320px;
            height: 320px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-left {
            display: flex;
            align-items: center;
            gap: 20px;
            position: relative;
            z-index: 1;
        }

        .hero-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            font-weight: 800;
            color: #ffffff;
            flex-shrink: 0;
            letter-spacing: -1px;
        }

        .hero-text h1 {
            margin: 0 0 4px;
            font-size: 26px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
        }

        .hero-text p {
            margin: 0;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.75);
        }

        .hero-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 999px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 600;
            color: #ffffff;
            margin-top: 8px;
            text-transform: capitalize;
        }

        .hero-role-badge svg {
            width: 14px;
            height: 14px;
            opacity: 0.9;
        }

        /* ─── Action buttons inside hero ─────────────────────────── */
        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .btn-hero-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            color: #059669;
            border: none;
            border-radius: 12px;
            padding: 11px 20px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .btn-hero-primary:hover {
            background: #f0fdf4;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-hero-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 12px;
            padding: 11px 20px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-hero-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .btn-hero-primary svg,
        .btn-hero-secondary svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        /* ─── Stats row ──────────────────────────────────────────── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 4px 16px -6px rgba(15, 23, 42, 0.08);
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }

        .stat-card:hover {
            box-shadow: 0 8px 24px -6px rgba(15, 23, 42, 0.14);
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon svg {
            width: 22px;
            height: 22px;
        }

        .stat-icon-green  { background: #d1fae5; color: #059669; }
        .stat-icon-blue   { background: #dbeafe; color: #2563eb; }
        .stat-icon-orange { background: #ffedd5; color: #ea580c; }

        .stat-info p {
            margin: 0;
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }

        .stat-info strong {
            display: block;
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.1;
            margin-bottom: 2px;
        }

        /* ─── Section header ─────────────────────────────────────── */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .section-title {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title svg {
            width: 20px;
            height: 20px;
            color: #059669;
        }

        .section-count-badge {
            background: #d1fae5;
            color: #065f46;
            border-radius: 999px;
            padding: 3px 10px;
            font-size: 12px;
            font-weight: 700;
        }

        /* ─── Signalements grid & cards ──────────────────────────── */
        .signalements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 18px;
        }

        .signalement-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            box-shadow: 0 4px 16px -6px rgba(15, 23, 42, 0.08);
            transition: box-shadow 0.25s ease, border-color 0.25s ease, transform 0.25s ease;
        }

        .signalement-card:hover {
            box-shadow: 0 12px 32px -8px rgba(5, 150, 105, 0.2);
            border-color: #6ee7b7;
            transform: translateY(-3px);
        }

        .card-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            width: fit-content;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.7;
        }

        .status-en_attente { background: #dbeafe; color: #1e40af; }
        .status-en_cours   { background: #ffedd5; color: #9a3412; }
        .status-resolu     { background: #dcfce7; color: #166534; }
        .status-rejete     { background: #fee2e2; color: #991b1b; }

        .owner-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            width: fit-content;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 700;
            background: #ecfeff;
            color: #155e75;
            border: 1px solid #a5f3fc;
        }

        .signalement-card h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            line-height: 1.4;
            color: #0f172a;
        }

        .signalement-meta {
            display: flex;
            flex-direction: column;
            gap: 6px;
            font-size: 13px;
            color: #64748b;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .meta-item svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
            color: #94a3b8;
        }

        .card-footer {
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid #f1f5f9;
        }

        .signalement-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            color: #059669;
            font-weight: 600;
            font-size: 13px;
            transition: gap 0.2s ease, color 0.2s ease;
        }

        .signalement-link svg {
            width: 14px;
            height: 14px;
            transition: transform 0.2s ease;
        }

        .signalement-link:hover {
            color: #047857;
        }

        .signalement-link:hover svg {
            transform: translateX(3px);
        }

        /* ─── Empty state ────────────────────────────────────────── */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 48px 24px;
            gap: 12px;
        }

        .empty-state-icon {
            width: 72px;
            height: 72px;
            background: #f0fdf4;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 4px;
        }

        .empty-state-icon svg {
            width: 36px;
            height: 36px;
            color: #6ee7b7;
        }

        .empty-state h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
        }

        .empty-state p {
            margin: 0;
            font-size: 14px;
            color: #64748b;
            max-width: 320px;
        }

        .btn-empty-cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #059669;
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 11px 22px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.35);
            margin-top: 4px;
        }

        .btn-empty-cta:hover {
            background: #047857;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(5, 150, 105, 0.35);
        }

        .btn-empty-cta svg {
            width: 16px;
            height: 16px;
        }
    </style>

    @php
        $userName    = $user->name ?? '';
        $initials    = collect(explode(' ', trim($userName)))->filter()->take(2)->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') ?: '?';
        $firstName   = collect(explode(' ', trim($userName)))->filter()->first() ?? 'User';
        $totalCount   = $user->hasRole('citoyen') ? $signalements->count() : 0;
        $resolvedCount = $user->hasRole('citoyen') ? $signalements->where('statut', 'resolu')->count() : 0;
        $pendingCount  = $user->hasRole('citoyen') ? $signalements->where('statut', 'en_attente')->count() : 0;
    @endphp

    <div class="dashboard-wrap">

        {{-- ── Hero Welcome Banner ─────────────────────────────────── --}}
        <div class="hero-card">
            <div class="hero-left">
                <div class="hero-avatar">{{ $initials }}</div>
                <div class="hero-text">
                    <h1>Welcome back, {{ $firstName }}!</h1>
                    <p>Here's what's happening with your reports today.</p>
                    <span class="hero-role-badge">
                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ $user->role?->name ?? 'No role' }}
                    </span>
                </div>
            </div>

            <div class="hero-actions">
                <a class="btn-hero-primary" href="{{ route('signalements.index') }}">
                    <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    All Signalements
                </a>
                @if ($user->hasRole('citoyen'))
                    <a class="btn-hero-secondary" href="{{ route('signalements.create') }}">
                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        New Report
                    </a>
                @endif
            </div>
        </div>

        {{-- ── Stats Row (citoyen only) ─────────────────────────────── --}}
        @if ($user->hasRole('citoyen'))
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon stat-icon-green">
                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="stat-info">
                        <strong>{{ $totalCount }}</strong>
                        <p>Total Reports</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-blue">
                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="stat-info">
                        <strong>{{ $pendingCount }}</strong>
                        <p>Pending</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-green">
                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="stat-info">
                        <strong>{{ $resolvedCount }}</strong>
                        <p>Resolved</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- ── Signalements Section (citoyen only) ─────────────────── --}}
        @if ($user->hasRole('citoyen'))
            <div class="card" style="padding: 32px;">
                <div class="section-header">
                    <h2 class="section-title">
                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        My Reports
                    </h2>
                    @if (!$signalements->isEmpty())
                        <span class="section-count-badge">{{ $totalCount }} total</span>
                    @endif
                </div>

                @if ($signalements->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3>No reports yet</h3>
                        <p>You haven't submitted any signalements. Start by creating your first report to help improve your city.</p>
                        <a class="btn-empty-cta" href="{{ route('signalements.create') }}">
                            <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Create your first report
                        </a>
                    </div>
                @else
                    <div class="signalements-grid">
                        @foreach ($signalements as $signalement)
                            <article class="signalement-card">
                                <div class="card-badges">
                                    <span class="status-badge status-{{ $signalement->statut }}">
                                        {{ str_replace('_', ' ', $signalement->statut) }}
                                    </span>
                                    @if ($signalement->citoyen_id === $user->id)
                                        <span class="owner-badge">✓ Yours</span>
                                    @endif
                                </div>

                                <h3>{{ $signalement->titre }}</h3>

                                <div class="signalement-meta">
                                    <div class="meta-item">
                                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M7 7h.01M7 3h5l5.5 5.5V21H7V3z" />
                                        </svg>
                                        {{ $signalement->category?->title ?? 'No category' }}
                                    </div>
                                    <div class="meta-item">
                                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $signalement->photos->count() }}
                                        {{ Str::plural('photo', $signalement->photos->count()) }}
                                    </div>
                                    <div class="meta-item">
                                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $signalement->created_at?->format('d M Y') }}
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <a class="signalement-link"
                                        href="{{ route('signalements.show', $signalement) }}">
                                        View details
                                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection
