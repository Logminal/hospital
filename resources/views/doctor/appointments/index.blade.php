@extends("loyaut")

@section("title")
    Мои записи
@endsection

@section("main")
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('main') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                Назад
            </a>
            <a href="{{ route('doctor.schedule.index') }}" class="btn btn-primary">Управление расписанием</a>
        </div>
        <h1 class="mb-4">Мои записи</h1>

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
                У вас пока нет записей.
            </div>
        @else
            @foreach($appointments as $date => $dayAppointments)
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
                                                <div class="btn-group" role="group">
                                                    @if($appointment->status != 'cancelled' && $appointment->status != 'completed')
                                                        @if($appointment->status == 'pending' || $appointment->status == 'confirmed')
                                                            <button type="button" class="btn btn-sm btn-success" 
                                                                    onclick="updateStatus({{ $appointment->id }}, 'visited')">
                                                                Пациент пришел
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-secondary" 
                                                                    onclick="updateStatus({{ $appointment->id }}, 'no_show')">
                                                                Не пришел
                                                            </button>
                                                        @endif

                                                        @if($appointment->status == 'visited')
                                                            <button type="button" class="btn btn-sm btn-primary" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#completeModal{{ $appointment->id }}">
                                                                Завершить прием
                                                            </button>
                                                        @endif

                                                        <button type="button" class="btn btn-sm btn-danger" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#cancelModal{{ $appointment->id }}">
                                                            Отменить
                                                        </button>
                                                    @endif

                                                    @if($appointment->conclusion)
                                                        <button type="button" class="btn btn-sm btn-info" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#conclusionModal{{ $appointment->id }}">
                                                            Заключение
                                                        </button>
                                                    @endif

                                                    @if($appointment->cancellation_reason)
                                                        <button type="button" class="btn btn-sm btn-warning" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#reasonModal{{ $appointment->id }}">
                                                            Причина отмены
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Модальное окно для завершения приема -->
                                        <div class="modal fade" id="completeModal{{ $appointment->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ url('/doctor/appointments') }}/{{ $appointment->id }}/complete" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Завершить прием</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Пациент:</strong> {{ $appointment->user->name }}</p>
                                                            <p><strong>Дата:</strong> {{ $appointment->appointment_date->format('d.m.Y') }}</p>
                                                            <p><strong>Время:</strong> {{ date('H:i', strtotime($appointment->appointment_time)) }}</p>
                                                            <div class="mb-3">
                                                                <label for="conclusion{{ $appointment->id }}" class="form-label">Служебное заключение *</label>
                                                                <textarea class="form-control" id="conclusion{{ $appointment->id }}" 
                                                                          name="conclusion" rows="5" required minlength="10"></textarea>
                                                                <small class="text-muted">Минимум 10 символов</small>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                                            <button type="submit" class="btn btn-primary">Сохранить заключение</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Модальное окно для отмены -->
                                        <div class="modal fade" id="cancelModal{{ $appointment->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form id="cancelForm{{ $appointment->id }}" onsubmit="cancelAppointment(event, {{ $appointment->id }})">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Отменить запись</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Пациент:</strong> {{ $appointment->user->name }}</p>
                                                            <p><strong>Дата:</strong> {{ $appointment->appointment_date->format('d.m.Y') }}</p>
                                                            <p><strong>Время:</strong> {{ date('H:i', strtotime($appointment->appointment_time)) }}</p>
                                                            <div class="mb-3">
                                                                <label for="cancellation_reason{{ $appointment->id }}" class="form-label">Причина отмены *</label>
                                                                <textarea class="form-control" id="cancellation_reason{{ $appointment->id }}" 
                                                                          name="cancellation_reason" rows="3" required minlength="3"></textarea>
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

                                        <!-- Модальное окно для просмотра заключения -->
                                        @if($appointment->conclusion)
                                        <div class="modal fade" id="conclusionModal{{ $appointment->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Служебное заключение</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Пациент:</strong> {{ $appointment->user->name }}</p>
                                                        <p><strong>Дата приема:</strong> {{ $appointment->appointment_date->format('d.m.Y') }}</p>
                                                        <hr>
                                                        <p><strong>Заключение:</strong></p>
                                                        <p>{{ $appointment->conclusion }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <!-- Модальное окно для просмотра причины отмены -->
                                        @if($appointment->cancellation_reason)
                                        <div class="modal fade" id="reasonModal{{ $appointment->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Причина отмены</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Пациент:</strong> {{ $appointment->user->name }}</p>
                                                        <p><strong>Дата записи:</strong> {{ $appointment->appointment_date->format('d.m.Y') }}</p>
                                                        <hr>
                                                        <p><strong>Причина:</strong></p>
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
        @endif
    </div>

    <script>
        function updateStatus(appointmentId, status) {
            if (confirm('Вы уверены, что хотите изменить статус?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                // Используем базовый URL проекта
                const baseUrl = '{{ url("/") }}';
                form.action = baseUrl + '/doctor/appointments/' + appointmentId + '/status';
                
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

        function cancelAppointment(event, appointmentId) {
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            const reason = formData.get('cancellation_reason');

            if (!reason || reason.length < 3) {
                alert('Пожалуйста, укажите причину отмены (минимум 3 символа)');
                return;
            }

            const baseUrl = '{{ url("/") }}';
            const cancelUrl = baseUrl + '/doctor/appointments/' + appointmentId + '/cancel';
            fetch(cancelUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cancellation_reason: reason
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.error || 'Ошибка при отмене записи');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ошибка при отмене записи');
            });
        }
    </script>
@endsection

