@extends('loyaut')

@section('title', 'Профиль пациента')

@section('main')
<div class="app-dashboard">
    <div class="container">
        <div class="app-toolbar">
            <div class="app-toolbar-title">
                <h1>Профиль пациента</h1>
                <p class="app-toolbar-subtitle">Личные данные, контакты и краткая сводка по вашим записям в клинике.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('appointments.my') }}" class="btn btn-secondary">Мои записи</a>
                <a href="{{ route('doctors.index') }}" class="btn btn-primary">Записаться к врачу</a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">Выйти</button>
                </form>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="app-panel h-100 p-4">
                    <div class="d-flex flex-column gap-3">
                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 88px; height: 88px; font-size: 2rem; font-weight: 700;">
                            {{ mb_strtoupper(mb_substr($displayName, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="h3 mb-2">{{ $displayName }}</h2>
                            <p class="text-muted mb-0">Пациент клиники</p>
                        </div>
                    </div>

                    <div class="mt-4 d-grid gap-3">
                        <div class="rounded-4 border p-3 bg-body-tertiary">
                            <div class="small text-muted text-uppercase fw-semibold mb-1">Email</div>
                            <div class="fw-semibold">{{ $user->email ?: 'Не указан' }}</div>
                        </div>
                        <div class="rounded-4 border p-3 bg-body-tertiary">
                            <div class="small text-muted text-uppercase fw-semibold mb-1">Телефон</div>
                            <div class="fw-semibold">{{ $user->phone ?: 'Не указан' }}</div>
                        </div>
                        <div class="rounded-4 border p-3 bg-body-tertiary">
                            <div class="small text-muted text-uppercase fw-semibold mb-1">Дата рождения</div>
                            <div class="fw-semibold">{{ $user->birth_date ? $user->birth_date->format('d.m.Y') : 'Не указана' }}</div>
                        </div>
                        <div class="rounded-4 border p-3 bg-body-tertiary">
                            <div class="small text-muted text-uppercase fw-semibold mb-1">Пол</div>
                            <div class="fw-semibold">{{ $user->pole ?: 'Не указан' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="app-panel p-4 h-100">
                            <div class="small text-muted text-uppercase fw-semibold mb-2">Всего записей</div>
                            <div class="display-6 fw-bold mb-0">{{ $appointmentsCount }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="app-panel p-4 h-100">
                            <div class="small text-muted text-uppercase fw-semibold mb-2">Завершено</div>
                            <div class="display-6 fw-bold mb-0">{{ $completedAppointments }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="app-panel p-4 h-100">
                            <div class="small text-muted text-uppercase fw-semibold mb-2">Отменено</div>
                            <div class="display-6 fw-bold mb-0">{{ $cancelledAppointments }}</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="app-panel p-4">
                            <h3 class="h4 mb-3">Ближайший визит</h3>
                            @if($upcomingAppointment)
                                <div class="rounded-4 border p-4 bg-body-tertiary">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-8">
                                            <div class="fw-bold fs-5">{{ $upcomingAppointment->doctor->name }}</div>
                                            <div class="text-muted mt-1">{{ $upcomingAppointment->doctor->specialty->name ?? 'Специальность не указана' }}</div>
                                            <div class="mt-3">
                                                <span class="badge text-bg-primary me-2">{{ $upcomingAppointment->appointment_date->format('d.m.Y') }}</span>
                                                <span class="badge text-bg-light">{{ date('H:i', strtotime($upcomingAppointment->appointment_time)) }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <a href="{{ route('appointments.my') }}" class="btn btn-primary">Открыть мои записи</a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="rounded-4 border p-4 bg-body-tertiary text-muted">
                                    У вас пока нет ближайших визитов. Вы можете выбрать врача и записаться онлайн.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="app-panel p-4">
                            <h3 class="h4 mb-3">Быстрые действия</h3>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <a href="{{ route('doctors.index') }}" class="text-decoration-none">
                                        <div class="rounded-4 border p-4 h-100 bg-body-tertiary">
                                            <div class="fw-bold text-dark mb-2">Новая запись</div>
                                            <div class="text-muted small">Выберите специалиста и удобное время приёма.</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('appointments.my') }}" class="text-decoration-none">
                                        <div class="rounded-4 border p-4 h-100 bg-body-tertiary">
                                            <div class="fw-bold text-dark mb-2">История визитов</div>
                                            <div class="text-muted small">Посмотрите статусы записей, заключения и отмены.</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('contacts') }}" class="text-decoration-none">
                                        <div class="rounded-4 border p-4 h-100 bg-body-tertiary">
                                            <div class="fw-bold text-dark mb-2">Связаться с клиникой</div>
                                            <div class="text-muted small">Уточнить детали визита или задать вопрос регистратуре.</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
