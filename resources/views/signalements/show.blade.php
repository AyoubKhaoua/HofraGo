@extends('layouts.app')

@section('content')
    <style>
        .show-wrapper {
            padding: 40px 20px;
            background-color: #f9fafb;
            min-height: calc(100vh - 60px);
        }

        .container-lg {
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Header Area */
        .show-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .show-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.025em;
        }

        .muted-text {
            color: #6b7280;
            font-size: 14px;
            margin-top: 4px;
        }

        /* Layout Grid */
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 24px;
        }

        @media (max-width: 850px) {
            .details-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Cards */
        .card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 24px;
            margin-bottom: 24px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 12px;
        }

        /* Info List */
        .info-group {
            margin-bottom: 20px;
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 15px;
            color: #111827;
            font-weight: 500;
        }

        /* Badges */
        .badge {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-block;
        }

        .badge-status {
            background: #eff6ff;
            color: #1e40af;
            border: 1px solid #dbeafe;
        }

        /* Image Gallery */
        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 12px;
        }

        .image-item {
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            height: 120px;
            position: relative;
        }

        .image-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.2s;
        }

        .image-item:hover img {
            transform: scale(1.05);
        }

        /* History Table */
        .history-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .history-table th {
            text-align: left;
            padding: 10px;
            color: #6b7280;
            border-bottom: 1px solid #f3f4f6;
        }

        .history-table td {
            padding: 10px;
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
        }

        /* Buttons & Forms */
        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .btn-outline {
            background: #fff;
            border-color: #d1d5db;
            color: #374151;
        }

        .btn-outline:hover {
            background: #f9fafb;
        }

        .btn-primary {
            background: #2563eb;
            color: #fff;
        }

        .select-style {
            width: 100%;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            margin-bottom: 10px;
            outline: none;
        }
    </style>

    <div class="show-wrapper">
        <div class="container-lg">
            <!-- Header -->
            <div class="show-header">
                <div>
                    <h1>{{ $signalement->titre }}</h1>
                    <p class="muted-text">Signalement ID: #{{ $signalement->id }} • Créé le
                        {{ $signalement->date_signalement }}</p>
                </div>
                <a href="{{ route('signalements.index') }}" class="btn btn-outline">← Retour</a>
            </div>

            <div class="details-grid">
                <!-- Left Column: Main Info -->
                <div class="main-content">
                    <div class="card">
                        <div class="card-title">📄 Détails de la description</div>
                        <p style="line-height: 1.6; color: #4b5563; white-space: pre-line;">{{ $signalement->description }}
                        </p>

                        <div
                            style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 24px; padding-top: 20px; border-top: 1px solid #f3f4f6;">
                            <div class="info-group">
                                <div class="info-label">Catégorie</div>
                                <div class="info-value">{{ $signalement->category?->title ?? 'N/A' }}</div>
                            </div>
                            <div class="info-group">
                                <div class="info-label">Localisation</div>
                                <div class="info-value">📍 {{ $signalement->localisation ?? 'Non spécifiée' }}</div>
                            </div>
                        </div>
                    </div>

                    @if ($signalement->photos->count() > 0)
                        <div class="card">
                            <div class="card-title">📸 Photos jointes ({{ $signalement->photos->count() }})</div>
                            <div class="image-grid">
                                @foreach ($signalement->photos as $photo)
                                    <div class="image-item">
                                        <a href="{{ asset('storage/' . $photo->path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $photo->path) }}" alt="Photo"
                                                onerror="this.src='https://placehold.co/300x200?text=Image+Not+Found'">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-title">🕒 Historique des statuts</div>
                        @if ($historiqueStatuts->count() > 0)
                            <table class="history-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Ancien</th>
                                        <th>Nouveau</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($historiqueStatuts as $historique)
                                        <tr>
                                            <td>{{ $historique->date_changement }}</td>
                                            <td><span style="color: #9ca3af">{{ $historique->ancien_statut }}</span></td>
                                            <td><strong>{{ $historique->nouveau_statut }}</strong></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="muted-text">Aucun changement de statut enregistré.</p>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Sidebar Actions -->
                <div class="sidebar">
                    <div class="card" style="background: #f8fafc;">
                        <div class="card-title">Status Actuel</div>
                        <span class="badge badge-status"
                            style="font-size: 14px; padding: 6px 14px;">{{ $signalement->statut }}</span>

                        @if ($canUpdateStatus)
                            <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                                <div class="info-label" style="margin-bottom: 10px;">Mettre à jour le statut</div>
                                @if (count($nextStatuses) > 0)
                                    <form method="POST" action="{{ route('signalements.status.update', $signalement) }}">
                                        @csrf
                                        <select name="statut" class="select-style">
                                            @foreach ($nextStatuses as $nextStatus)
                                                <option value="{{ $nextStatus }}">{{ $nextStatus }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary" style="width: 100%;">Mettre à
                                            jour</button>
                                    </form>
                                @else
                                    <p class="muted-text">Aucun changement possible.</p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="card">
                        <div class="card-title">👤 Intervenants</div>
                        <div class="info-group">
                            <div class="info-label">Signalé par</div>
                            <div class="info-value">{{ $signalement->citoyen?->name ?? 'Citoyen Anonyme' }}</div>
                        </div>
                        <div class="info-group" style="margin-bottom: 0;">
                            <div class="info-label">Agent Assigné</div>
                            <div class="info-value"
                                style="color: {{ $signalement->agentMunicipal ? '#111827' : '#9ca3af' }}">
                                {{ $signalement->agentMunicipal?->user?->name ?? 'Non assigné' }}
                            </div>
                        </div>

                        @if ($canAssignAgent)
                            <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid #f3f4f6;">
                                <div class="info-label" style="margin-bottom: 10px;">Assigner un agent</div>
                                <form method="POST" action="{{ route('signalements.assign.agent', $signalement) }}">
                                    @csrf
                                    <select name="agent_municipal_id" class="select-style">
                                        <option value="">-- Non assigné --</option>
                                        @foreach ($agents as $agent)
                                            <option value="{{ $agent->id }}" @selected($signalement->agent_municipal_id === $agent->id)>
                                                {{ $agent->user?->name ?? 'Agent #' . $agent->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary" style="width: 100%;">Enregistrer
                                        l'assignation</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
