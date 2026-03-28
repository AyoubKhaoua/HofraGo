@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 760px; margin: 0 auto;">
        <h1>Edit signalement</h1>

        <form method="POST" action="{{ route('signalements.update', $signalement) }}" class="grid">
            @csrf
            @method('PUT')

            <div>
                <label for="titre">Title</label>
                <input id="titre" name="titre" type="text" value="{{ old('titre', $signalement->titre) }}" required>
            </div>

            <div>
                <label for="description">Description</label>
                <textarea id="description" name="description" required>{{ old('description', $signalement->description) }}</textarea>
            </div>

            <div>
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $signalement->category_id) == $category->id)>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="localisation">Location (address or coordinates)</label>
                <input id="localisation" name="localisation" type="text"
                    value="{{ old('localisation', $signalement->localisation) }}"
                    placeholder="e.g., 123 Main Street or 48.8566,2.3522">
            </div>

            <div class="actions">
                <button type="submit" class="btn">Save changes</button>
                <a href="{{ route('signalements.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
@endsection
