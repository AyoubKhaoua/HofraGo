@extends('layouts.app')

@section('content')
    <style>
        .page {
            padding: 0 !important;
        }

        .container {
            width: 100% !important;
            max-width: 100% !important;
        }

        .register-wrapper {
            display: flex;
            min-height: calc(100vh - 70px);
            background: var(--bg);
        }

        .register-image {
            flex: 1;
            background-image: url('{{ asset('images/eclirageCasse.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            display: none;
        }

        @media (min-width: 768px) {
            .register-image {
                display: block;
            }
        }

        .register-image::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 40%;
            background: linear-gradient(to right, transparent, var(--bg));
            pointer-events: none;
            z-index: 2;
        }

        .register-image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 40%, rgba(0, 0, 0, 0.8));
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 60px;
            color: white;
            z-index: 1;
        }

        .register-image-overlay h2 {
            font-size: 48px;
            font-weight: 800;
            margin: 0 0 8px 0;
            letter-spacing: -1px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .register-image-overlay p {
            font-size: 18px;
            opacity: 0.9;
            margin: 0;
            max-width: 420px;
            line-height: 1.5;
        }

        .register-form-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: var(--bg);
            position: relative;
            z-index: 3;
        }

        .register-card {
            width: 100%;
            max-width: 420px;
            background: transparent;
        }
    </style>

    <div class="register-wrapper">
        <div class="register-image">
            <div class="register-image-overlay">
                <h2>HofraGo</h2>
                <p>Créez votre compte et commencez à signaler les problèmes de votre quartier.</p>
            </div>
        </div>

        <div class="register-form-container">
            <div class="register-card">
                <h1 style="font-size: 36px; margin-bottom: 8px;">Register</h1>
                <p class="muted" style="margin-bottom: 36px; font-size: 16px;">Create your account in seconds.</p>

                <form method="POST" action="{{ route('register') }}" class="grid">
                    @csrf

                    <div>
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}"
                            placeholder="Your full name" required>
                    </div>

                    <div>
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}"
                            placeholder="name@example.com" required>
                    </div>

                    <div>
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" placeholder="••••••••" required>
                    </div>

                    <div>
                        <label for="password_confirmation">Confirm password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn" style="margin-top: 20px; font-size: 16px; padding: 14px;">Create
                        account</button>
                </form>

                <p style="text-align: center; margin-top: 32px; font-size: 15px; color: var(--muted);">
                    Already have an account?
                    <a href="{{ route('login.form') }}"
                        style="color: var(--accent); font-weight: 700; text-decoration: none;">Sign
                        in</a>
                </p>
            </div>
        </div>
    </div>
@endsection
