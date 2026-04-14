@extends('layouts.app')

@section('content')
    <style>
        .profile-wrap {
            max-width: 760px;
            margin: 0 auto;
            padding: 12px;
            background: linear-gradient(180deg, #fff7fb 0%, #fff1f7 100%);
        }

        .profile-card {
            background: #fff;
            border: 1px solid #f6d7e7;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 14px 30px rgba(236, 72, 153, 0.12);
        }

        .profile-header {
            height: 100px;
            background: linear-gradient(135deg, #e91e63 0%, #ff4f9a 100%);
            position: relative;
        }

        .avatar {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            border: 5px solid #fff;
            background: #f3f4f6;
            position: absolute;
            left: 24px;
            bottom: -44px;
            overflow: hidden;
            display: grid;
            place-items: center;
            font-size: 30px;
            color: #9ca3af;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-body {
            padding: 58px 24px 24px;
        }

        .profile-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 18px;
        }

        .profile-name {
            margin: 0;
            font-size: 34px;
            line-height: 1;
            letter-spacing: -0.02em;
            text-transform: lowercase;
            font-weight: 800;
            color: #111827;
        }

        .profile-role {
            margin-top: 6px;
            color: #6b7280;
            font-size: 14px;
        }

        .btn-edit {
            border: none;
            background: linear-gradient(135deg, #ec4899 0%, #ff5ba5 100%);
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            padding: 10px 18px;
            cursor: pointer;
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #db2777 0%, #f43f8f 100%);
        }

        .member-tag {
            display: inline-block;
            margin-top: 10px;
            color: #6b7280;
            font-size: 13px;
        }

        .separator {
            border: 0;
            border-top: 1px solid #efefef;
            margin: 18px 0;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .field-full {
            grid-column: 1 / -1;
        }

        .field-label {
            display: block;
            color: #4b5563;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .field-input {
            width: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #f9fafb;
            padding: 11px 12px;
            font-size: 14px;
            color: #111827;
        }

        .field-input:focus {
            outline: none;
            border-color: #e91e63;
            box-shadow: 0 0 0 4px rgba(233, 30, 99, 0.14);
            background: #fff;
        }

        .danger-zone {
            margin-top: 16px;
            border-top: 1px solid #f7d7d7;
            padding-top: 16px;
        }

        .danger-title {
            margin: 0;
            color: #dc2626;
            font-size: 22px;
            font-weight: 800;
        }

        .danger-text {
            color: #6b7280;
            margin: 8px 0 14px;
            font-size: 14px;
        }

        .btn-danger {
            border: none;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #fff;
            border-radius: 8px;
            font-weight: 700;
            padding: 11px 16px;
            cursor: pointer;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        }

        .alert {
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 14px;
            font-size: 14px;
        }

        .alert-success {
            background: #ecfdf5;
            border: 1px solid #10b981;
            color: #065f46;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #ef4444;
            color: #7f1d1d;
        }

        @media (max-width: 700px) {
            .profile-name {
                font-size: 28px;
            }

            .profile-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="profile-wrap">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="profile-card">
            <div class="profile-header">
                <div class="avatar">
                    @if (!empty($user->avatar_url))
                        <img src="{{ $user->avatar_url }}" alt="avatar">
                    @else
                        <span>{{ strtoupper(substr($firstName ?: $user->name, 0, 1)) }}</span>
                    @endif
                </div>
            </div>

            <div class="profile-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="profile-top">
                        <div>
                            <h1 class="profile-name">{{ strtolower($user->name) }}</h1>
                            <div class="profile-role">{{ $user->role?->name ?? 'Utilisateur' }}</div>
                            <span class="member-tag">Membre</span>
                        </div>
                        <button class="btn-edit" type="submit">Modifier</button>
                    </div>

                    <hr class="separator">

                    <div class="profile-grid">
                        <div>
                            <label class="field-label" for="first_name">Prenom</label>
                            <input class="field-input" id="first_name" name="first_name" type="text"
                                value="{{ old('first_name', $firstName) }}" required>
                        </div>

                        <div>
                            <label class="field-label" for="last_name">Nom</label>
                            <input class="field-input" id="last_name" name="last_name" type="text"
                                value="{{ old('last_name', $lastName) }}">
                        </div>

                        <div class="field-full">
                            <label class="field-label" for="email">Email</label>
                            <input class="field-input" id="email" name="email" type="email"
                                value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="field-full">
                            <label class="field-label" for="phone">Telephone</label>
                            <input class="field-input" id="phone" name="phone" type="text"
                                value="{{ old('phone', $user->phone) }}">
                        </div>

                        <div class="field-full">
                            <label class="field-label" for="localisation">Localisation</label>
                            <input class="field-input" id="localisation" name="localisation" type="text"
                                value="{{ old('localisation', $user->localisation) }}">
                        </div>

                        <div class="field-full">
                            <label class="field-label" for="biography">Biographie</label>
                            <textarea class="field-input" id="biography" name="biography" rows="3">{{ old('biography', $user->biography) }}</textarea>
                        </div>
                    </div>
                </form>

                <div class="danger-zone">
                    <h2 class="danger-title">Zone de danger</h2>
                    <p class="danger-text">
                        Supprimer votre compte est une action irreversible. Toutes vos donnees seront definitivement
                        supprimees.
                    </p>
                    <form method="POST" action="{{ route('profile.destroy') }}"
                        onsubmit="return confirm('Confirmer la suppression de votre compte ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">Supprimer mon compte</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
