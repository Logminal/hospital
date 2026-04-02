@extends('loyaut')

@section('title', 'Главная')

@section('main')
@php
    $doctorPhotos = [
        'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1612531386530-97286d97c2d2?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1651008376811-b90baee60c1f?auto=format&fit=crop&w=900&q=80',
    ];
@endphp

<x-public-page active="main" main-class="flex flex-col gap-12 pb-0 pt-8 sm:gap-16 lg:gap-20 lg:pt-10">
    <section class="px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-[32px] bg-[linear-gradient(135deg,_rgba(15,23,42,0.85),_rgba(19,127,236,0.7)),url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=1400&q=80')] bg-cover bg-center px-6 py-10 text-white shadow-2xl sm:px-10 sm:py-14 lg:px-12 lg:py-16">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.16),_transparent_30%)]"></div>
            <div class="relative grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
                <div class="flex flex-col gap-5">
                    <span class="inline-flex w-fit items-center rounded-full bg-white/10 px-4 py-2 text-sm font-semibold tracking-wide text-sky-100">
                        Поликлиника рядом с вами
                    </span>
                    <h1 class="max-w-3xl text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">
                        Забота о здоровье без лишних звонков, очередей и сложных шагов
                    </h1>
                    <p class="max-w-2xl text-base leading-7 text-slate-200 sm:text-lg">
                        Запишитесь к нужному специалисту онлайн, узнайте режим работы клиники и быстро найдите врача по имени или направлению.
                    </p>

                    <form action="{{ route('doctors.index') }}" method="GET" class="mt-2 w-full max-w-2xl">
                        <div class="flex flex-col gap-3 rounded-2xl bg-white p-3 shadow-xl sm:flex-row sm:items-center">
                            <div class="flex h-14 flex-1 items-center rounded-xl bg-slate-50 px-4">
                                <span class="material-symbols-outlined text-slate-400">search</span>
                                <input
                                    type="text"
                                    name="search"
                                    class="form-input w-full border-0 bg-transparent px-3 text-base text-slate-900 placeholder:text-slate-400 focus:outline-0 focus:ring-0"
                                    placeholder="Найти врача по имени или специальности"
                                >
                            </div>
                            <button type="submit" class="inline-flex h-14 items-center justify-center rounded-xl bg-primary px-6 text-sm font-bold tracking-wide text-white transition-opacity hover:opacity-90">
                                Найти врача
                            </button>
                        </div>
                    </form>
                </div>

                <div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-1">
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Специалисты</p>
                        <p class="mt-2 text-3xl font-black">{{ $featuredDoctors->count() > 0 ? $featuredDoctors->count() . '+' : '0' }}</p>
                        <p class="mt-2 text-sm leading-6 text-slate-300">Активных врачей уже доступны для онлайн-записи.</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Режим работы</p>
                        <p class="mt-2 text-3xl font-black">08:00 - 20:00</p>
                        <p class="mt-2 text-sm leading-6 text-slate-300">Принимаем пациентов по будням и в субботу.</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Запись</p>
                        <p class="mt-2 text-3xl font-black">24/7</p>
                        <p class="mt-2 text-sm leading-6 text-slate-300">Оформляйте визит в удобное время без звонка в регистратуру.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            <div class="group flex flex-col gap-3 pb-3">
                <div class="overflow-hidden rounded-xl">
                    <img class="h-full w-full rounded-xl object-cover transition-transform duration-300 group-hover:scale-105" src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=900&q=80" alt="Терапия">
                </div>
                <div>
                    <p class="text-lg font-bold text-slate-900">Терапия</p>
                    <p class="text-sm text-slate-600">Комплексные консультации, диагностика и маршрутизация лечения.</p>
                </div>
            </div>
            <div class="group flex flex-col gap-3 pb-3">
                <div class="overflow-hidden rounded-xl">
                    <img class="h-full w-full rounded-xl object-cover transition-transform duration-300 group-hover:scale-105" src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=900&q=80" alt="Кардиология">
                </div>
                <div>
                    <p class="text-lg font-bold text-slate-900">Кардиология</p>
                    <p class="text-sm text-slate-600">Профилактика и поддержка здоровья сердца под наблюдением врача.</p>
                </div>
            </div>
            <div class="group flex flex-col gap-3 pb-3">
                <div class="overflow-hidden rounded-xl">
                    <img class="h-full w-full rounded-xl object-cover transition-transform duration-300 group-hover:scale-105" src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=900&q=80" alt="Стоматология">
                </div>
                <div>
                    <p class="text-lg font-bold text-slate-900">Стоматология</p>
                    <p class="text-sm text-slate-600">Плановые осмотры, лечение и забота о здоровой улыбке.</p>
                </div>
            </div>
            <div class="group flex flex-col gap-3 pb-3">
                <div class="overflow-hidden rounded-xl">
                    <img class="h-full w-full rounded-xl object-cover transition-transform duration-300 group-hover:scale-105" src="https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=900&q=80" alt="Диагностика">
                </div>
                <div>
                    <p class="text-lg font-bold text-slate-900">Диагностика</p>
                    <p class="text-sm text-slate-600">Современное оборудование и быстрые результаты для точных решений.</p>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <a href="{{ route('services') }}" class="inline-flex h-12 items-center justify-center rounded-xl border border-slate-200 bg-white px-6 text-sm font-semibold tracking-wide text-slate-700 no-underline transition-colors hover:bg-slate-50">
                Все услуги
            </a>
        </div>
    </section>

    <section id="about" class="px-4 sm:px-6 lg:px-8">
        <div class="rounded-[28px] bg-white p-6 sm:p-10">
            <div class="flex flex-col gap-3">
                <h2 class="max-w-2xl text-3xl font-bold leading-tight tracking-tight text-slate-900">Почему пациенты выбирают нас</h2>
                <p class="max-w-2xl text-base font-normal leading-normal text-slate-600">
                    Мы объединяем сильную врачебную команду, современную диагностику и понятный цифровой сервис, чтобы путь пациента был спокойным и предсказуемым.
                </p>
            </div>
            <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-background-light p-6">
                    <div class="text-primary"><span class="material-symbols-outlined !text-4xl">devices</span></div>
                    <div class="flex flex-col gap-1">
                        <h3 class="text-lg font-bold text-slate-900">Современное оборудование</h3>
                        <p class="text-sm leading-normal text-slate-600">Используем актуальные методы диагностики и лечения для уверенных решений.</p>
                    </div>
                </div>
                <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-background-light p-6">
                    <div class="text-primary"><span class="material-symbols-outlined !text-4xl">stethoscope</span></div>
                    <div class="flex flex-col gap-1">
                        <h3 class="text-lg font-bold text-slate-900">Опытные врачи</h3>
                        <p class="text-sm leading-normal text-slate-600">В клинике работают специалисты разных направлений, готовые вести пациента от первичной консультации до результата.</p>
                    </div>
                </div>
                <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-background-light p-6">
                    <div class="text-primary"><span class="material-symbols-outlined !text-4xl">location_on</span></div>
                    <div class="flex flex-col gap-1">
                        <h3 class="text-lg font-bold text-slate-900">Удобное расположение</h3>
                        <p class="text-sm leading-normal text-slate-600">Клиника находится в доступной части города, а вся контактная информация собрана на отдельной странице.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="doctors" class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between gap-4 pb-6">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Команда клиники</p>
                <h2 class="mt-2 text-3xl font-bold leading-tight tracking-tight text-slate-900">Наши специалисты</h2>
            </div>
            <a href="{{ route('doctors.index') }}" class="hidden items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-50 md:inline-flex no-underline">
                Все врачи
            </a>
        </div>

        @if($featuredDoctors->isEmpty())
            <div class="rounded-[28px] border border-slate-200 bg-white p-8 text-slate-600 shadow-sm">
                Врачи пока не добавлены в систему. Загляните позже или перейдите в раздел контактов, чтобы связаться с регистратурой.
            </div>
        @else
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($featuredDoctors as $doctor)
                    <article class="overflow-hidden rounded-[26px] border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative h-64 overflow-hidden">
                            <img
                                class="h-full w-full object-cover transition-transform duration-500 hover:scale-105"
                                src="{{ $doctor->photo_url ?? $doctorPhotos[$loop->index % count($doctorPhotos)] }}"
                                alt="{{ $doctor->name }}"
                            >
                            <div class="absolute left-4 top-4">
                                <span class="inline-flex rounded-full bg-white/90 px-3 py-2 text-xs font-bold uppercase tracking-[0.22em] text-slate-700 shadow-sm">
                                    {{ $doctor->specialty->name ?? 'Специалист' }}
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 p-5">
                            <div>
                                <h3 class="text-xl font-bold tracking-tight text-slate-900">{{ $doctor->name }}</h3>
                                <p class="mt-2 text-sm leading-6 text-slate-600">
                                    {{ $doctor->specialty->name ?? 'Специалист' }}. Кабинет: {{ $doctor->cabinet_number ?: 'уточняется' }}.
                                </p>
                            </div>
                            <a href="{{ route('doctor.show', $doctor->id) }}" class="inline-flex h-12 w-full items-center justify-center rounded-xl bg-primary px-5 text-sm font-bold tracking-wide text-white no-underline transition-opacity hover:opacity-90">
                                Записаться
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</x-public-page>
@endsection
