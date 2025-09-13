<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Повідомлення від Магазин годинників</title>
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

        .email-body h2 {
            font-weight: 600;
            margin-bottom: 15px;
        }

        .email-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0d6efd;
            color: #fff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
        }

        .email-footer {
            text-align: center;
            font-size: 13px;
            color: #999;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .email-footer-note {
            font-size: 13px;
            color: #555;
            padding: 0 30px 20px 30px;
            word-wrap: break-word;
            word-break: break-all;
            line-height: 1.4;
        }

        .email-footer-note a {
            color: #0d6efd;
            text-decoration: none;
        }

        .email-footer-note a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h1>Магазин годинників</h1>
    </div>

    <div class="email-body">
        <h2>Підтвердження електронної пошти</h2>
        <p>Будь ласка, натисніть кнопку нижче, щоб підтвердити свою адресу електронної пошти:</p>

        <p style="text-align: center;">
            <a href="{{$url}}" class="email-btn">Підтвердити</a>
        </p>

        <p>Якщо ви не надсилали цей запит — просто проігноруйте це повідомлення.</p>
    </div>

    <div class="email-footer-note">
        Якщо у вас виникли труднощі з натисканням кнопки <strong>"Підтвердити"</strong>, скопіюйте та вставте наступну адресу у веб-браузер:<br><br>
        <a href="{{$url}}">
            {{$url}}
        </a>
    </div>

    <div class="email-footer">
        Ви отримали цей лист, тому що використовували Магазин годинників.<br>
        &copy; 2025 Магазин годинників. Всі права захищено.
    </div>
</div>
</body>
</html>


