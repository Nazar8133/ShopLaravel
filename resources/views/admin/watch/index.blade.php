@extends('layoutsAdmin.layoutAdmin', ['title'=>'Всі годинники'])
@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
    <blockquote class="blockquote text-center">
        <p class="h1 ">Всі годинники</p>
    </blockquote>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Назва годинника</th>
            <th scope="col">Механізм</th>
            <th scope="col">Фото</th>
            <th scope="col">Редагувати</th>
            <th scope="col">Видалити</th>
        </tr>
        </thead>
        <tbody class="table-group-divider">
        <?php $number=1; ?>
        @foreach($watch as $tmp)
            <tr>
                <th scope="row">{{$number}}</th>
                <td>{{$tmp->name}}</td>
                <td>{{$tmp->mechanism}}</td>
                <td><img src="{{$tmp->photo ?? asset('img/noPhoto.jpg')}}" class="rounded mx-auto d-block" alt="..." height="100px"></td>
                <td><a class="btn btn-warning" href="{{route('watch.edit', ['watch'=>$tmp->idWatch])}}" role="button">Редагувати</a></td>
                <td><form action="{{route('watch.destroy', ['watch'=>$tmp->idWatch])}}" method="post" onsubmit="if(confirm('Точно хочете видалити цей годинник?')){ return true; }else{ return false; }">
                        @csrf
                        @method('DELETE')
                        <input name="knopka" type="submit" class="btn btn-danger" value="Видалити">
                    </form></td>
            </tr>
                <?php $number++; ?>
        @endforeach
        </tbody>
    </table>
@endsection
