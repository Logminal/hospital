@extends("loyaut")

@section("title")
    Кабинет врача
@endsection

@section("main")
    <div class="app-dashboard">
        <div class="container">
            <div class="app-toolbar">
                <div class="app-toolbar-title">
                    <h1>Кабинет врача</h1>
                    <p class="app-toolbar-subtitle">Управляйте приемами, отмечайте статусы и ведите заключения по каждому визиту.</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('main') }}" class="btn btn-secondary">На главную</a>
                    <a href="{{ route('doctor.schedule.index') }}" class="btn btn-primary">Расписание</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">Выйти</button>
                    </form>
                </div>
            </div>

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

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($appointments->isEmpty())
                <div class="alert alert-info">
                    У вас пока нет назначенных записей.
                </div>
            @else
                <div class="dashboard-stack">
                    @foreach($appointments as $date => $dayAppointments)
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <h5 class="mb-0">{{ \Carbon\Carbon::parse($date)->format('d.m.Y') }}</h5>
                                <span class="badge bg-info">{{ $dayAppointments->count() }} прием.</span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Время</th>
                                                <th>Пациент</th>
                                                <th>Статус</th>
                                                <th>Действия</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dayAppointments as $appointment)
                                                <tr>
                                                    <td>{{ date('H:i', strtotime($appointment->appointment_time)) }}</td>
                                                    <td>
                                                        <strong>{{ $appointment->user->name }}</strong><br>
                                                        <small class="text-muted">{{ $appointment->user->pole }}</small>
                                                    </td>
                                                    <td>
                                                        @if($appointment->status == 'pending')
                                                            <span class="badge bg-warning">Ожидает</span>
                                                        @elseif($appointment->status == 'confirmed')
                                                            <span class="badge bg-info">Подтверждено</span>
                                                        @elseif($appointment->status == 'visited')
                                                            <span class="badge bg-primary">Пациент пришел</span>
                                                        @elseif($appointment->status == 'completed')
                                                            <span class="badge bg-success">Завершено</span>
                                                        @elseif($appointment->status == 'no_show')
                                                            <span class="badge bg-secondary">Не пришел</span>
                                                        @elseif($appointment->status == 'cancelled')
                                                            <span class="badge bg-danger">Отменено</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2 flex-wrap">
                                                            @if($appointment->status != 'cancelled' && $appointment->status != 'completed')
                                                                @if($appointment->status == 'pending' || $appointment->status == 'confirmed')
                                                                    <button type="button" class="btn btn-sm btn-success" onclick="updateStatus({{ $appointment->id }}, 'visited')">
                                                                        Пациент пришел
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-secondary" onclick="updateStatus({{ $appointment->id }}, 'no_show')">
                                                                        Не пришел
                                                                    </button>
                                                                @endif

                                                                @if($appointment->status == 'visited')
                                                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#completeModal{{ $appointment->id }}">
                                                                        Завершить прием
                                                                    </button>
                                                                @endif

                                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $appointment->id }}">
                                                                    Отменить
                                                                </button>
                                                            @endif

                                                            @if($appointment->conclusion)
                                                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#conclusionModal{{ $appointment->id }}">
                                                                    Заключение
                                                                </button>
                                                            @endif

                                                            @if($appointment->cancellation_reason)
                                                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#reasonModal{{ $appointment->id }}">
                                                                    Причина отмены
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>

                                                @if($appointment->status == 'visited')
                                                    <div class="modal fade" id="completeModal{{ $appointment->id }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form action="{{ route('doctor.appointments.complete', $appointment->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Завершить прием</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p><strong>Пациент:</strong> {{ $appointment->user->name }}</p>
                                                                        <p><strong>Дата:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y') }}</p>
                                                                        <p><strong>Время:</strong> {{ date('H:i', strtotime($appointment->appointment_time)) }}</p>
                                                                        <div class="mb-3">
                                                                            <label for="conclusion{{ $appointment->id }}" class="form-label">Заключение *</label>
                                                                            <textarea class="form-control" id="conclusion{{ $appointment->id }}" name="conclusion" rows="5" required minlength="10"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                                                        <button type="submit" class="btn btn-primary">Завершить прием</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($appointment->status != 'cancelled' && $appointment->status != 'completed')
                                                    <div class="modal fade" id="cancelModal{{ $appointment->id }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form action="{{ route('doctor.appointments.cancel', $appointment->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Отмена записи</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p><strong>Пациент:</strong> {{ $appointment->user->name }}</p>
                                                                        <p><strong>Дата:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y') }}</p>
                                                                        <p><strong>Время:</strong> {{ date('H:i', strtotime($appointment->appointment_time)) }}</p>
                                                                        <div class="mb-3">
                                                                            <label for="cancellation_reason{{ $appointment->id }}" class="form-label">Причина отмены *</label>
                                                                            <textarea class="form-control" id="cancellation_reason{{ $appointment->id }}" name="cancellation_reason" rows="4" required minlength="3"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                                                        <button type="submit" class="btn btn-danger">Отменить</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($appointment->conclusion)
                                                    <div class="modal fade" id="conclusionModal{{ $appointment->id }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Заключение</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>Пациент:</strong> {{ $appointment->user->name }}</p>
                                                                    <p><strong>Дата:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y') }}</p>
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

                                                @if($appointment->cancellation_reason)
                                                    <div class="modal fade" id="reasonModal{{ $appointment->id }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Причина отмены</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>Пациент:</strong> {{ $appointment->user->name }}</p>
                                                                    <p><strong>Дата:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y') }}</p>
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
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        function updateStatus(appointmentId, status) {
            if (confirm('Вы уверены, что хотите изменить статус?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ url("/") }}' + '/doctor/appointments/' + appointmentId + '/status';

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);

                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status';
                statusInput.value = status;
                form.appendChild(statusInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection
