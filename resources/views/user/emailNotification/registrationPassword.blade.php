<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Ваш акаунт створено — Магазин годинників</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { margin:0; padding:0; background-color:#e6f0ff; font-family:'Segoe UI', sans-serif; }
        .email-container { max-width:600px; margin:30px auto; background-color:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1); border:2px solid #4d94ff; }
        .email-header { background-color:#4d94ff; color:#fff; text-align:center; padding:20px 30px; }
        .email-body { padding:30px; color:#333; font-size:16px; line-height:1.6; }
        .email-body h2 { font-weight:600; margin-bottom:15px; }
        .email-footer { text-align:center; font-size:13px; color:#999; padding:20px; background-color:#f5f5f5; }
        .password-box {
            background-color: #f1f1f1;
            padding: 15px;
            border: 2px dashed #0d6efd;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            border-radius: 8px;
            word-break: break-word;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h1>Магазин годинників</h1>
    </div>

    <div class="email-body">
        <h2>Вітаємо, {{ $email }}!</h2>
        <p>Ваш акаунт успішно створено за допомогою Google.</p>
        <p>Щоб входити на сайт не тільки через Google, ось ваш згенерований пароль:</p>

        <div class="password-box">
            {{ $password }}
        </div>

        <p>Рекомендуємо змінити його після першого входу для безпеки.</p>
    </div>

    <div class="email-footer">
        Ви отримали цей лист, тому що зареєструвалися в Магазин годинників.<br>
        &copy; 2025 Магазин годинників. Всі права захищено.
    </div>
</div>
</body>
</html>

