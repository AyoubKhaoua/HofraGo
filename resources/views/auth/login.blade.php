@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 460px; margin: 0 auto;">
        <h1>Login</h1>
        <p class="muted">Use your account to access .</p>

        <form method="POST" action="{{ route('login') }}" class="grid">
            @csrf

            <div>
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
            </div>

            <div>
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
            </div>

            <label>
                <input type="checkbox" name="remember" value="1" style="width: auto;"> Remember me
            </label>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>
@endsection
