@extends('layoutsAdmin.layoutAdmin', ['title'=>'Інформація про оплату'])

@section('content')
    <style>
        .container{
            min-height: 150px;
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
    </style>

    <blockquote class="blockquote text-center">
        <p class="h1">Інформація про оплату замовлення №{{$response['order_id']}}</p>
    </blockquote>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Дані про оплату</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th scope="row">Ім’я відправника</th>
                    <td>{{$response['sender_first_name']}}</td>
                </tr>
                <tr>
                    <th scope="row">Прізвище відправника</th>
                    <td>{{$response['sender_last_name']}}</td>
                </tr>
                <tr>
                    <th scope="row">Карта відправника</th>
                    <td>{{$response['sender_card_mask2']}}</td>
                </tr>
                <tr>
                    <th scope="row">Банк відправника</th>
                    <td>{{$response['sender_card_bank']}}</td>
                </tr>
                <tr>
                    <th scope="row">Тип картки</th>
                    <td>{{$response['sender_card_type']}}</td>
                </tr>
                <tr>
                    <th scope="row">Опис платежу</th>
                    <td>{{$response['description']}}</td>
                </tr>
                <tr>
                    <th scope="row">Дата створення транзакції</th>
                    <td>
                        {{$response['create_date']}}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Дата завершення транзакції</th>
                    <td>
                        {{$response['end_date']}}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br>
@endsection

