@extends("loyaut")

@section("title")
    Главная
@endsection

@section("main")
    <div class="container mt-5">
        <div class="jumbotron text-center">
            <h1 class="display-4">Добро пожаловать в нашу клинику!</h1>
            @auth
                <p class="lead">Здравствуйте, <strong>{{ auth()->user()->name }}</strong>!</p>
            @else
                <p class="lead">Запишитесь на прием к нашим врачам онлайн</p>
            @endauth
            <hr class="my-4">
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a class="btn btn-primary btn-lg" href="{{ route('doctors.index') }}" role="button">Посмотреть врачей</a>
                @auth
                    <a class="btn btn-success btn-lg" href="{{ route('appointments.my') }}" role="button">Мои записи</a>
                    @if(auth()->user()->isDoctor())
                        <a class="btn btn-info btn-lg" href="{{ route('doctor.appointments.index') }}" role="button">Панель врача</a>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <a class="btn btn-warning btn-lg" href="{{ route('adminPanel') }}" role="button">Админ-панель</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-lg">Выйти</button>
                    </form>
                @else
                    <a class="btn btn-outline-primary btn-lg" href="{{ route('auth') }}" role="button">Войти</a>
                @endauth
            </div>
        </div>
    </div>
@endsection
