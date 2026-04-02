@extends("loyaut")

@section("title")
    Мои записи
@endsection

@section("main")
    <div class="app-dashboard">
        <div class="container">
            <div class="app-toolbar">
                <div class="app-toolbar-title">
                    <h1>Мои записи</h1>
                    <p class="app-toolbar-subtitle">Просматривайте ближайшие визиты, историю приемов и причины отмен.</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('main') }}" class="btn btn-secondary">На главную</a>
                    <a href="{{ route('appointments.profile') }}" class="btn btn-outline-secondary">Профиль</a>
                    <a href="{{ route('doctors.index') }}" class="btn btn-primary">Записаться к врачу</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">Выйти</button>
                    </form>
                </div>
            </div>

            <div class="app-panel p-4">
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

                @if($appointments->isEmpty())
                    <div class="alert alert-info">
                        У вас пока нет записей. <a href="{{ route('doctors.index') }}">Выбрать врача</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Врач</th>
                                    <th>Специальность</th>
                                    <th>Дата</th>
                                    <th>Время</th>
                                    <th>Статус</th>
                                    <th>Примечания</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->id }}</td>
                                        <td>{{ $appointment->doctor->name }}</td>
                                        <td>{{ $appointment->doctor->specialty->name ?? 'Не указана' }}</td>
                                        <td>{{ $appointment->appointment_date->format('d.m.Y') }}</td>
                                        <td>{{ date('H:i', strtotime($appointment->appointment_time)) }}</td>
                                        <td>
                                            @if($appointment->status == 'pending')
                                                <span class="badge bg-warning">Ожидает</span>
                                            @elseif($appointment->status == 'confirmed')
                                                <span class="badge bg-info">Подтверждена</span>
                                            @elseif($appointment->status == 'visited')
                                                <span class="badge bg-primary">Пациент пришел</span>
                                            @elseif($appointment->status == 'completed')
                                                <span class="badge bg-success">Завершена</span>
                                            @elseif($appointment->status == 'no_show')
                                                <span class="badge bg-secondary">Не состоялась</span>
                                            @elseif($appointment->status == 'cancelled')
                                                <span class="badge bg-danger">Отменена</span>
                                            @endif
                                        </td>
                                        <td>{{ $appointment->notes ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex gap-2 flex-wrap">
                                                @if($appointment->conclusion)
                                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#conclusionModal{{ $appointment->id }}">
                                                        Заключение
                                                    </button>
                                                @endif
                                                @if($appointment->status != 'cancelled' && $appointment->status != 'completed')
                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $appointment->id }}">
                                                        Отменить
                                                    </button>
                                                @endif
                                                @if($appointment->status == 'cancelled' && $appointment->cancellation_reason)
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#reasonModal{{ $appointment->id }}">
                                                        Причина отмены
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    @if($appointment->conclusion)
                                        <div class="modal fade" id="conclusionModal{{ $appointment->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Заключение врача</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Врач:</strong> {{ $appointment->doctor->name }}</p>
                                                        <p><strong>Дата приема:</strong> {{ $appointment->appointment_date->format('d.m.Y') }}</p>
                                                        <p><strong>Время:</strong> {{ date('H:i', strtotime($appointment->appointment_time)) }}</p>
                                                        <hr>
                                                        <p>{{ $appointment->conclusion }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($appointment->status != 'cancelled' && $appointment->status != 'completed')
                                        <div class="modal fade" id="cancelModal{{ $appointment->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Отмена записи</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Врач:</strong> {{ $appointment->doctor->name }}</p>
                                                            <p><strong>Дата записи:</strong> {{ $appointment->appointment_date->format('d.m.Y') }}</p>
                                                            <p><strong>Время:</strong> {{ date('H:i', strtotime($appointment->appointment_time)) }}</p>
                                                            <div class="mb-3">
                                                                <label for="cancellation_reason{{ $appointment->id }}" class="form-label">Причина отмены *</label>
                                                                <textarea class="form-control" id="cancellation_reason{{ $appointment->id }}" name="cancellation_reason" rows="4" required minlength="5" maxlength="500"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                                            <button type="submit" class="btn btn-danger">Отменить запись</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($appointment->cancellation_reason)
                                        <div class="modal fade" id="reasonModal{{ $appointment->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Причина отмены</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Врач:</strong> {{ $appointment->doctor->name }}</p>
                                                        <p><strong>Дата записи:</strong> {{ $appointment->appointment_date->format('d.m.Y') }}</p>
                                                        <hr>
                                                        <p>{{ $appointment->cancellation_reason }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
