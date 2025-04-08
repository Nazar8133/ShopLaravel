@extends('layoutsAdmin.layoutAdmin', ['title'=>'Добавлення типа годинника'])
@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
    <blockquote class="blockquote text-center">
        <p class="h1 ">Додати тип годинника</p>
    </blockquote>
    <form action="{{route('mechanism.store')}}" method="post">
        @csrf
        <div class="input-group mb-3">
            <input type="text" class="form-control" required placeholder="Тип годинника" aria-describedby="basic-addon1" name="type" value="{{old('type') ?? ''}}">
        </div>

        <br>
        <input class="btn btn-outline-primary" type="submit" name="knopka" value="Додати">
    </form>
    <br>
@endsection
