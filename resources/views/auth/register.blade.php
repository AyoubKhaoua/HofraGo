@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 540px; margin: 0 auto;">
        <h1>Register</h1>
        <p class="muted">New users are registered with citoyen role.</p>

        <form method="POST" action="{{ route('register') }}" class="grid">
            @csrf

            <div>
                <label for="name">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required>
            </div>

            <div>
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
            </div>

            <div>
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
            </div>

            <div>
                <label for="password_confirmation">Confirm password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required>
            </div>

            <button type="submit" class="btn">Create account</button>
        </form>
    </div>
@endsection
