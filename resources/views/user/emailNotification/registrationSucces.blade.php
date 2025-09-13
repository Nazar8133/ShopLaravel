<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Вітаємо на сайті Магазин годинників</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* той самий CSS */
        body { margin:0; padding:0; background-color:#e6f0ff; font-family:'Segoe UI', sans-serif; }
        .email-container { max-width:600px; margin:30px auto; background-color:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1); border:2px solid #4d94ff; }
        .email-header { background-color:#4d94ff; color:#fff; text-align:center; padding:20px 30px; }
        .email-body { padding:30px; color:#333; font-size:16px; line-height:1.6; }
        .email-body h2 { font-weight:600; margin-bottom:15px; }
        .email-footer { text-align:center; font-size:13px; color:#999; padding:20px; background-color:#f5f5f5; }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h1>Магазин годинників</h1>
    </div>

    <div class="email-body">
        <h2>Вітаємо, {{ $name }}!</h2>
        <p>Дякуємо за реєстрацію на нашому сайті. Тепер ви маєте доступ до всіх можливостей Магазину годинників!</p>
        <p>Бажаємо приємного користування й вдалих покупок!</p>
    </div>

    <div class="email-footer">
        Ви отримали цей лист, тому що зареєструвалися в Магазин годинників.<br>
        &copy; 2025 Магазин годинників. Всі права захищено.
    </div>
</div>
</body>
</html>

