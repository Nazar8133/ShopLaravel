@extends('layoutsAdmin.layoutAdmin', ['title'=>'Редагування бренду'])
@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
    <blockquote class="blockquote text-center">
        <p class="h1 ">Редагування бренда</p>
    </blockquote>
    <form action="{{route('brend.update', ['brend'=>$brend->idBrend])}}" method="post">
        @csrf
        @method('PATCH')
        <div class="input-group mb-3">
            <input type="text" class="form-control" required placeholder="Назва Бренду" aria-describedby="basic-addon1" name="brend" value="{{old('brend') ?? $brend->brend}}">
        </div>

        <br>
        <input class="btn btn-outline-primary" type="submit" name="knopka" value="Редагувати">
    </form>
    <br>
@endsection
