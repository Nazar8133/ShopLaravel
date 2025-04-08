@extends('layoutsAdmin.layoutAdmin', ['title'=>'Всі стилі годинників'])
@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
    <blockquote class="blockquote text-center">
        <p class="h1 ">Всі стилі</p>
    </blockquote>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Стиль годинника</th>
            <th scope="col">Редагування</th>
            <th scope="col">Видалення</th>
        </tr>
        </thead>
        <tbody class="table-group-divider">
        <?php $number=1; ?>
        @foreach($style as $tmp)
            <tr>
                <th scope="row">{{$number}}</th>
                <td>{{$tmp->style}}</td>
                <td><a class="btn btn-warning" href="{{route('style.edit', ['style'=>$tmp->idStyle])}}" role="button">Редагувати</a></td>
                <td><form action="{{route('style.destroy', ['style'=>$tmp->idStyle])}}" method="post" onsubmit="if(confirm('Точно хочете видалити цей стиль годинника?')){ return true; }else{ return false; }">
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
