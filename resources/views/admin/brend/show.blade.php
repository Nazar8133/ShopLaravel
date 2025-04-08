@extends('layoutsAdmin.layoutAdmin', ['title'=>'Бренди'])
@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
    <blockquote class="blockquote text-center">
        <p class="h1 ">Всі бренди</p>
    </blockquote>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Назва бренду</th>
            <th scope="col">Редагування</th>
            <th scope="col">Видалення</th>
        </tr>
        </thead>
        <tbody class="table-group-divider">
        <?php $number=1; ?>
        @foreach($brend as $tmp)
        <tr>
            <th scope="row">{{$number}}</th>
            <td>{{$tmp->brend}}</td>
            <td><a class="btn btn-warning" href="{{route('brend.edit', ['brend'=>$tmp->idBrend])}}" role="button">Редагувати</a></td>
            <td><form action="{{route('brend.destroy', ['brend'=>$tmp->idBrend])}}" method="post" onsubmit="if(confirm('Точно хочете видалити цей бренд?')){ return true; }else{ return false; }">
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
