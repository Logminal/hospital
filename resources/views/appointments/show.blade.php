@extends('loyaut')

@section('title', 'Запись к врачу - ' . $doctor->name)

@section('main')
<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
    <div class="flex flex-1 justify-center">
        <div class="flex w-full max-w-6xl flex-col">
            <header class="sticky top-0 z-50 flex items-center justify-between border-b border-slate-200 bg-white/85 px-4 py-4 backdrop-blur-sm sm:px-6 lg:px-8">
                <div class="flex items-center gap-4 text-slate-900">
                    <div class="text-primary">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" fill="currentColor"></path>
                        </svg>
                    </div>
                    <a href="{{ route('main') }}" class="text-xl font-bold tracking-tight text-slate-900 no-underline">Поликлиника</a>
                </div>
                <nav class="hidden items-center gap-8 md:flex">
                    <a class="text-sm font-medium text-slate-700 transition-colors hover:text-primary no-underline" href="{{ route('main') }}">Главная</a>
                    <a class="text-sm font-medium text-primary no-underline" href="{{ route('doctors.index') }}">Врачи</a>
                    <a class="text-sm font-medium text-slate-700 transition-colors hover:text-primary no-underline" href="{{ route('about') }}">О нас</a>
                    <a class="text-sm font-medium text-slate-700 transition-colors hover:text-primary no-underline" href="{{ route('contacts') }}">Контакты</a>
                </nav>
                <div class="flex items-center gap-3">
                    <a href="{{ route('doctors.index') }}" class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-200 bg-white px-4 text-sm font-semibold tracking-wide text-slate-700 no-underline transition-colors hover:bg-slate-50">
                        Ко всем врачам
                    </a>
                </div>
            </header>

            <main class="flex flex-col gap-10 px-4 pt-8 sm:px-6 lg:gap-12 lg:px-8 lg:pt-10">
                <section class="overflow-hidden rounded-[30px] bg-[linear-gradient(135deg,_#0f172a_0%,_#0f3b73_42%,_#137fec_100%)] text-white shadow-2xl">
                    <div class="grid gap-8 px-6 py-10 sm:px-10 lg:grid-cols-[0.92fr_1.08fr] lg:px-12 lg:py-14">
                        <div class="relative overflow-hidden rounded-[28px] border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                            <div
                                class="h-[380px] w-full rounded-[22px] bg-cover bg-center"
                                style="background-image: url('{{ $doctor->photo_url ?? 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=1200&q=80' }}');"
                            ></div>
                            <div class="absolute left-8 top-8">
                                <span class="inline-flex items-center rounded-full bg-white/90 px-4 py-2 text-xs font-bold uppercase tracking-[0.24em] text-slate-800 shadow-sm">
                                    {{ $doctor->specialty->name ?? 'Специалист' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col justify-center gap-5">
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="inline-flex items-center rounded-full bg-emerald-400/20 px-4 py-2 text-sm font-semibold text-emerald-100">
                                    <span class="material-symbols-outlined mr-2 !text-[18px]">verified</span>
                                    Ведёт приём
                                </span>
                                <span class="inline-flex items-center rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-sky-100">
                                    Онлайн-запись доступна
                                </span>
                            </div>

                            <div>
                                <h1 class="max-w-3xl text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">{{ $doctor->name }}</h1>
                                <p class="mt-4 max-w-2xl text-base leading-7 text-slate-200 sm:text-lg">
                                    Специалист по направлению «{{ $doctor->specialty->name ?? 'Консультация' }}». На этой странице можно быстро посмотреть информацию о враче и сразу выбрать дату и время приёма.
                                </p>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-3">
                                <div class="rounded-2xl border border-white/10 bg-white/8 p-5">
                                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Специальность</p>
                                    <p class="mt-2 text-xl font-bold">{{ $doctor->specialty->name ?? 'Не указана' }}</p>
                                </div>
                                <div class="rounded-2xl border border-white/10 bg-white/8 p-5">
                                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Кабинет</p>
                                    <p class="mt-2 text-xl font-bold">{{ $doctor->cabinet_number ?: 'Уточняется' }}</p>
                                </div>
                                <div class="rounded-2xl border border-white/10 bg-white/8 p-5">
                                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Запись</p>
                                    <p class="mt-2 text-xl font-bold">Без звонка</p>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-3 pt-2">
                                <a href="#booking-card" class="inline-flex h-12 items-center justify-center rounded-xl bg-white px-6 text-sm font-bold tracking-wide text-slate-900 no-underline transition-colors hover:bg-slate-100">
                                    Выбрать время
                                </a>
                                <a href="{{ route('doctors.index') }}" class="inline-flex h-12 items-center justify-center rounded-xl border border-white/25 bg-white/5 px-6 text-sm font-bold tracking-wide text-white no-underline transition-colors hover:bg-white/10">
                                    Вернуться к списку
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="grid gap-6 lg:grid-cols-[0.82fr_1.18fr]">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Карточка врача</p>
                        <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">Коротко о специалисте</h2>
                        <div class="mt-6 grid gap-4">
                            <div class="rounded-2xl bg-slate-50 p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Направление</p>
                                <p class="mt-2 text-lg font-bold text-slate-900">{{ $doctor->specialty->name ?? 'Не указана' }}</p>
                                <p class="mt-2 text-sm leading-6 text-slate-600">Консультации, диагностика и сопровождение в рамках профиля врача.</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Формат приёма</p>
                                <p class="mt-2 text-lg font-bold text-slate-900">Очный визит в клинике</p>
                                <p class="mt-2 text-sm leading-6 text-slate-600">Вы выбираете дату, затем видите доступные интервалы времени по расписанию врача.</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Кабинет</p>
                                <p class="mt-2 text-lg font-bold text-slate-900">{{ $doctor->cabinet_number ?: 'Уточняется на месте' }}</p>
                                <p class="mt-2 text-sm leading-6 text-slate-600">Если номер кабинета изменится, регистратура подскажет актуальную информацию.</p>
                            </div>
                        </div>
                    </div>

                    <div id="booking-card" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                        <div class="flex flex-col gap-2">
                            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Онлайн-запись</p>
                            <h2 class="text-3xl font-bold tracking-tight text-slate-900">Выберите дату и время приёма</h2>
                            <p class="text-sm leading-7 text-slate-600">
                                После выбора даты мы покажем только реальные свободные интервалы из расписания врача.
                            </p>
                        </div>

                        @if(session('error'))
                            <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-800">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('appointments.store') }}" method="POST" id="appointmentForm" class="mt-6 flex flex-col gap-6">
                            @csrf
                            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                            <div class="grid gap-5 lg:grid-cols-2">
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-medium text-slate-700">Дата приёма</span>
                                    <input
                                        type="date"
                                        class="h-14 rounded-2xl border border-slate-200 bg-slate-50 px-4 text-slate-900 focus:border-primary focus:bg-white focus:outline-none"
                                        id="appointment_date"
                                        name="appointment_date"
                                        value="{{ old('appointment_date') }}"
                                        min="{{ date('Y-m-d') }}"
                                        required
                                    >
                                </label>

                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-medium text-slate-700">Комментарий к визиту</span>
                                    <input
                                        type="text"
                                        class="h-14 rounded-2xl border border-slate-200 bg-slate-50 px-4 text-slate-900 placeholder:text-slate-400 focus:border-primary focus:bg-white focus:outline-none"
                                        id="notes"
                                        name="notes"
                                        value="{{ old('notes') }}"
                                        placeholder="Например, первичная консультация"
                                    >
                                </label>
                            </div>

                            <div>
                                <div class="flex items-center justify-between gap-3">
                                    <label for="appointment_time" class="text-sm font-medium text-slate-700">Время приёма</label>
                                    <div id="timeLoading" class="hidden text-sm font-medium text-slate-500">
                                        Загружаем доступные интервалы...
                                    </div>
                                </div>

                                <input type="hidden" id="appointment_time" name="appointment_time" value="{{ old('appointment_time') }}" required>

                                <div id="timeSlots" class="mt-4 flex min-h-[84px] flex-wrap gap-3 rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-4">
                                    <p class="mb-0 text-sm leading-6 text-slate-500">Сначала выберите дату, чтобы увидеть свободное время.</p>
                                </div>

                                <div id="timeError" class="mt-3 hidden rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"></div>
                            </div>

                            <div class="flex flex-wrap items-center gap-3">
                                <button type="submit" class="inline-flex h-12 items-center justify-center rounded-xl bg-primary px-6 text-sm font-bold tracking-wide text-white transition-opacity hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-50" id="submitBtn" disabled>
                                    Записаться на приём
                                </button>
                                <a href="{{ route('doctors.index') }}" class="inline-flex h-12 items-center justify-center rounded-xl border border-slate-200 px-6 text-sm font-semibold tracking-wide text-slate-700 no-underline transition-colors hover:bg-slate-50">
                                    Назад к врачам
                                </a>
                            </div>
                        </form>
                    </div>
                </section>
                @include('partials.public-footer')
            </main>
        </div>
    </div>
</div>

<script>
    const dateInput = document.getElementById('appointment_date');
    const timeInput = document.getElementById('appointment_time');
    const submitBtn = document.getElementById('submitBtn');
    const timeLoading = document.getElementById('timeLoading');
    const timeSlots = document.getElementById('timeSlots');
    const timeError = document.getElementById('timeError');
    const doctorId = {{ $doctor->id }};

    function renderMessage(message, tone = 'muted') {
        const palette = {
            muted: 'text-slate-500',
            error: 'text-red-700'
        };

        timeSlots.innerHTML = `<p class="mb-0 text-sm leading-6 ${palette[tone] || palette.muted}">${message}</p>`;
    }

    function resetTimeSelection() {
        timeInput.value = '';
        submitBtn.disabled = true;
    }

    function clearTimeError() {
        timeError.textContent = '';
        timeError.classList.add('hidden');
    }

    function showTimeError(message) {
        timeError.textContent = message;
        timeError.classList.remove('hidden');
    }

    function createTimeButton(time) {
        const button = document.createElement('button');
        button.type = 'button';
        button.textContent = time;
        button.dataset.time = time;
        button.className = 'inline-flex h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-700 transition-all hover:-translate-y-0.5 hover:border-primary hover:text-primary';

        button.addEventListener('click', function () {
            document.querySelectorAll('[data-time]').forEach((item) => {
                item.className = 'inline-flex h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-700 transition-all hover:-translate-y-0.5 hover:border-primary hover:text-primary';
            });

            this.className = 'inline-flex h-11 items-center justify-center rounded-xl border border-primary bg-primary px-4 text-sm font-semibold text-white shadow-sm';
            timeInput.value = time;
            submitBtn.disabled = false;
            clearTimeError();
        });

        return button;
    }

    function loadTimeSlots(selectedDate, selectedOldTime = null) {
        if (!selectedDate) {
            renderMessage('Сначала выберите дату, чтобы увидеть свободное время.');
            clearTimeError();
            resetTimeSelection();
            return;
        }

        timeLoading.classList.remove('hidden');
        clearTimeError();
        resetTimeSelection();
        renderMessage('Загружаем доступные интервалы...');

        fetch('{{ route("appointments.check") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                doctor_id: doctorId,
                date: selectedDate
            })
        })
        .then(async (response) => {
            const contentType = response.headers.get('content-type');

            if (!response.ok) {
                if (contentType && contentType.includes('application/json')) {
                    const data = await response.json();
                    throw new Error(data.message || data.error || 'Ошибка сервера');
                }

                throw new Error('Ошибка сервера');
            }

            return response.json();
        })
        .then((data) => {
            timeLoading.classList.add('hidden');

            if (data.error) {
                renderMessage(data.message || data.error, 'error');
                return;
            }

            const availableTimes = data.available_times || [];

            timeSlots.innerHTML = '';

            if (availableTimes.length === 0) {
                renderMessage('На выбранную дату свободных интервалов нет. Попробуйте другой день.');
                return;
            }

            availableTimes.forEach((time) => {
                timeSlots.appendChild(createTimeButton(time));
            });

            if (selectedOldTime) {
                const oldButton = document.querySelector(`[data-time="${selectedOldTime}"]`);
                if (oldButton) {
                    oldButton.click();
                }
            }
        })
        .catch((error) => {
            timeLoading.classList.add('hidden');
            renderMessage(error.message || 'Не удалось загрузить время приёма.', 'error');
        });
    }

    dateInput.addEventListener('change', function () {
        loadTimeSlots(this.value);
    });

    document.getElementById('appointmentForm').addEventListener('submit', function (event) {
        if (!timeInput.value) {
            event.preventDefault();
            showTimeError('Пожалуйста, выберите время приёма.');
        }
    });

    @if(old('appointment_date'))
        loadTimeSlots('{{ old('appointment_date') }}', '{{ old('appointment_time') }}');
    @endif
</script>
@endsection
