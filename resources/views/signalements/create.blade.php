@extends('layouts.app')

@section('content')
    <style>
        .create-wrapper {
            padding: 40px 20px;
            background-color: #f9fafb;
            min-height: calc(100vh - 60px);
        }

        .form-card {
            background: #ffffff;
            max-width: 760px;
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

        /* Image Preview Styling */
        .preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 12px;
            margin-top: 15px;
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
            background: rgba(255, 0, 0, 0.8);
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .btn-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            border: none;
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

    <div class="create-wrapper">
        <div class="form-card">
            <h1>Create Signalement</h1>

            <form id="signalement-form" method="POST" action="{{ route('signalements.store') }}" enctype="multipart/form-data"
                class="form-grid">
                @csrf

                <div class="field-group">
                    <label for="titre">Title</label>
                    <input id="titre" name="titre" type="text" class="input-style" value="{{ old('titre') }}"
                        required>
                </div>

                <div class="field-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="input-style" required>{{ old('description') }}</textarea>
                </div>

                <div class="field-group">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" class="input-style" required>
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field-group">
                    <label for="localisation">Location</label>
                    <input id="localisation" name="localisation" type="text" class="input-style"
                        value="{{ old('localisation') }}">
                    <div style="margin-top: 5px;">
                        <button type="button" id="btn-use-location" class="btn btn-outline"
                            style="padding: 5px 10px; font-size: 12px;">📍 Use Location</button>
                        <span id="location-status" class="muted-text"></span>
                    </div>
                </div>

                <div class="field-group">
                    <label for="images">Images</label>
                    <input id="images" name="images[]" type="file" class="input-style" accept="image/*" multiple>
                    <p class="muted-text">Select multiple images to preview them below.</p>
                    <!-- Preview Area -->
                    <div id="image-preview" class="preview-container"></div>
                </div>

                <div class="btn-group" style="margin-top: 20px; border-top: 1px solid #f3f4f6; padding-top: 25px;">
                    <button type="submit" class="btn btn-submit">Create Signalement</button>
                    <a href="{{ route('signalements.index') }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function() {
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

                        div.querySelector('.delete-btn').addEventListener('click', function() {
                            removeFile(index);
                        });
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

            // Location Logic
            const locBtn = document.getElementById('btn-use-location');
            const locInput = document.getElementById('localisation');
            const locStatus = document.getElementById('location-status');

            locBtn.addEventListener('click', function() {
                if (!navigator.geolocation) return;
                locStatus.textContent = 'Getting location...';
                navigator.geolocation.getCurrentPosition(pos => {
                    locInput.value =
                        `${pos.coords.latitude.toFixed(6)},${pos.coords.longitude.toFixed(6)}`;
                    locStatus.textContent = '✓ Done';
                }, () => locStatus.textContent = 'Error');
            });
        })();
    </script>
@endsection
