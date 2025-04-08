@extends('layoutsAdmin.layoutAdmin', ['title'=>'Редагування фотографії'])
@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
    <blockquote class="blockquote text-center">
        <p class="h1 ">Редагування фотографії</p>
    </blockquote>
    <div class="card mb-3">
        <img src="{{$photo->photo}}" class="rounded mx-auto d-block" alt="..." height="350px">
        <br>
        <div class="d-flex flex-wrap gap-2">
            <div class="text-center">
                <a class="btn btn-primary" href="{{route('watch.edit', ['watch'=>$photo->idWatch])}}" role="button">Назад</a>
            </div>
            @if($photo->status==0)
            <div class="text-center">
                <a class="btn btn-warning" href="{{route('photo.edit', ['photo'=>$photo->idPhoto])}}" role="button">Зробити головною</a>
            </div>
            @endif
            <div class="text-center">
                <form action="{{route('photo.destroy', ['photo'=>$photo->idPhoto])}}" method="post" onsubmit="if(confirm('Точно хочете видалити це фото?')){ return true }else{ return false }">
                    @csrf
                    @method('DELETE')
                    <input type="submit" name="knopka" class="btn btn-danger" value="Видалити">
                </form>
            </div>
        </div>
    </div>
@endsection
