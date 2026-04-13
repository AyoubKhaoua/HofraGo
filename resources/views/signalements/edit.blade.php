@extends('layouts.app')

@section('content')
    <style>
        .edit-wrapper {
            padding: 40px 20px;
            background-color: #f9fafb;
            min-height: calc(100vh - 60px);
        }

        .form-card {
            background: #ffffff;
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .form-card h1 {
            margin-top: 0;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: 700;
            color: #111827;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .field-group label {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
        }

        .input-style {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.2s;
            box-sizing: border-box;
        }

        .input-style:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Existing Images Section */
        .existing-images {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 12px;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .image-badge {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            font-size: 10px;
            text-align: center;
            padding: 2px 0;
        }

        /* New Preview Styling */
        .preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 12px;
            margin-top: 10px;
        }

        .preview-item {
            position: relative;
            width: 100px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .delete-btn {
            position: absolute;
            top: 4px;
            right: 4px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 12px;
        }

        .btn-group {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 30px;
            border-top: 1px solid #f3f4f6;
            padding-top: 25px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: 0.2s;
        }

        .btn-submit {
            background-color: #2563eb;
            color: white;
        }

        .btn-outline {
            background-color: white;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .muted-text {
            font-size: 13px;
            color: #6b7280;
        }
    </style>

    <div class="edit-wrapper">
        <div class="form-card">
            <h1>Modifier le Signalement #{{ $signalement->id }}</h1>

            <form id="edit-form" method="POST" action="{{ route('signalements.update', $signalement) }}"
                enctype="multipart/form-data" class="form-grid">
                @csrf
                @method('PUT')

                <div class="field-group">
                    <label for="titre">Titre</label>
                    <input id="titre" name="titre" type="text" class="input-style"
                        value="{{ old('titre', $signalement->titre) }}" required>
                </div>

                <div class="field-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="input-style" required>{{ old('description', $signalement->description) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="field-group">
                        <label for="category_id">Catégorie</label>
                        <select id="category_id" name="category_id" class="input-style" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $signalement->category_id) == $category->id)>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                </div>

                <div class="field-group">
                    <label for="localisation">Localisation</label>
                    <input id="localisation" name="localisation" type="text" class="input-style"
                        value="{{ old('localisation', $signalement->localisation) }}">
                    <div style="margin-top: 5px;">
                        <button type="button" id="btn-use-location" class="btn btn-outline"
                            style="padding: 5px 10px; font-size: 12px;">📍 Update Location</button>
                        <span id="location-status" class="muted-text"></span>
                    </div>
                </div>

                <!-- Existing Photos -->
                @if ($signalement->photos->count() > 0)
                    <div class="field-group">
                        <label>Photos actuelles</label>
                        <div class="existing-images">
                            @foreach ($signalement->photos as $photo)
                                <div class="preview-item">
                                    <img src="{{ asset('storage/' . $photo->path) }}">
                                    <div class="image-badge">Current</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Add New Photos -->
                <div class="field-group">
                    <label for="images">Ajouter de nouvelles photos</label>
                    <input id="images" name="images[]" type="file" class="input-style" accept="image/*" multiple>
                    <p class="muted-text">Les nouvelles photos seront ajoutées à la liste existante.</p>
                    <div id="image-preview" class="preview-container"></div>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-submit">Enregistrer les modifications</button>
                    <a href="{{ route('signalements.show', $signalement) }}" class="btn btn-outline">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function() {
            // Image Preview Logic
            const input = document.getElementById('images');
            const preview = document.getElementById('image-preview');
            let filesArray = [];

            input.addEventListener('change', function() {
                const newFiles = Array.from(input.files);
                filesArray = [...filesArray, ...newFiles];
                renderPreviews();
                updateInputFiles();
            });

            function renderPreviews() {
                preview.innerHTML = '';
                filesArray.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'preview-item';
                        div.innerHTML = `
                        <img src="${e.target.result}">
                        <button type="button" class="delete-btn" data-index="${index}">×</button>
                    `;
                        preview.appendChild(div);
                        div.querySelector('.delete-btn').addEventListener('click', () => removeFile(index));
                    }
                    reader.readAsDataURL(file);
                });
            }

            function removeFile(index) {
                filesArray.splice(index, 1);
                renderPreviews();
                updateInputFiles();
            }

            function updateInputFiles() {
                const dataTransfer = new DataTransfer();
                filesArray.forEach(file => dataTransfer.items.add(file));
                input.files = dataTransfer.files;
            }

            // Geolocation Logic
            const locBtn = document.getElementById('btn-use-location');
            const locInput = document.getElementById('localisation');
            const locStatus = document.getElementById('location-status');

            locBtn.addEventListener('click', function() {
                if (!navigator.geolocation) return;
                locStatus.textContent = 'Fetching...';
                navigator.geolocation.getCurrentPosition(pos => {
                    locInput.value =
                        `${pos.coords.latitude.toFixed(6)},${pos.coords.longitude.toFixed(6)}`;
                    locStatus.textContent = '✓ Updated';
                }, () => locStatus.textContent = 'Error');
            });
        })();
    </script>
@endsection
