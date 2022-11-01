@extends('layouts.auth')

@section('title', 'Восстановление доступа')

@section('content')

    <x-forms.auth-forms title="Восстановление доступа" action="{{ route('forgot.handle') }}" method="POST">

        @csrf

        <x-forms.text-input
            name="email"
            type="email"
            placeholder="Почта"
            required="true"
            value="{{ old('email') }}"
            :isError="$errors->has('email')"
        ></x-forms.text-input>

        @error('email')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.primary-button>Восстановить</x-forms.primary-button>

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
