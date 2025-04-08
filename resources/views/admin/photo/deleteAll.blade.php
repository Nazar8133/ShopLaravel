@extends('layoutsAdmin.layoutAdmin', ['title'=>'Видалення всіх фото'])
@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
    <blockquote class="blockquote text-center">
        <p class="h1 ">Ви дійсно хочете видалити всі ці фото?</p>
    </blockquote>
    <div class="d-flex flex-wrap gap-2">
        @foreach($photo as $tmpPhoto)
                <img src="{{$tmpPhoto}}" class="rounded mx-auto d-block" height="200px">
        @endforeach
    </div>
    <br>
    <div class="text-center">
    <form action="{{route('photo.destroyAll', ['id'=>$idWatch])}}" method="post" onsubmit="if(confirm('Впевнені?')){ return true }else{ return false }">
        @csrf
        @method('DELETE')
        <input type="submit" name="knopka" class="btn btn-danger" value="Видалити">
    </form>
    </div>
@endsection
