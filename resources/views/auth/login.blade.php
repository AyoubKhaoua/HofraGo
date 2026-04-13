@extends('layouts.app')

@section('content')
    <style>
        /* كيحيد الفراغات باش الصفحة تاخد الشاشة كاملة */
        .page {
            padding: 0 !important;
        }

        .container {
            width: 100% !important;
            max-width: 100% !important;
        }

        .login-wrapper {
            display: flex;
            min-height: calc(100vh - 70px);
            background: var(--bg);
            /* نفس لون الخلفية باش يجي داكشي مندمج */
        }

        /* الجهة ديال التصويرة */
        .login-image {
            flex: 1;
            background-image: url('{{ asset('images/dark-street.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            display: none;
        }

        @media (min-width: 768px) {
            .login-image {
                display: block;
            }
        }

        /* 🔥 هاد الكود هو السّر! كيدير ضبابة وتدرج (Fade) فالجهة اليمنية ديال التصويرة باش تندمج مع الفورمولير 🔥 */
        .login-image::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 40%;
            /* العرض ديال التدرج */
            background: linear-gradient(to right, transparent, var(--bg));
            pointer-events: none;
            z-index: 2;
        }

        /* الظل الكحل لتحت باش يبان التيكست الأبيض واضح */
        .login-image-overlay {
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

        .login-image-overlay h2 {
            font-size: 48px;
            font-weight: 800;
            margin: 0 0 8px 0;
            letter-spacing: -1px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .login-image-overlay p {
            font-size: 18px;
            opacity: 0.9;
            margin: 0;
            max-width: 400px;
            line-height: 1.5;
        }

        /* الجهة ديال الفورمولير */
        .login-form-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: var(--bg);
            position: relative;
            z-index: 3;
        }

        /* حيدنا المربع والظل باش يبان الفورمولير مسرح فاباج */
        .login-card {
            width: 100%;
            max-width: 380px;
            background: transparent;
            /* خلفية شفافة باش يندمج 100% */
        }
    </style>

    <div class="login-wrapper">
        <!-- جهة التصويرة (اليسار) -->
        <div class="login-image">
            <div class="login-image-overlay">
                <h2>HofraGo</h2>
                <p>Signalez les problèmes de votre ville et contribuez à un environnement meilleur.</p>
            </div>
        </div>

        <!-- جهة تسجيل الدخول (اليمين) -->
        <div class="login-form-container">
            <div class="login-card">
                <h1 style="font-size: 36px; margin-bottom: 8px;">Login</h1>
                <p class="muted" style="margin-bottom: 36px; font-size: 16px;">Welcome back! Please enter your details.</p>

                <form method="POST" action="{{ route('login') }}" class="grid">
                    @csrf

                    <div>
                        <label for="email">Email Address</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}"
                            placeholder="name@example.com" required autofocus>
                    </div>

                    <div>
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" placeholder="••••••••" required>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 4px;">
                        <label
                            style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 500; margin: 0;">
                            <input type="checkbox" name="remember" value="1" style="width: auto; margin: 0;"> Remember
                            me
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                style="color: var(--accent); text-decoration: none; font-size: 14px; font-weight: 600;">Forgot
                                password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn" style="margin-top: 20px; font-size: 16px; padding: 14px;">Sign
                        in</button>
                </form>

                @if (Route::has('register'))
                    <p style="text-align: center; margin-top: 32px; font-size: 15px; color: var(--muted);">
                        Don't have an account?
                        <a href="{{ route('register') }}"
                            style="color: var(--accent); font-weight: 700; text-decoration: none;">Sign up</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
