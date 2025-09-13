@extends('layoutsAdmin.layoutAdmin', ['title'=>'Деталі замовлення'])

@section('content')
    <style>
        .container{
            min-height: 150px;
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .img-watch {
            max-width: 120px;
            border-radius: 10px;
        }
    </style>

    <blockquote class="blockquote text-center">
        <p class="h1">Деталі замовлення №{{$order->numberOrder}}</p>
    </blockquote>

    {{-- Інформація про замовлення --}}
    <div class="card mb-4 shadow-sm mx-auto" style="max-width: 1000px;">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Інформація про замовлення</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th scope="row">ID замовлення</th>
                    <td>{{$order->idOrder}}</td>
                </tr>
                <tr>
                    <th scope="row">Номер замовлення</th>
                    <td>{{$order->numberOrder}}</td>
                </tr>
                <tr>
                    <th scope="row">ID Покупця</th>
                    <td><a class="text-decoration-none fw-bold"
                           data-bs-toggle="collapse"
                           role="button"
                           href="#buyerInfo"
                           aria-expanded="false"
                           aria-controls="buyerInfo">{{$order->idBuyer}}</a>
                        <div class="collapse mt-3" id="buyerInfo">
                            <div class="card card-body text-start bg-light mx-auto" style="max-width: 500px;">
                                <p><strong>ПІБ:</strong> {{$buyer['pib']}}</p>
                                <p><strong>Номер телефону:</strong> {{$buyer['number']}}</p>
                                <p><strong>Електронна пошта:</strong> {{$buyer['email']}}</p>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Доставка</th>
                    <td>
                        @if($order->delivery=='nova_post')
                            <a class="text-decoration-none fw-bold"
                               data-bs-toggle="collapse"
                               role="button"
                               href="#deliveryInfo"
                               aria-expanded="false"
                               aria-controls="deliveryInfo">Нова Пошта</a>
                            <div class="collapse mt-3" id="deliveryInfo">
                                <div class="card card-body text-start bg-light mx-auto" style="max-width: 500px;">
                                    <p><strong>Місто:</strong> {{$deliveryAddress->city}}</p>
                                    <p><strong>Відділення:</strong> {{$deliveryAddress->warehouse}}</p>
                                </div>
                            </div>
                        @elseif($order->delivery=='pickup')
                            Самовивіз
                        @else
                            <a class="text-decoration-none fw-bold"
                               data-bs-toggle="collapse"
                               role="button"
                               href="#deliveryInfo"
                               aria-expanded="false"
                               aria-controls="deliveryInfo">Курєром за адресою доставки</a>
                                <div class="collapse mt-3" id="deliveryInfo">
                                    <div class="card card-body text-start bg-light">
                                        <p><strong>Адреса доставки:</strong> {{$deliveryAddress->region.' '.$deliveryAddress->city.' '.$deliveryAddress->street}} {{$deliveryAddress->houseNumber ?? $deliveryAddress->apartmentNumber}}</p>
                                    </div>
                                </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row">ID Оплати</th>
                    <td>{{$order->idPayment ?? '—'}}</td>
                </tr>
                <tr>
                    <th scope="row">Оплата</th>
                    <td>@if($order->payment=='cash')
                            Готівкою при отриманні
                        @elseif($order->payment=='liqPay')
                            Платіжною системою LiqPay <a class="text-decoration-none fw-bold" href="{{route('order.paymentInfo', ['numberOrder'=>$order->numberOrder])}}">Детальніше</a>
                        @else
                            Платіжною системою GooglePay
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row">Статус оплати</th>
                    <td>
                        @if($order->paymentStatus==0)
                            Оплата не пройшла
                        @elseif($order->paymentStatus==1)
                            Оплата успішна
                        @else
                            Ще не оплачено
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row">Коментар</th>
                    <td>{{$order->koment ?? '—'}}</td>
                </tr>
                <tr>
                    <th scope="row">Статус замовлення</th>
                    <td>
                        <a class="text-decoration-none fw-bold" href="#" data-bs-toggle="modal" data-bs-target="#changeOrderStatusModal">
                            @if($order->orderStatus==0)
                                Замовлення скасовано
                            @elseif($order->orderStatus==1)
                                Замовлення оформлено
                            @else
                                Замовлення в обробці
                            @endif
                        </a>
                    </td>
                    <div class="modal fade" id="changeOrderStatusModal" tabindex="-1" aria-labelledby="changeOrderStatusModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="changeOrderStatusModalLabel">Змінити статус замовлення</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити"></button>
                                </div>
                                <form method="post" action="{{route('order.updateStatus', ['idOrder'=>$order->idOrder, 'orderStatus'=>$order->orderStatus])}}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="modal-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="orderStatus" id="statusProcessing" value="2"
                                                   @if($order->orderStatus==2) checked @endif>
                                            <label class="form-check-label" for="statusProcessing">
                                                Замовлення в обробці
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="orderStatus" id="statusConfirmed" value="1"
                                                   @if($order->orderStatus==1) checked @endif>
                                            <label class="form-check-label" for="statusConfirmed">
                                                Замовлення оформлено
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="orderStatus" id="statusCanceled" value="0"
                                                   @if($order->orderStatus==0) checked @endif>
                                            <label class="form-check-label" for="statusCanceled">
                                                Замовлення скасовано
                                            </label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input class="btn btn-primary" type="submit" name="knopka" value="Оновити">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </tr>
                <tr>
                    <th scope="row">Дата створення</th>
                    <td>{{$order->created_at}}</td>
                </tr>
                <tr>
                    <th scope="row">Оновлено</th>
                    <td>{{$order->updated_at}}</td>
                </tr>
                @if($promoCode)
                    <tr>
                        <th scope="row">Промокод</th>
                        <td>{{$promoCode['code']}} (знижка {{$promoCode['discountValue']}}%)</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Список годинників у замовленні --}}
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Годинники у замовленні</h5>
        </div>
        <div class="card-body">
            @if($promoCode)
                <p class="text-danger fw-bold text-center mb-3">
                    Ціни вказані з урахуванням промокоду!
                </p>
            @endif
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Назва</th>
                    <th>Ціна</th>
                    <th>Фото</th>
                    <th>Кількість</th>
                </tr>
                </thead>
                <tbody>
                <?php $number = 1; ?>
                @foreach($arrWatch as $tmpWatch)
                    <tr>
                        <th scope="row">{{$number}}</th>
                        <td>{{$tmpWatch['name']}}</td>
                        <td>{{$tmpWatch['price']}} грн</td>
                        <td><img src="{{$tmpWatch['photo']}}" class="img-watch"></td>
                        <td>{{$tmpWatch['kolvo']}}</td>
                    </tr>
                        <?php $number++; ?>
                @endforeach
                </tbody>
                <tfoot class="table-light">
                <tr>
                    <td colspan="4" class="text-end fw-bold">Загальна сума:</td>
                    <td class="fw-bold">
                        {{$totalCost}}
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <br>
@endsection
