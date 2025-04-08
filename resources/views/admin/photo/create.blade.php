@extends('layoutsAdmin.layoutAdmin', ['title'=>'Добавлення фотографії'])
@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
    <blockquote class="blockquote text-center">
        <p class="h1 ">Додати фотографію</p>
    </blockquote>
    <form action="{{route('photo.addDb', ['idWatch'=>$idWatch])}}" method="post" enctype="multipart/form-data">
        @csrf
    <div class="mb-3">
        <label for="formFileMultiple" class="form-label">Виберіть одну або декілька фото</label>
        <input class="form-control" type="file" id="formFileMultiple" name="photo[]" multiple>
    </div>

    <br>
    <input class="btn btn-outline-primary" type="submit" name="knopka" value="Додати">
    </form>
@endsection
