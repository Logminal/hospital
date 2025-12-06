@extends("loyaut")

@section("title")
    Управление расписанием
@endsection

@section("main")
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('doctor.appointments.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                Назад к записям
            </a>
        </div>

        <h1 class="mb-4">Управление расписанием</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Форма создания нового слота -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Создать новый слот</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('doctor.schedule.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="appointment_date" class="form-label">Дата:</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="appointment_date" 
                                   name="appointment_date" 
                                   min="{{ date('Y-m-d') }}" 
                                   required>
                        </div>
                        <div class="col-md-3">
                            <label for="start_time" class="form-label">Время начала:</label>
                            <input type="time" 
                                   class="form-control" 
                                   id="start_time" 
                                   name="start_time" 
                                   required>
                        </div>
                        <div class="col-md-3">
                            <label for="end_time" class="form-label">Время окончания:</label>
                            <input type="time" 
                                   class="form-control" 
                                   id="end_time" 
                                   name="end_time" 
                                   required>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Добавить слот</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Список существующих слотов -->
        @if($schedules->isEmpty())
            <div class="alert alert-info">
                У вас пока нет слотов в расписании. Создайте первый слот выше.
            </div>
        @else
            @foreach($schedules as $date => $daySchedules)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">{{ \Carbon\Carbon::parse($date)->format('d.m.Y') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Время</th>
                                        <th>Статус</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($daySchedules as $schedule)
                                        <tr>
                                            <td>
                                                <strong>{{ date('H:i', strtotime($schedule->start_time)) }}</strong> - 
                                                {{ date('H:i', strtotime($schedule->end_time)) }}
                                            </td>
                                            <td>
                                                @if($schedule->is_available)
                                                    <span class="badge bg-success">Доступен</span>
                                                @else
                                                    <span class="badge bg-secondary">Заблокирован</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('doctor.schedule.update', $schedule->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="is_available" value="{{ $schedule->is_available ? '0' : '1' }}">
                                                    <button type="submit" class="btn btn-sm {{ $schedule->is_available ? 'btn-warning' : 'btn-success' }}">
                                                        {{ $schedule->is_available ? 'Заблокировать' : 'Разблокировать' }}
                                                    </button>
                                                </form>
                                                <form action="{{ route('doctor.schedule.destroy', $schedule->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Вы уверены, что хотите удалить этот слот?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection

