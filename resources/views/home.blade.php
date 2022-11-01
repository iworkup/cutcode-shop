@extends('layouts.auth')


@if($message = flash()->get())
    <div class="text-center py-16 lg:py-20 {{ $message->class() }}">
        {{ $message->message() }}
    </div>
@endif

@section('content')

    @auth

        <form method="post" action="{{ route('logout') }}">
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
            <a href="{{ route('forgot') }}">Recovery pass</a>
        </p>
    @endguest

@endsection
