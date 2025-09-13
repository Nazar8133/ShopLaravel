@extends('layoutsAdmin.layoutAdmin', ['title'=>'Замовлення'])
@section('content')
    <style>
        .container{
            min-height: 150px;
        }
    </style>
    <blockquote class="blockquote text-center">
        <p class="h1 ">Замовлення</p>
    </blockquote>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Номер замовлення</th>
            <th scope="col">ID Покупця</th>
            <th scope="col">Статус оплати</th>
            <th scope="col">Статус замовлення</th>
            <th scope="col">Детальніше</th>
        </tr>
        </thead>
        <tbody class="table-group-divider">
        <?php $number=1; ?>
        @foreach($order as $tmp)
            <tr>
                <th scope="row">{{$number}}</th>
                <td>{{$tmp->numberOrder}}</td>
                <td>{{$tmp->idBuyer}}</td>
                <td>@if($tmp->paymentStatus==0) Оплата не пройшла @elseif($tmp->paymentStatus==1) Оплата успішна @else Ще не оплачено @endif</td>
                <td>@if($tmp->orderStatus==0) Замовлення скасовано @elseif($tmp->orderStatus==1) Замовлення оформлено @else Замовлення в обробці @endif</td>
                <td><a class="btn btn-warning" href="{{route('order.show', ['order'=>$tmp->idOrder])}}" role="button">Детальніше</a></td>
            </tr>
                <?php $number++; ?>
        @endforeach
        </tbody>
    </table>
    <br>
    {{$order->links()}}
@endsection

