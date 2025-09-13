@extends('layoutsAdmin.layoutAdmin', ['title'=>'Добавлення годинників'])
@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
    <blockquote class="blockquote text-center">
        <p class="h1 ">Додати годинник</p>
    </blockquote>
    <form action="{{route('watch.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="input-group mb-3">
            <input type="text" class="form-control" required placeholder="Назва годинника" aria-describedby="basic-addon1" name="name" value="{{old('name') ?? ''}}">
        </div>

        <label>Виберіть бренд годинника</label>
        <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="brend">
            @foreach($brend as $tmpBrend)
            <option value="{{$tmpBrend->idBrend}}">{{$tmpBrend->brend}}</option>
            @endforeach
        </select>

        <label>Виберіть тип годинника</label>
        <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="mechanism">
            @foreach($mechanism as $tmpMechanism)
            <option value="{{$tmpMechanism->idMechanism}}">{{$tmpMechanism->type}}
            @endforeach
        </select>

        <label>Виберіть для кого</label>
        <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="gender">
            @foreach($gender as $tmpGender)
            <option value="{{$tmpGender->idGender}}">{{$tmpGender->gender}}</option>
            @endforeach
        </select>

        <label>Виберіть стиль годинника</label>
        <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="style">
            @foreach($style as $tmpStyle)
                <option value="{{$tmpStyle->idStyle}}">{{$tmpStyle->style}}</option>
            @endforeach
        </select>

        <div class="input-group">
            <span class="input-group-text">Повний опис</span>
            <textarea class="form-control" required name="discription" placeholder="Введіть повний опис годинника" aria-label="With textarea">{{old('discription') ?? ''}}</textarea>
        </div>
        <br>
        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupFile01">Фото годинника</label>
            <input type="file" name="photo[]" class="form-control" id="inputGroupFile01" multiple>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">₴</span>
            <input type="text" name="price" required class="form-control" placeholder="Ціна" value="{{old('price') ?? ''}}">
            <span class="input-group-text">.00</span>
        </div>

        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupFile01">Кількість годинників</label>
            <input type="number" name="kolvo" required class="form-control" placeholder="Кількість" value="{{old('kolvo') ?? ''}}">
        </div>

        <input class="btn btn-outline-primary" type="submit" name="knopka" value="Додати">

    </form>
    <br>
@endsection
