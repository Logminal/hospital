<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Авторизация</title>
    <link rel="stylesheet" href="{{asset("css/style_auth_form.css")}}">
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
            background-color: #555;
            color: #FFF;
            text-decoration: none;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }
        .back-button:hover {
            background-color: #333;
            color: #FFF;
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
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
        </svg>
        Назад
    </a>

<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form action="{{route('register')}}" method="post">
            @csrf
            <h1>Зарегистрироваться</h1>
            <span>Для регистрации используйте свой полюс</span>
            <div class="infield">
                <input type="text" name="surname" placeholder="Фамилия"/>
                <label></label>
            </div>
            <div class="infield">
                <input type="text" name="firstname" placeholder="Имя" required/>
                <label></label>
            </div>
            <div class="infield">
                <input type="text" name="patronymic" placeholder="Отчество"/>
                <label></label>
            </div>
            <div class="infield">
                <input type="text" placeholder="Полюс" name="pole" required/>
                <label></label>
            </div>
            <div class="infield">
                <input type="email" name="email" placeholder="Email (необязательно)"/>
                <label></label>
            </div>
            <div class="infield">
                <input type="tel" name="phone" placeholder="Телефон (необязательно)"/>
                <label></label>
            </div>
            <div class="infield">
                <input type="date" name="birth_date" placeholder="Дата рождения (необязательно)"/>
                <label></label>
            </div>
            <div class="infield">
                <input type="password" name="password" placeholder="Пароль" required minlength="6"/>
                <label></label>
            </div>
            <button type="submit">Зарегистрироваться</button>
        </form>
    </div>
    <div class="form-container sign-in-container">
        <form action="{{route('login')}}" method="post">
            @csrf
            <h1>Авторизироваться</h1>
            <span>Для авторизации ведите полюс и пароль</span>
            <div class="infield">
                <input type="text" placeholder="Полюс" name="pole"/>
                <label></label>
            </div>
            <div class="infield">
                <input type="password" name="password" placeholder="Пароль"/>
                <label></label>
            </div>
            <button type="submit">Авторизироваться</button>
        </form>
    </div>
    <div class="overlay-container" id="overlayCon">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Здравствуйте!</h1>
                <p>Войдите в систему, используя свои учетные данные</p>
                <button type="button">Авторизироваться</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Здравствуйте</h1>
                <p>Создайте учетную запись, что бы всегда быть с нами на связи</p>
                <button type="button" id="signUpBtn">Зарегистрироваться</button>
            </div>
        </div>
        <button type="button" id="overlayBtn"></button>
    </div>
</div>

<script src="{{asset("js/auth_form.js")}}" defer></script>

</body>

</html>
