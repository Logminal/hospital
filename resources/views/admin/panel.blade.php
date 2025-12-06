@extends("loyaut")

@section("title")
    Админка
@endsection

@section("main")

    <div class="container">
        <a href="{{ route('main') }}" class="btn btn-secondary mb-3 mt-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Назад на главную
        </a>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">

            <div class="col-3">
                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Записи</button>
                    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Врачи</button>
                    <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Пользователи</button>
                    <button class="nav-link" id="v-pills-specialty-tab" data-bs-toggle="pill" data-bs-target="#v-pills-specialty" type="button" role="tab" aria-controls="v-pills-specialty" aria-selected="false">Специальности</button>
                    <button class="nav-link" id="v-pills-admin-tab" data-bs-toggle="pill" data-bs-target="#v-pills-admin" type="button" role="tab" aria-controls="v-pills-admin" aria-selected="false">Администраторы</button>
                </div>
            </div>

            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">

                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                        <h3>Все записи</h3>

                        <div class="mb-3">
                            <p class="text-muted">Показано записей: {{ $all_appointments->count() }}</p>
                        </div>

                        @if($all_appointments->isEmpty())
                            <div class="alert alert-info">
                                Записей пока нет.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Пациент</th>
                                            <th scope="col">Врач</th>
                                            <th scope="col">Специальность</th>
                                            <th scope="col">Дата</th>
                                            <th scope="col">Время</th>
                                            <th scope="col">Статус</th>
                                            <th scope="col">Примечания</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($all_appointments as $appointment)
                                            <tr>
                                                <th scope="row">{{ $appointment->id }}</th>
                                                <td>
                                                    <strong>{{ $appointment->user->name }}</strong><br>
                                                    <small class="text-muted">{{ $appointment->user->pole }}</small>
                                                </td>
                                                <td>
                                                    {{ $appointment->doctor->name }}
                                                    @if($appointment->doctor->cabinet_number)
                                                        <br><small class="text-muted">Каб. {{ $appointment->doctor->cabinet_number }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $appointment->doctor->specialty->name ?? 'Не указана' }}</td>
                                                <td>{{ $appointment->appointment_date->format('d.m.Y') }}</td>
                                                <td>{{ date('H:i', strtotime($appointment->appointment_time)) }}</td>
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
                                                        @if($appointment->cancellation_reason)
                                                            <br><small class="text-muted" title="{{ $appointment->cancellation_reason }}">(есть причина)</small>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($appointment->notes)
                                                        <small>{{ Str::limit($appointment->notes, 50) }}</small>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                    @if($appointment->conclusion)
                                                        <br><small class="text-info">(есть заключение)</small>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">
                        <h3>Добавить врача</h3>

                        <form action="{{route('store.doctor')}}" method="post" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label for="doctor_name" class="form-label">Имя врача:</label>
                                <input type="text" name="name" id="doctor_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="doctor_specialty" class="form-label">Специальность:</label>
                                <select name="specialty_id" id="doctor_specialty" class="form-select" required>
                                    <option value="">Выберите специальность</option>
                                    @foreach($all_specialty as $specialty)
                                        <option value="{{$specialty->id}}">{{$specialty->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="doctor_cabinet" class="form-label">Номер кабинета:</label>
                                <input type="text" name="cabinet_number" id="doctor_cabinet" class="form-control" placeholder="Например: 101">
                                <small class="text-muted">Необязательно</small>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="is_active" id="doctor_active" class="form-check-input" value="1" checked>
                                <label for="doctor_active" class="form-check-label">Врач активен (работает)</label>
                            </div>
                            <hr>
                            <h6>Учетная запись для входа:</h6>
                            <div class="mb-3">
                                <label for="doctor_pole" class="form-label">Полюс (логин):</label>
                                <input type="text" name="pole" id="doctor_pole" class="form-control" required>
                                <small class="text-muted">Используется для входа в систему</small>
                            </div>
                            <div class="mb-3">
                                <label for="doctor_password" class="form-label">Пароль:</label>
                                <input type="password" name="password" id="doctor_password" class="form-control" required minlength="6">
                                <small class="text-muted">Минимум 6 символов</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Добавить врача</button>
                        </form>

                        <h3>Наши врачи:</h3>

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Имя</th>
                                <th scope="col">Специальность</th>
                                <th scope="col">Кабинет</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Учетная запись</th>
                                <th scope="col">Действия</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($all_doctors as $doctor)
                                <tr>
                                    <th scope="row">{{$doctor->id}}</th>
                                    <td>{{$doctor->name}}</td>
                                    <td>{{$doctor->specialty->name ?? 'Не указана'}}</td>
                                    <td>{{$doctor->cabinet_number ?? '-'}}</td>
                                    <td>
                                        @if($doctor->is_active)
                                            <span class="badge bg-success">Работает</span>
                                        @else
                                            <span class="badge bg-secondary">В отпуске</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($doctor->user)
                                            <span class="badge bg-success">Есть</span><br>
                                            <small class="text-muted">Логин: {{ $doctor->user->pole }}</small>
                                        @else
                                            <span class="badge bg-warning">Нет</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#doctorModal" onclick="viewDoctor({{$doctor->id}})">Просмотреть</button>
                                        <form action="{{route('destroy.doctor', $doctor->id)}}" method="POST" style="display: inline-block;" onsubmit="return confirm('Вы уверены, что хотите удалить этого врача?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                        @if($all_doctors->isEmpty())
                            <p>Врачи пока не добавлены.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab" tabindex="0">
                        <h3>Наши пользователи:</h3>

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Имя</th>
                                <th scope="col">Полюс</th>
                                <th scope="col">Роль</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($all_users as $user)
                                <tr>
                                    <th scope="row">{{$user->id}}</th>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->pole}}</td>
                                    <td>
                                        @if($user->role == 'admin')
                                            <span class="badge bg-danger">Администратор</span>
                                        @elseif($user->role == 'doctor')
                                            <span class="badge bg-primary">Врач</span>
                                        @else
                                            <span class="badge bg-secondary">Пациент</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#userModal" onclick="viewUser({{$user->id}})">Просмотреть</button>
                                    </td>
                                    <td>
                                        @if($user->id !== Auth::id())
                                            <form action="{{route('destroy.user', $user->id)}}" method="POST" style="display: inline-block;" onsubmit="return confirm('Вы уверены, что хотите удалить этого пользователя?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                            </form>
                                        @else
                                            <small class="text-muted">Нельзя удалить</small>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                        @if($all_users->isEmpty())
                            <p>Пользователи пока не зарегистрированы.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="v-pills-specialty" role="tabpanel" aria-labelledby="v-pills-specialty-tab" tabindex="0">

                        <form action="{{route('store.specialty')}}" method="post">
                            @csrf
                            <label>Название специальности:</label>
                            <input type="text" name="specialty">
                            <button>Добавить специальность</button>
                        </form>

                        <h3>Наши специальности:</h3>

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Специальность</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($all_specialty as $specialty)
                                <tr>
                                    <th scope="row">{{$specialty->id}}</th>
                                    <td>{{$specialty->name}}</td>
                                    <td>
                                        <form action="{{route('destroy.specialty', $specialty->id)}}" method="POST" style="display: inline-block;" onsubmit="return confirm('Вы уверены, что хотите удалить эту специальность?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                        @if($all_specialty->isEmpty())
                            <p>Специальности пока не добавлены.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="v-pills-admin" role="tabpanel" aria-labelledby="v-pills-admin-tab" tabindex="0">
                        <h3>Добавить администратора</h3>

                        <form action="{{route('store.admin')}}" method="post" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label for="admin_name" class="form-label">Имя администратора:</label>
                                <input type="text" name="name" id="admin_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="admin_pole" class="form-label">Полюс (логин):</label>
                                <input type="text" name="pole" id="admin_pole" class="form-control" required>
                                <small class="text-muted">Используется для входа в систему</small>
                            </div>
                            <div class="mb-3">
                                <label for="admin_password" class="form-label">Пароль:</label>
                                <input type="password" name="password" id="admin_password" class="form-control" required minlength="6">
                                <small class="text-muted">Минимум 6 символов</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Добавить администратора</button>
                        </form>

                        <h3>Администраторы:</h3>

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Имя</th>
                                <th scope="col">Полюс (логин)</th>
                                <th scope="col">Дата создания</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($all_admins as $admin)
                                <tr>
                                    <th scope="row">{{$admin->id}}</th>
                                    <td>{{$admin->name}}</td>
                                    <td>{{$admin->pole}}</td>
                                    <td>{{$admin->created_at->format('d.m.Y H:i')}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                        @if($all_admins->isEmpty())
                            <p>Администраторы пока не добавлены.</p>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно для просмотра врача -->
    <div class="modal fade" id="doctorModal" tabindex="-1" aria-labelledby="doctorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="doctorModalLabel">Информация о враче</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="doctorModalBody">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Загрузка...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно для просмотра пользователя -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Информация о пользователе</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="userModalBody">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Загрузка...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewDoctor(id) {
            const modalBody = document.getElementById('doctorModalBody');
            modalBody.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Загрузка...</span></div></div>';

            fetch(`/admin/doctor/${id}`)
                .then(response => response.json())
                .then(data => {
                    modalBody.innerHTML = `
                        <div class="mb-3">
                            <strong>ID:</strong> ${data.id}
                        </div>
                        <div class="mb-3">
                            <strong>Имя:</strong> ${data.name}
                        </div>
                        <div class="mb-3">
                            <strong>Специальность:</strong> ${data.specialty}
                        </div>
                        <div class="mb-3">
                            <strong>Кабинет:</strong> ${data.cabinet_number || 'Не указан'}
                        </div>
                        <div class="mb-3">
                            <strong>Статус:</strong> ${data.is_active ? '<span class="badge bg-success">Работает</span>' : '<span class="badge bg-secondary">В отпуске</span>'}
                        </div>
                        <div class="mb-3">
                            <strong>Дата создания:</strong> ${data.created_at}
                        </div>
                        ${data.user ? `
                            <hr>
                            <h6>Привязанный пользователь:</h6>
                            <div class="mb-2">
                                <strong>Имя:</strong> ${data.user.name}
                            </div>
                            <div class="mb-2">
                                <strong>Полюс:</strong> ${data.user.pole}
                            </div>
                        ` : '<div class="mb-3"><em>Пользователь не привязан</em></div>'}
                    `;
                })
                .catch(error => {
                    modalBody.innerHTML = '<div class="alert alert-danger">Ошибка при загрузке данных о враче</div>';
                });
        }

        function viewUser(id) {
            const modalBody = document.getElementById('userModalBody');
            modalBody.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Загрузка...</span></div></div>';

            fetch(`/admin/user/${id}`)
                .then(response => response.json())
                .then(data => {
                    let roleBadge = '';
                    if (data.role === 'admin') {
                        roleBadge = '<span class="badge bg-danger">Администратор</span>';
                    } else if (data.role === 'doctor') {
                        roleBadge = '<span class="badge bg-primary">Врач</span>';
                    } else {
                        roleBadge = '<span class="badge bg-secondary">Пациент</span>';
                    }

                    modalBody.innerHTML = `
                        <div class="mb-3">
                            <strong>ID:</strong> ${data.id}
                        </div>
                        <div class="mb-3">
                            <strong>Имя:</strong> ${data.name}
                        </div>
                        <div class="mb-3">
                            <strong>Полюс (логин):</strong> ${data.pole}
                        </div>
                        <div class="mb-3">
                            <strong>Роль:</strong> ${roleBadge}
                        </div>
                        <div class="mb-3">
                            <strong>Дата регистрации:</strong> ${data.created_at}
                        </div>
                        <div class="mb-3">
                            <strong>Количество записей:</strong> ${data.appointments_count}
                        </div>
                        ${data.doctor ? `
                            <hr>
                            <h6>Профиль врача:</h6>
                            <div class="mb-2">
                                <strong>Имя врача:</strong> ${data.doctor.name}
                            </div>
                            <div class="mb-2">
                                <strong>Специальность:</strong> ${data.doctor.specialty}
                            </div>
                        ` : ''}
                    `;
                })
                .catch(error => {
                    modalBody.innerHTML = '<div class="alert alert-danger">Ошибка при загрузке данных о пользователе</div>';
                });
        }
    </script>

@endsection
