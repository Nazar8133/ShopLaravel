@extends('layoutsAdmin.layoutAdmin', ['title'=>'Помилка'])

@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Увага!') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Ви вже залогінені!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
