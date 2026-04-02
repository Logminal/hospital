@extends("loyaut")

@section("title")
    Управление расписанием
@endsection

@section("main")
    <div class="app-dashboard">
        <div class="container">
            <div class="app-toolbar">
                <div class="app-toolbar-title">
                    <h1>Расписание врача</h1>
                    <p class="app-toolbar-subtitle">Создавайте слоты, блокируйте время и держите календарь актуальным.</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('doctor.appointments.index') }}" class="btn btn-secondary">Назад к записям</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">Выйти</button>
                    </form>
                </div>
            </div>

            <div class="dashboard-stack">
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

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Создать новый слот</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('doctor.schedule.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="appointment_date" class="form-label">Дата:</label>
                                    <input type="date" class="form-control" id="appointment_date" name="appointment_date" min="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="start_time" class="form-label">Время начала:</label>
                                    <input type="time" class="form-control" id="start_time" name="start_time" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="end_time" class="form-label">Время окончания:</label>
                                    <input type="time" class="form-control" id="end_time" name="end_time" required>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Добавить слот</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if($schedules->isEmpty())
                    <div class="alert alert-info">
                        У вас пока нет слотов в расписании. Создайте первый слот выше.
                    </div>
                @else
                    @foreach($schedules as $date => $daySchedules)
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <h5 class="mb-0">{{ \Carbon\Carbon::parse($date)->format('d.m.Y') }}</h5>
                                <span class="badge bg-info">{{ $daySchedules->count() }} слот.</span>
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
        </div>
    </div>
@endsection
