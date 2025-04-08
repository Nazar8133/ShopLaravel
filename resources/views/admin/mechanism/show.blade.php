@extends('layoutsAdmin.layoutAdmin', ['title'=>'Всі типи годинників'])
@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
    <blockquote class="blockquote text-center">
        <p class="h1 ">Всі типи</p>
    </blockquote>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Тип годинника</th>
            <th scope="col">Редагування</th>
            <th scope="col">Видалення</th>
        </tr>
        </thead>
        <tbody class="table-group-divider">
        <?php $number=1; ?>
        @foreach($mechanism as $tmp)
            <tr>
                <th scope="row">{{$number}}</th>
                <td>{{$tmp->type}}</td>
                <td><a class="btn btn-warning" href="{{route('mechanism.edit', ['mechanism'=>$tmp->idMechanism])}}" role="button">Редагувати</a></td>
                <td><form action="{{route('mechanism.destroy', ['mechanism'=>$tmp->idMechanism])}}" method="post" onsubmit="if(confirm('Точно хочете видалити цей тип годинника?')){ return true; }else{ return false; }">
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
