@extends('layoutsAdmin.layoutAdmin', ['title'=>'Редагування стилю'])
@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
    <blockquote class="blockquote text-center">
        <p class="h1 ">Редагування стилю</p>
    </blockquote>
    <form action="{{route('style.update', ['style'=>$style->idStyle])}}" method="post">
        @csrf
        @method('PATCH')
        <div class="input-group mb-3">
            <input type="text" class="form-control" required placeholder="Назва Стилю Годинника" aria-describedby="basic-addon1" name="style" value="{{old('style') ?? $style->style}}">
        </div>

        <br>
        <input class="btn btn-outline-primary" type="submit" name="knopka" value="Редагувати">
    </form>
    <br>
@endsection
