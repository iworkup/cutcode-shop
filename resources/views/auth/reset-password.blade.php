@extends('layouts.auth')

@section('title', 'Сброс пароля')

@section('content')

    <x-forms.auth-forms title="Сброс пароля" action="{{ route('reset.handle') }}" method="POST">

        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <x-forms.text-input
            name="email"
            type="email"
            placeholder="Почта"
            required="true"
            value="{{ request('email') }}"
            :isError="$errors->has('email')"
        ></x-forms.text-input>

        @error('email')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.text-input
            :isError="$errors->has('password')"
            name="password"
            type="password"
            placeholder="Пароль"
            required="true"
        ></x-forms.text-input>

        @error('password')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.text-input
            :isError="$errors->has('password_confirmation')"
            name="password_confirmation"
            type="password"
            placeholder="Повторите пароль"
            required="true"
        ></x-forms.text-input>

        @error('password_confirmation')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.primary-button>Сбросить</x-forms.primary-button>

        <x-slot:socialAuth></x-slot:socialAuth>

        <x-slot:recRegLinks>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs">
                    <a href="{{ route('login') }}" class="text-white hover:text-white/70 font-bold">Вспомнил пароль</a>
                </div>
            </div>
        </x-slot:recRegLinks>

    </x-forms.auth-forms>

@endsection
