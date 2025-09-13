@extends('layouts.layoutUser', ['title'=>'Підтвердження пошти'])
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                @if (session('succes'))
                    <div class="alert alert-success" role="alert">
                        {{session('succes')}}
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4>Підтвердження електронної пошти</h4>
                    </div>
                    <div class="card-body">
                        <p>Будь ласка, перевірте вашу електронну пошту і натисніть на посилання для підтвердження адреси.</p>
                        <p>Якщо ви не отримали листа, натисніть кнопку нижче, щоб надіслати його повторно.</p>

                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                Відправити лист повторно
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
