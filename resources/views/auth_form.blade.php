<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Авторизация</title>
    <link rel="stylesheet" href="{{ asset('css/style_auth_form.css') }}">
    <style>
        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background-color: #e8eef6;
            color: #172033;
            text-decoration: none;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        }

        .back-button:hover {
            background-color: #dbe5f0;
            color: #172033;
            transform: translateY(-1px);
        }

        .back-button svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }
    </style>
</head>

<body>
    <a href="{{ route('main') }}" class="back-button">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
        </svg>
        Назад
    </a>

    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="{{ route('register') }}" method="post">
                @csrf
                <h1>Зарегистрироваться</h1>
                <span>Для регистрации используйте свой полюс</span>

                <div class="infield">
                    <input type="text" name="surname" placeholder="Фамилия">
                    <label></label>
                </div>
                <div class="infield">
                    <input type="text" name="firstname" placeholder="Имя" required>
                    <label></label>
                </div>
                <div class="infield">
                    <input type="text" name="patronymic" placeholder="Отчество">
                    <label></label>
                </div>
                <div class="infield">
                    <input type="text" name="pole" placeholder="Полюс" required>
                    <label></label>
                </div>
                <div class="infield">
                    <input type="email" name="email" placeholder="Email (необязательно)">
                    <label></label>
                </div>
                <div class="infield">
                    <input type="tel" name="phone" placeholder="Телефон (необязательно)">
                    <label></label>
                </div>
                <div class="infield">
                    <input type="date" name="birth_date" placeholder="Дата рождения (необязательно)">
                    <label></label>
                </div>
                <div class="infield">
                    <input type="password" name="password" placeholder="Пароль" required minlength="6">
                    <label></label>
                </div>

                <button type="submit">Зарегистрироваться</button>
            </form>
        </div>

        <div class="form-container sign-in-container">
            <form action="{{ route('login') }}" method="post">
                @csrf
                <h1>Авторизоваться</h1>
                <span>Для авторизации введите полюс и пароль</span>

                <div class="infield">
                    <input type="text" name="pole" placeholder="Полюс">
                    <label></label>
                </div>
                <div class="infield">
                    <input type="password" name="password" placeholder="Пароль">
                    <label></label>
                </div>

                <button type="submit">Авторизоваться</button>
            </form>
        </div>

        <div class="overlay-container" id="overlayCon">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <div class="overlay-content">
                        <span class="overlay-kicker">Личный кабинет</span>
                        <h1>С возвращением!</h1>
                        <p>Войдите в систему, чтобы управлять записями, приемами и историей посещений.</p>
                        <button type="button" id="signInBtn">Авторизоваться</button>
                    </div>
                </div>
                <div class="overlay-panel overlay-right">
                    <div class="overlay-content">
                        <span class="overlay-kicker">Новый пользователь</span>
                        <h1>Создайте аккаунт</h1>
                        <p>Заполните короткую форму и получите доступ к онлайн-записи и личному кабинету пациента.</p>
                        <button type="button" id="signUpBtn">Регистрация</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/auth_form.js') }}" defer></script>
</body>

</html>
