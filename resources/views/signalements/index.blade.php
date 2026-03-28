@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap;">
            <div>
                <h1>Signalements</h1>
                <p class="muted">
                    @if ($user->hasRole('citoyen'))
                        You are viewing your own reports.
                    @elseif ($user->hasRole('admin'))
                        You are viewing all reports.
                    @else
                        You are viewing assigned reports.
                    @endif
                </p>
            </div>

            @if ($user->hasRole('citoyen'))
                <a class="btn" href="{{ route('signalements.create') }}">New signalement</a>
            @endif
        </div>

        <div style="margin-top: 12px; overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Category</th>
                        <th>Citoyen</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($signalements as $signalement)
                        <tr>
                            <td>{{ $signalement->titre }}</td>
                            <td>{{ $signalement->statut }}</td>
                            <td>{{ $signalement->category?->title }}</td>
                            <td>{{ $signalement->citoyen?->name }}</td>
                            <td>{{ $signalement->date_signalement }}</td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-outline" href="{{ route('signalements.show', $signalement) }}">View</a>

                                    @if ($user->hasRole('citoyen') && $signalement->citoyen_id === $user->id)
                                        <a class="btn btn-outline"
                                            href="{{ route('signalements.edit', $signalement) }}">Edit</a>

                                        <form method="POST" action="{{ route('signalements.destroy', $signalement) }}"
                                            class="inline-form" onsubmit="return confirm('Delete this signalement?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn"
                                                style="background: #b2292e; border-color: #b2292e;">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="muted">No signalements found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 12px;">
            {{ $signalements->links() }}
        </div>
    </div>
@endsection
