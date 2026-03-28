@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Dashboard</h1>
        <p>Welcome, <strong>{{ $user->name }}</strong>.</p>
        <p class="muted">Role: {{ $user->role?->name ?? 'no role assigned' }}</p>

        <div class="actions">
            <a class="btn" href="{{ route('signalements.index') }}">Open signalements</a>
            @if ($user->hasRole('citoyen'))
                <a class="btn btn-outline" href="{{ route('signalements.create') }}">Create signalement</a>
            @endif
        </div>
    </div>
@endsection
