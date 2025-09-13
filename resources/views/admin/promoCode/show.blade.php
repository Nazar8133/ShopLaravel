@extends('layoutsAdmin.layoutAdmin', ['title'=>'Всі промокоди'])
@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
    <blockquote class="blockquote text-center">
        <p class="h1 ">Всі Промокоди</p>
    </blockquote>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Промокод</th>
            <th scope="col">Залишилось використань</th>
            <th scope="col">Відсоток знижки</th>
            <th scope="col">Дата початку</th>
            <th scope="col">Дата кінця</th>
            <th scope="col">Редагування</th>
            <th scope="col">Видалення</th>
        </tr>
        </thead>
        <tbody class="table-group-divider">
        <?php $number=1; ?>
        @foreach($promoCode as $tmp)
            <tr>
                <th scope="row">{{$number}}</th>
                <td>{{$tmp->code}}</td>
                <td>{{$tmp->codeAmount}}</td>
                <td>{{$tmp->discountValue}}</td>
                <td>{{$tmp->dateStart}}</td>
                <td>{{$tmp->dateEnd}}</td>
                <td><a class="btn btn-warning" href="{{route('promoCode.edit', ['promoCode'=>$tmp->idPromoCode])}}" role="button">Редагувати</a></td>
                <td><form action="{{route('promoCode.destroy', ['promoCode'=>$tmp->idPromoCode])}}" method="post" onsubmit="if(confirm('Точно хочете видалити цей промокод?')){ return true; }else{ return false; }">
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

