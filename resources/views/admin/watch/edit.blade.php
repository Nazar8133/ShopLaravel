@extends('layoutsAdmin.layoutAdmin', ['title'=>'Редагування годинника'])
@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
    <blockquote class="blockquote text-center">
        <p class="h1 ">Редагування годинника</p>
    </blockquote>
    <form action="{{route('watch.update', ['watch'=>$watch->idWatch])}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="input-group mb-3">
            <input type="text" class="form-control" required placeholder="Назва годинника" aria-describedby="basic-addon1" name="name" value="{{$watch->name ?? old('name')}}">
        </div>

        <label>Редагуйте бренд годинника</label>
        <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="brend">
            @foreach($brend as $tmpBrend)
                <option value="{{$tmpBrend->idBrend}}" @if($tmpBrend->idBrend==$watch->idBrend) selected @endif>{{$tmpBrend->brend}}</option>
            @endforeach
        </select>

        <label>Редагуйте тип годинника</label>
        <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="mechanism">
            @foreach($mechanism as $tmpMechanism)
                <option value="{{$tmpMechanism->idMechanism}}" @if($tmpMechanism->idMechanism==$watch->idMech) selected @endif>{{$tmpMechanism->type}}
            @endforeach
        </select>

        <label>Виберіть для кого</label>
        <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="gender">
            @foreach($gender as $tmpGender)
                <option value="{{$tmpGender->idGender}}" @if($tmpGender->idGender==$watch->idGen) selected @endif>{{$tmpGender->gender}}</option>
            @endforeach
        </select>

        <label>Редагуйте стиль годинника</label>
        <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="style">
            @foreach($style as $tmpStyle)
                <option value="{{$tmpStyle->idStyle}}" @if($tmpStyle->idStyle==$watch->idStyle) selected @endif>{{$tmpStyle->style}}</option>
            @endforeach
        </select>

        <div class="input-group">
            <span class="input-group-text">Редагуйте повний опис</span>
            <textarea class="form-control" required name="discription" placeholder="Введіть повний опис годинника" aria-label="With textarea">{{$watch->discription ?? old('discription')}}</textarea>
        </div>
        <br>
        <div class="d-flex flex-wrap gap-2">
            @foreach($photo as $tmpPhoto)
                <div class="text-center">
                    <img src="{{$tmpPhoto->photo}}" class="rounded mx-auto d-block" height="100px">
                    <a class="btn btn-primary" href="{{route('photo.show', ['photo'=>$tmpPhoto->idPhoto])}}">Редагувати</a>
                </div>
            @endforeach
                <div class="text-left">
                    <a class="btn btn-primary" href="{{route('photo.showCreate', ['id'=>$watch->idWatch])}}" role="button">Додати фото</a>
                    <br>
                    <br>
                    <a class="btn btn-danger" href="{{route('photo.showAll', ['id'=>$watch->idWatch])}}" role="button">Видалити всі фото</a>
                </div>
        </div>



        <br>

        <div class="input-group mb-3">
            <span class="input-group-text">₴</span>
            <input type="text" name="price" required class="form-control" placeholder="Ціна" value="{{$watch->price ?? old('price')}}">
            <span class="input-group-text">.00</span>
        </div>

        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupFile01">Редагуйте кількість</label>
            <input type="number" name="kolvo" required class="form-control" placeholder="Кількість" value="{{$watch->kolvo ?? old('kolvo')}}">
        </div>

        <input class="btn btn-outline-primary" type="submit" name="knopka" value="Редагувати">
        <br>
    </form>
    <br>
@endsection
