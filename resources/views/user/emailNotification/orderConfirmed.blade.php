<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Замовлення оформлено</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #e6f0ff;
            font-family: 'Segoe UI', sans-serif;
        }

        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 2px solid #4d94ff;
        }

        .email-header {
            background-color: #4d94ff;
            color: #fff;
            text-align: center;
            padding: 20px 30px;
        }

        .email-body {
            padding: 30px;
            color: #333;
            font-size: 16px;
            line-height: 1.6;
        }

        .order-info {
            margin-bottom: 20px;
            font-size: 15px;
        }

        .order-info strong {
            display: inline-block;
            min-width: 130px;
        }

        .order-products {
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        .product-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .product-image {
            width: 60px;
            margin-right: 15px;
        }

        .product-details {
            flex: 1;
        }

        .product-details p {
            margin: 0 0 5px;
            font-size: 14px;
        }

        .product-price {
            font-weight: bold;
            font-size: 14px;
        }

        .order-summary {
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
            font-size: 15px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .summary-total {
            font-weight: bold;
            font-size: 17px;
        }

        .email-footer {
            text-align: center;
            font-size: 13px;
            color: #999;
            padding: 20px;
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h1>Магазин годинників</h1>
    </div>

    <div class="email-body">
        <h2>Дякуємо за ваше замовлення!</h2>
        <p>Ваше замовлення успішно оформлене. Скоро з вами з'вяжеться наш консультант.</p>

        <div class="order-info">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="font-weight: bold; width: 140px; padding: 3px 0;">Номер замовлення:</td>
                    <td style="padding: 3px 0;">#{{ $order['numberOrder'] }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 3px 0;">Одержувач:</td>
                    <td style="padding: 3px 0;">{{ $buyer['pib'] }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 3px 0; vertical-align: top;">Адреса:</td>
                    <td style="padding: 3px 0; word-break: break-word;">{{ $delivery }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 3px 0;">Телефон:</td>
                    <td style="padding: 3px 0;">{{ $buyer['number'] }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 3px 0;">Тип оплати:</td>
                    <td style="padding: 3px 0;">{{ $payment }}</td>
                </tr>
            </table>
        </div>

        <div class="order-products">
            @foreach($watch as $tmpWatch)
                <div class="product-item">
                    <img class="product-image" src="{{ asset($tmpWatch['photo']) }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; margin-right: 12px;">
                    <div class="product-details">
                        <p><strong>{{ $tmpWatch['name'] }}</strong></p>
                        <p>Ціна: ${{ $tmpWatch['price'] }}</p>
                        <p>Кількість: {{ $tmpWatch['kolvo'] }}</p>
                    </div>
                    <div class="product-price">
                        ${{ $tmpWatch['price'] * $tmpWatch['kolvo'] }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="order-summary">
            @if(!empty($promoCode))
            <div class="summary-row">
                <span>Знижка:</span>
                <span style="color:red;">-{{ $promoCode['discountValue'] }}%</span>
            </div>
            @endif
            <div class="summary-row summary-total">
                <span>Разом:</span>
                <span>${{ $totalCost }}</span>
            </div>
        </div>
    </div>

    <div class="email-footer">
        Ви отримали цей лист, тому що використовували Магазин годинників.<br>
        &copy; 2025 Магазин годинників. Всі права захищено.
    </div>
</div>
</body>
</html>

