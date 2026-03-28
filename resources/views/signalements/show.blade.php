@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 860px; margin: 0 auto;">
        <h1>{{ $signalement->titre }}</h1>
        <p class="muted">Submitted on {{ $signalement->date_signalement }}</p>

        <div class="grid" style="margin-top: 12px;">
            <div>
                <strong>Status:</strong> {{ $signalement->statut }}
            </div>
            <div>
                <strong>Category:</strong> {{ $signalement->category?->title }}
            </div>
            <div>
                <strong>Citoyen:</strong> {{ $signalement->citoyen?->name }}
            </div>
            <div>
                <strong>Location:</strong>
                {{ $signalement->localisation ?? 'Not specified' }}
            </div>
            <div>
                <strong>Assigned agent:</strong>
                {{ $signalement->agentMunicipal?->user?->name ?? 'Not assigned' }}
            </div>
            <div>
                <strong>Description</strong>
                <p>{{ $signalement->description }}</p>
            </div>

            @if ($signalement->photos->count() > 0)
                <div>
                    <strong>Images:</strong>
                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; margin-top: 8px;">
                        @foreach ($signalement->photos as $photo)
                            <div style="border: 1px solid #dbe2ea; border-radius: 8px; overflow: hidden;">
                                <img src="{{ asset('storage/' . $photo->path) }}" alt="Photo"
                                    style="width: 100%; height: 150px; object-fit: cover;">
                                <p class="muted" style="font-size: 12px; padding: 6px; margin: 0;">
                                    {{ $photo->uploaded_at->format('M d, Y') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="actions" style="margin-top: 12px;">
            <a href="{{ route('signalements.index') }}" class="btn btn-outline">Back</a>
        </div>
    </div>
@endsection
