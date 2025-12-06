@extends("loyaut")

@section("title")
    Запись к врачу - {{ $doctor->name }}
@endsection

@section("main")
    <div class="container mt-4">
        <a href="{{ route('doctors.index') }}" class="btn btn-secondary mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Назад
        </a>
        <h1 class="mb-4">Запись на прием</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $doctor->name }}</h5>
                        <p class="card-text">
                            <strong>Специальность:</strong> {{ $doctor->specialty->name ?? 'Не указана' }}<br>
                            @if($doctor->cabinet_number)
                                <strong>Кабинет:</strong> {{ $doctor->cabinet_number }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Выберите дату и время</h5>

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('appointments.store') }}" method="POST" id="appointmentForm">
                            @csrf
                            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                            <div class="mb-3">
                                <label for="appointment_date" class="form-label">Дата приема:</label>
                                <input type="date" 
                                       class="form-control" 
                                       id="appointment_date" 
                                       name="appointment_date" 
                                       value="{{ old('appointment_date') }}"
                                       min="{{ date('Y-m-d') }}" 
                                       required>
                            </div>

                            <div class="mb-3">
                                <label for="appointment_time" class="form-label">Время приема:</label>
                                <input type="hidden" id="appointment_time" name="appointment_time" value="" required>
                                <div id="timeLoading" class="mb-2" style="display: none;">
                                    <small class="text-muted">Загрузка доступных времен...</small>
                                </div>
                                <div id="timeSlots" class="d-flex flex-wrap gap-2">
                                    <p class="text-muted mb-0">Сначала выберите дату</p>
                                </div>
                                <div id="timeError" class="text-danger mt-2" style="display: none;"></div>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Примечания (необязательно):</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Записаться на прием</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .time-slot-btn {
            min-width: 80px;
            transition: all 0.2s ease;
        }
        
        .time-slot-btn:not(:disabled):hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .time-slot-btn.btn-primary {
            font-weight: 600;
        }
        
        .time-slot-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>

    <script>
        const dateInput = document.getElementById('appointment_date');
        const timeInput = document.getElementById('appointment_time');
        const submitBtn = document.getElementById('submitBtn');
        const timeLoading = document.getElementById('timeLoading');
        const doctorId = {{ $doctor->id }};

        dateInput.addEventListener('change', function() {
            const selectedDate = this.value;
            
            if (!selectedDate) {
                timeInput.value = '';
                submitBtn.disabled = true;
                const timeError = document.getElementById('timeError');
                if (timeError) {
                    timeError.style.display = 'none';
                }
                return;
            }

            // Показываем индикатор загрузки
            timeLoading.style.display = 'block';
            timeInput.value = '';
            submitBtn.disabled = true;

            // Запрашиваем доступные времена
            fetch('{{ route("appointments.check") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    doctor_id: doctorId,
                    date: selectedDate
                })
            })
            .then(async response => {
                const contentType = response.headers.get("content-type");
                if (!response.ok) {
                    if (contentType && contentType.includes("application/json")) {
                        const data = await response.json();
                        throw new Error(data.message || data.error || 'Ошибка сервера');
                    } else {
                        const text = await response.text();
                        throw new Error('Ошибка сервера: ' + (text || response.statusText));
                    }
                }
                if (contentType && contentType.includes("application/json")) {
                    return response.json();
                } else {
                    throw new Error('Неверный формат ответа от сервера');
                }
            })
            .then(data => {
                timeLoading.style.display = 'none';
                
                const timeSlots = document.getElementById('timeSlots');
                
                if (data.error) {
                    timeSlots.innerHTML = `<p class="text-danger mb-0">Ошибка: ${data.message || data.error}</p>`;
                    const timeInput = document.getElementById('appointment_time');
                    timeInput.value = '';
                    submitBtn.disabled = true;
                    return;
                }
                
                // Генерируем все временные слоты (9:00 - 17:00, каждые 30 минут)
                const allSlots = [];
                for (let hour = 9; hour < 17; hour++) {
                    for (let minute = 0; minute < 60; minute += 30) {
                        const time = `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
                        allSlots.push(time);
                    }
                }
                
                const bookedTimes = data.booked_times || [];
                const availableTimes = data.available_times || [];
                
                // Очищаем контейнер
                timeSlots.innerHTML = '';
                
                if (allSlots.length === 0) {
                    timeSlots.innerHTML = '<p class="text-muted mb-0">Нет доступного времени на эту дату</p>';
                    const timeInput = document.getElementById('appointment_time');
                    timeInput.value = '';
                    submitBtn.disabled = true;
                    return;
                }
                
                // Создаем кнопки для каждого слота
                allSlots.forEach(time => {
                    const isBooked = bookedTimes.includes(time);
                    const isAvailable = availableTimes.includes(time);
                    
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'btn btn-sm time-slot-btn';
                    button.textContent = time;
                    button.dataset.time = time;
                    
                    if (isBooked || !isAvailable) {
                        // Занятое время - серый и неактивное
                        button.classList.add('btn-secondary');
                        button.disabled = true;
                        button.title = 'Занято';
                        button.style.opacity = '0.6';
                        button.style.cursor = 'not-allowed';
                    } else {
                        // Доступное время - активная кнопка
                        button.classList.add('btn-outline-primary');
                        button.addEventListener('click', function() {
                            // Убираем выделение с других кнопок
                            document.querySelectorAll('.time-slot-btn').forEach(btn => {
                                if (!btn.disabled) {
                                    btn.classList.remove('btn-primary');
                                    btn.classList.add('btn-outline-primary');
                                }
                            });
                            // Выделяем выбранную кнопку
                            this.classList.remove('btn-outline-primary');
                            this.classList.add('btn-primary');
                            // Устанавливаем значение в скрытое поле
                            timeInput.value = time;
                            // Скрываем ошибку, если была
                            const timeError = document.getElementById('timeError');
                            if (timeError) {
                                timeError.style.display = 'none';
                            }
                            submitBtn.disabled = false;
                        });
                    }
                    
                    timeSlots.appendChild(button);
                });
                
                if (availableTimes.length === 0) {
                    timeInput.value = '';
                    submitBtn.disabled = true;
                }
            })
            .catch(error => {
                timeLoading.style.display = 'none';
                const errorMessage = error.message || 'Ошибка при загрузке времени';
                const timeSlots = document.getElementById('timeSlots');
                timeSlots.innerHTML = `<p class="text-danger mb-0">${errorMessage}</p>`;
                const timeInput = document.getElementById('appointment_time');
                timeInput.value = '';
                submitBtn.disabled = true;
                console.error('Error:', error);
            });
        });

        // Добавляем CSRF токен в meta тег, если его нет
        if (!document.querySelector('meta[name="csrf-token"]')) {
            const meta = document.createElement('meta');
            meta.name = 'csrf-token';
            meta.content = '{{ csrf_token() }}';
            document.head.appendChild(meta);
        }

        // Предотвращаем отправку формы без выбранного времени
        document.getElementById('appointmentForm').addEventListener('submit', function(e) {
            const timeValue = timeInput.value;
            console.log('Отправка формы, выбранное время:', timeValue);
            if (!timeValue || timeValue.trim() === '') {
                e.preventDefault();
                const timeError = document.getElementById('timeError');
                if (timeError) {
                    timeError.textContent = 'Пожалуйста, выберите время приема';
                    timeError.style.display = 'block';
                }
                alert('Пожалуйста, выберите время приема');
                return false;
            }
        });
        
        // Восстанавливаем выбранное время при загрузке страницы (если была ошибка валидации)
        @if(old('appointment_time'))
            const oldTime = '{{ old("appointment_time") }}';
            const oldDate = '{{ old("appointment_date") }}';
            if (oldTime && oldDate) {
                // Устанавливаем дату
                dateInput.value = oldDate;
                // Триггерим событие change для загрузки слотов
                dateInput.dispatchEvent(new Event('change'));
                // Ждем загрузки слотов и выбираем время
                setTimeout(function() {
                    const timeBtn = document.querySelector(`[data-time="${oldTime}"]`);
                    if (timeBtn && !timeBtn.disabled) {
                        timeBtn.click();
                    }
                }, 1000);
            }
        @endif
    </script>
@endsection

