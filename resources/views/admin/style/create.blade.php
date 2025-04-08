@extends('layoutsAdmin.layoutAdmin', ['title'=>'Додати стиль'])
@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
    <blockquote class="blockquote text-center">
        <p class="h1 ">Додати стиль годинника</p>
    </blockquote>
    <form action="{{route('style.store')}}" method="post">
        @csrf
        <div class="input-group mb-3">
            <input type="text" class="form-control" required placeholder="Стиль годинника" aria-describedby="basic-addon1" name="style" value="{{old('style') ?? ''}}">
        </div>

        <br>
        <input class="btn btn-outline-primary" type="submit" name="knopka" value="Додати">
    </form>
    <br>
@endsection
