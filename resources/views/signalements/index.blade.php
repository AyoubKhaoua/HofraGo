@extends('layouts.app')

@section('content')
    <style>
        .signalements-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: var(--spacing-lg, 20px);
            color: var(--text-main, #333);
        }

        .signalements-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-xl, 30px);
        }

        .signalements-header h1 {
            margin: 0;
            font-size: 1.8rem;
            color: var(--heading-color, #222);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: var(--border-radius-sm, 6px);
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: opacity 0.2s ease, transform 0.1s ease;
            font-size: 0.9rem;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn:active {
            transform: translateY(1px);
        }

        .btn-primary {
            background-color: var(--primary-color, #0d6efd);
            color: var(--white, #ffffff);
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 0.8rem;
        }

        .btn-info {
            background-color: var(--info-color, #17a2b8);
            color: white;
        }

        .btn-warning {
            background-color: var(--warning-color, #ffc107);
            color: #000;
        }

        .btn-danger {
            background-color: var(--danger-color, #dc3545);
            color: white;
        }

        .signalements-card {
            background: var(--bg-card, #ffffff);
            border-radius: var(--border-radius-md, 8px);
            box-shadow: var(--shadow-sm, 0 2px 4px rgba(0, 0, 0, 0.05));
            border: 1px solid var(--border-color, #e0e0e0);
            overflow: hidden;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .signalements-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .signalements-table thead th {
            background-color: var(--bg-light, #f8f9fa);
            padding: 12px 16px;
            font-weight: 600;
            border-bottom: 2px solid var(--border-color, #e0e0e0);
            color: var(--text-muted, #6c757d);
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .signalements-table tbody td {
            padding: 16px;
            border-bottom: 1px solid var(--border-color, #e0e0e0);
            vertical-align: middle;
        }

        .signalements-table tbody tr:last-child td {
            border-bottom: none;
        }

        .signalements-table tbody tr:hover {
            background-color: var(--bg-hover, #f8f9fa);
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-nouveau {
            background-color: var(--nouveau-bg, #e3f2fd);
            color: var(--nouveau-text, #0d47a1);
        }

        .badge-en_cours {
            background-color: var(--encours-bg, #fff3e0);
            color: var(--encours-text, #e65100);
        }

        .badge-resolu {
            background-color: var(--resolu-bg, #e8f5e9);
            color: var(--resolu-text, #1b5e20);
        }

        .badge-rejete {
            background-color: #fce8e8;
            color: #8b1e1e;
        }

        .actions-group {
            display: flex;
            gap: 8px;
        }

        .actions-group form {
            margin: 0;
        }
    </style>

    <div class="signalements-container">
        <div class="signalements-header">
            <h1>Liste des Signalements</h1>
            <a href="{{ route('signalements.create') }}" class="btn btn-primary">
                + Nouveau signalement
            </a>
        </div>

        {{--     @if (session('success'))
            <div class="alert alert-success"
                style="padding: 12px; margin-bottom: 20px; background: #d4edda; color: #155724; border-radius: 6px;">
                {{ session('success') }}
            </div>
        @endif --}}

        <div class="signalements-card">
            <div class="table-responsive">
                <table class="signalements-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($signalements as $signalement)
                            <tr>
                                <td>#{{ $signalement->id }}</td>
                                <td><strong>{{ $signalement->titre }}</strong></td>
                                <td>{{ $signalement->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @php
                                        $badgeClass = match ($signalement->statut) {
                                            'en_attente' => 'badge-nouveau',
                                            'en_cours' => 'badge-en_cours',
                                            'resolu' => 'badge-resolu',
                                            'rejete' => 'badge-rejete',
                                            default => 'badge-nouveau',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ str_replace('_', ' ', $signalement->statut) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="actions-group">
                                        <a href="{{ route('signalements.show', $signalement->id) }}"
                                            class="btn btn-sm btn-info" title="Voir">
                                            Voir
                                        </a>
                                        <a href="{{ route('signalements.edit', $signalement->id) }}"
                                            class="btn btn-sm btn-warning" title="Modifier">
                                            Modifier
                                        </a>
                                        <form action="{{ route('signalements.destroy', $signalement->id) }}" method="POST"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce signalement ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    style="text-align: center; padding: 30px; color: var(--text-muted, #6c757d);">
                                    Aucun signalement trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
