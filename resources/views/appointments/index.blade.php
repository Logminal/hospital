@extends("loyaut")

@section("title")
    Врачи
@endsection

@section("main")
    <div class="container mt-4">
        <a href="{{ route('main') }}" class="btn btn-secondary mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Назад
        </a>
        <h1 class="mb-4">Наши врачи</h1>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Фильтры и поиск -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('doctors.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Поиск по имени врача:</label>
                        <input type="text" 
                               class="form-control" 
                               id="search" 
                               name="search" 
                               value="{{ $searchQuery }}" 
                               placeholder="Введите имя врача">
                    </div>
                    <div class="col-md-4">
                        <label for="specialty" class="form-label">Фильтр по специальности:</label>
                        <select class="form-select" id="specialty" name="specialty">
                            <option value="all" {{ $selectedSpecialty == 'all' ? 'selected' : '' }}>Все специальности</option>
                            @foreach($specialties as $specialty)
                                <option value="{{ $specialty->id }}" {{ $selectedSpecialty == $specialty->id ? 'selected' : '' }}>
                                    {{ $specialty->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">Применить фильтр</button>
                        <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary">Сбросить</a>
                    </div>
                </form>
            </div>
        </div>

        @if($doctors->isEmpty())
            <div class="alert alert-info">
                @if($selectedSpecialty != 'all' || $searchQuery)
                    Врачи не найдены по заданным критериям. <a href="{{ route('doctors.index') }}">Показать всех врачей</a>
                @else
                    Врачи пока не добавлены. Пожалуйста, зайдите позже.
                @endif
            </div>
        @else
            <div class="mb-3">
                <p class="text-muted">Найдено врачей: {{ $doctors->count() }}</p>
            </div>
        @endif

        <div class="row">
            @foreach($doctors as $doctor)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $doctor->name }}</h5>
                            <p class="card-text">
                                <strong>Специальность:</strong> {{ $doctor->specialty->name ?? 'Не указана' }}<br>
                                @if($doctor->cabinet_number)
                                    <strong>Кабинет:</strong> {{ $doctor->cabinet_number }}<br>
                                @endif
                                @if(!$doctor->is_active)
                                    <span class="badge bg-secondary">В отпуске</span>
                                @endif
                            </p>
                            <a href="{{ route('doctor.show', $doctor->id) }}" class="btn btn-primary">Записаться на прием</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

