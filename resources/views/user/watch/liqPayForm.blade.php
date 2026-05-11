<!doctype html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <title>Перехід до LiqPay</title>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            align-items: center;
            background: #f5f7fb;
            color: #1f2937;
            display: flex;
            font-family: sans-serif;
            justify-content: center;
        }

        .liqpay-loader {
            text-align: center;
        }

        .liqpay-spinner {
            animation: liqpay-spin 0.8s linear infinite;
            border: 4px solid #dbe3ef;
            border-top-color: #1f8f3a;
            border-radius: 50%;
            height: 44px;
            margin: 0 auto 16px;
            width: 44px;
        }

        .liqpay-form {
            display: none;
        }

        @keyframes liqpay-spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
    <div class="liqpay-loader">
        <div class="liqpay-spinner"></div>
        <p>Переходимо до оплати LiqPay...</p>
    </div>

    <form class="liqpay-form" method="POST" action="https://www.liqpay.ua/api/3/checkout" accept-charset="utf-8">
        <input type="hidden" name="data" value="{{ $date }}">
        <input type="hidden" name="signature" value="{{ $signature }}">
        <noscript>
            <button type="submit">Перейти до оплати через LiqPay</button>
        </noscript>
    </form>
    <script>
        document.forms[0].submit();
    </script>
</body>
</html>
