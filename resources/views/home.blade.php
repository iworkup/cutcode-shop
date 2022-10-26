@extends('layouts.auth')

@section('content')

    @auth

        <form method="post" action="{{ route('logOut') }}">
            @csrf
            @method('DELETE')
            <button type="submit">Выйти</button>
        </form>

    @endauth

    @guest
        <p>
            <a href="{{ route('login') }}">Login</a> | <a href="{{ route('reg') }}">Reg</a>
        </p>
        <p>
            <a href="{{ route('password.request') }}">Recovery pass</a>
        </p>
    @endguest

@endsection
