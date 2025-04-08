@extends('layoutsAdmin.layoutAdmin', ['title'=>'Редагування типу годинника'])
@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
    <blockquote class="blockquote text-center">
        <p class="h1 ">Редагування бренда</p>
    </blockquote>
    <form action="{{route('mechanism.update', ['mechanism'=>$mechanism->idMechanism])}}" method="post">
        @csrf
        @method('PATCH')
        <div class="input-group mb-3">
            <input type="text" class="form-control" required placeholder="Назва Типу Годинника" aria-describedby="basic-addon1" name="type" value="{{old('type') ?? $mechanism->type}}">
        </div>

        <br>
        <input class="btn btn-outline-primary" type="submit" name="knopka" value="Редагувати">
    </form>
    <br>
@endsection
