@extends('layouts.layoutUser', ['title'=>'Відновлення пароля'])
@section('content')
    <div class="card mx-auto mt-5" style="max-width: 800px;">
        <div class="card-body row justify-content-center">
            <div class="col-md-6">

                <h3 class="mb-4">Скидання пароля</h3>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('buyers.password.update') }}">
                    @csrf
                    {{-- Пароль --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Новий пароль</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror @error('email') is-invalid @enderror"
                               name="password" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Підтвердження пароля --}}
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">Підтвердіть пароль</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                    <input type="hidden" name="token" value="{{$token}}">
                    <input type="hidden" name="email" value="{{request('email')}}">
                    {{-- Кнопка --}}
                    <div class="d-grid">
                        <input type="submit" class="btn btn-primary" name="knopka" value="Скинути пароль">
                    </div>

                </form>

            </div>
        </div>
    </div>
    <br>
@endsection
