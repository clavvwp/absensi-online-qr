@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="card" style="max-width: 400px; margin: 35px auto;">
        <h1>Login</h1>
        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>

            <p><button type="submit">Masuk</button></p>
        </form>
    </div>
@endsection
