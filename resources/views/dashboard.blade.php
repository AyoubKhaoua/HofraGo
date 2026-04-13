@extends('layouts.app')

@section('content')
    <style>
        .dashboard-wrap {
            display: grid;
            gap: 20px;
        }

        .dashboard-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 16px;
        }

        .dashboard-actions .btn {
            width: auto;
            text-decoration: none;
            padding: 10px 16px;
            font-size: 14px;
            border-radius: 10px;
        }

        .dashboard-actions .btn-secondary {
            background: #ffffff;
            color: #0f172a;
            border: 1px solid #e2e8f0;
            box-shadow: none;
        }

        .dashboard-actions .btn-secondary:hover {
            background: #f8fafc;
            transform: none;
            box-shadow: none;
        }

        .signalements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 16px;
        }

        .signalement-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px;
            display: grid;
            gap: 10px;
            box-shadow: 0 8px 24px -20px rgba(15, 23, 42, 0.4);
        }

        .signalement-card h3 {
            margin: 0;
            font-size: 18px;
            line-height: 1.35;
            color: #0f172a;
        }

        .signalement-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            font-size: 13px;
            color: #475569;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            width: fit-content;
            border-radius: 999px;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        .card-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .owner-badge {
            display: inline-flex;
            align-items: center;
            width: fit-content;
            border-radius: 999px;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: 700;
            background: #ecfeff;
            color: #155e75;
            border: 1px solid #a5f3fc;
        }

        .status-en_attente {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-en_cours {
            background: #ffedd5;
            color: #9a3412;
        }

        .status-resolu {
            background: #dcfce7;
            color: #166534;
        }

        .status-rejete {
            background: #fee2e2;
            color: #991b1b;
        }

        .signalement-link {
            text-decoration: none;
            color: #059669;
            font-weight: 600;
            font-size: 14px;
            width: fit-content;
        }

        .signalement-link:hover {
            text-decoration: underline;
        }
    </style>

    <div class="dashboard-wrap">
        <div class="card">
            <h1>Dashboard</h1>
            <p>Welcome, <strong>{{ $user->name }}</strong>.</p>
            <p class="muted">Role: {{ $user->role?->name ?? 'no role assigned' }}</p>

            <div class="dashboard-actions">
                <a class="btn" href="{{ route('signalements.index') }}">Open signalements</a>
                @if ($user->hasRole('citoyen'))
                    <a class="btn btn-secondary" href="{{ route('signalements.create') }}">Create signalement</a>
                @endif
            </div>
        </div>

        @if ($user->hasRole('citoyen'))
            <div class="card">
                <h2 style="margin-top: 0; margin-bottom: 16px;">All Signalements</h2>

                @if ($signalements->isEmpty())
                    <p class="muted" style="margin: 0;">No signalements found yet.</p>
                @else
                    <div class="signalements-grid">
                        @foreach ($signalements as $signalement)
                            <article class="signalement-card">
                                <div class="card-badges">
                                    <span class="status-badge status-{{ $signalement->statut }}">
                                        {{ str_replace('_', ' ', $signalement->statut) }}
                                    </span>
                                    @if ($signalement->citoyen_id === $user->id)
                                        <span class="owner-badge">Your signalement</span>
                                    @endif
                                </div>

                                <h3>{{ $signalement->titre }}</h3>

                                <div class="signalement-meta">
                                    <span>Category: {{ $signalement->category?->title ?? 'N/A' }}</span>
                                    <span>Photos: {{ $signalement->photos->count() }}</span>
                                    <span>Date: {{ $signalement->created_at?->format('d/m/Y H:i') }}</span>
                                </div>

                                <a class="signalement-link" href="{{ route('signalements.show', $signalement) }}">
                                    View details
                                </a>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection
