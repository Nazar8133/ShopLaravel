@extends('layouts.layoutUser', ['title'=>'Відновлення пароля'])
@section('content')
    <div class="card mx-auto mt-5" style="max-width: 400px;">
        <div class="card-body">
            <h4 class="card-title text-center mb-4">Відновлення пароля</h4>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{route('buyers.password.email')}}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Електронна пошта</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="d-grid">
                    <input type="submit" class="btn btn-primary" name="knopka" value="Надіслати посилання на відновлення">
                </div>
            </form>
        </div>
    </div>
    <br>
    <br>
@endsection
