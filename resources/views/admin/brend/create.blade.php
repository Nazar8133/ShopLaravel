@extends('layoutsAdmin.layoutAdmin', ['title'=>'Добавлення брендів'])
@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
    <blockquote class="blockquote text-center">
        <p class="h1 ">Додання брендів</p>
    </blockquote>
    <form action="{{route('brend.store')}}" method="post">
        @csrf
        <div class="input-group mb-3">
            <input type="text" class="form-control" required placeholder="Назва Бренду" aria-describedby="basic-addon1" name="brend" value="{{old('brend') ?? ''}}">
        </div>

        <br>
        <input class="btn btn-outline-primary" type="submit" name="knopka" value="Додати">
    </form>
    <br>
@endsection
