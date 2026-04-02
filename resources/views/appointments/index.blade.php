@extends('loyaut')

@section('title', 'Врачи')

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
                    <a class="text-sm font-medium text-slate-700 transition-colors hover:text-primary no-underline" href="{{ route('services') }}">Услуги</a>
                    <a class="text-sm font-medium text-primary no-underline" href="{{ route('doctors.index') }}">Врачи</a>
                    <a class="text-sm font-medium text-slate-700 transition-colors hover:text-primary no-underline" href="{{ route('about') }}">О нас</a>
                    <a class="text-sm font-medium text-slate-700 transition-colors hover:text-primary no-underline" href="{{ route('contacts') }}">Контакты</a>
                </nav>
                <div class="flex items-center gap-3">
                    <a href="tel:+74951234567" class="hidden h-10 items-center justify-center rounded-lg bg-slate-100 px-4 text-sm font-bold tracking-wide text-slate-800 transition-colors hover:bg-slate-200 sm:flex no-underline">
                        +7 (495) 123-45-67
                    </a>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('adminPanel') }}" class="flex h-10 items-center justify-center rounded-lg bg-primary px-4 text-sm font-bold tracking-wide text-white transition-opacity hover:opacity-90 no-underline">Личный кабинет</a>
                        @elseif(auth()->user()->isDoctor())
                            <a href="{{ route('doctor.appointments.index') }}" class="flex h-10 items-center justify-center rounded-lg bg-primary px-4 text-sm font-bold tracking-wide text-white transition-opacity hover:opacity-90 no-underline">Личный кабинет</a>
                        @else
                            <a href="{{ route('appointments.my') }}" class="flex h-10 items-center justify-center rounded-lg bg-primary px-4 text-sm font-bold tracking-wide text-white transition-opacity hover:opacity-90 no-underline">Личный кабинет</a>
                        @endif
                    @else
                        <a href="{{ route('auth') }}" class="flex h-10 items-center justify-center rounded-lg bg-primary px-4 text-sm font-bold tracking-wide text-white transition-opacity hover:opacity-90 no-underline">Личный кабинет</a>
                    @endauth
                </div>
            </header>

            <main class="flex flex-col gap-10 px-4 pt-8 sm:px-6 lg:gap-12 lg:px-8 lg:pt-10">
                <section class="overflow-hidden rounded-[28px] bg-[linear-gradient(135deg,_#0f172a_0%,_#0f3b73_45%,_#137fec_100%)] text-white shadow-2xl">
                    <div class="grid gap-8 px-6 py-10 sm:px-10 lg:grid-cols-[1.15fr_0.85fr] lg:px-12 lg:py-14">
                        <div class="flex flex-col gap-5">
                            <span class="inline-flex w-fit items-center rounded-full bg-white/10 px-4 py-2 text-sm font-semibold tracking-wide text-sky-100">
                                Подбор специалиста
                            </span>
                            <h1 class="max-w-3xl text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">
                                Найдите врача, которому можно доверить здоровье без лишних звонков и ожидания
                            </h1>
                            <p class="max-w-2xl text-base leading-7 text-slate-200 sm:text-lg">
                                Используйте поиск по имени и фильтр по специальности, чтобы быстро перейти к подходящему врачу и записаться на удобное время.
                            </p>
                            <div class="flex flex-wrap gap-3 pt-2">
                                <a href="#doctor-list" class="inline-flex h-12 items-center justify-center rounded-xl bg-white px-6 text-sm font-bold tracking-wide text-slate-900 no-underline transition-colors hover:bg-slate-100">
                                    Смотреть специалистов
                                </a>
                                <a href="{{ route('contacts') }}" class="inline-flex h-12 items-center justify-center rounded-xl border border-white/25 bg-white/5 px-6 text-sm font-bold tracking-wide text-white no-underline transition-colors hover:bg-white/10">
                                    Нужна помощь с выбором
                                </a>
                            </div>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-1">
                            <div class="rounded-2xl border border-white/10 bg-white/8 p-5">
                                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Специалисты</p>
                                <p class="mt-2 text-3xl font-black">{{ $doctors->count() }}</p>
                                <p class="mt-2 text-sm leading-6 text-slate-300">Активных врачей доступны для записи прямо сейчас.</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/8 p-5">
                                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Направления</p>
                                <p class="mt-2 text-3xl font-black">{{ $specialties->count() }}</p>
                                <p class="mt-2 text-sm leading-6 text-slate-300">Основных медицинских специальностей в нашей клинике.</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/8 p-5">
                                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Онлайн-запись</p>
                                <p class="mt-2 text-3xl font-black">24/7</p>
                                <p class="mt-2 text-sm leading-6 text-slate-300">Можно выбрать врача и перейти к записи в любое удобное время.</p>
                            </div>
                        </div>
                    </div>
                </section>

                @if(session('error'))
                    <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-800 shadow-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                    <div class="flex flex-col gap-2">
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Фильтры</p>
                        <h2 class="text-2xl font-bold tracking-tight text-slate-900">Подберите врача по имени или направлению</h2>
                    </div>

                    <form method="GET" action="{{ route('doctors.index') }}" class="mt-6 grid gap-4 lg:grid-cols-[1.3fr_0.7fr_auto_auto] lg:items-end">
                        <label class="flex flex-col gap-2">
                            <span class="text-sm font-medium text-slate-700">Поиск по имени</span>
                            <div class="flex h-14 items-center rounded-2xl border border-slate-200 bg-slate-50 px-4 focus-within:border-primary focus-within:bg-white">
                                <span class="material-symbols-outlined text-slate-400">search</span>
                                <input
                                    name="search"
                                    value="{{ $searchQuery }}"
                                    class="form-input w-full border-0 bg-transparent px-3 text-base text-slate-900 placeholder:text-slate-400 focus:outline-0 focus:ring-0"
                                    placeholder="Например, Иванов или Петрова"
                                />
                            </div>
                        </label>

                        <label class="flex flex-col gap-2">
                            <span class="text-sm font-medium text-slate-700">Специальность</span>
                            <select name="specialty" class="h-14 rounded-2xl border border-slate-200 bg-slate-50 px-4 text-slate-900 focus:border-primary focus:bg-white focus:outline-none">
                                <option value="all" {{ $selectedSpecialty == 'all' ? 'selected' : '' }}>Все специальности</option>
                                @foreach($specialties as $specialty)
                                    <option value="{{ $specialty->id }}" {{ $selectedSpecialty == $specialty->id ? 'selected' : '' }}>{{ $specialty->name }}</option>
                                @endforeach
                            </select>
                        </label>

                        <button type="submit" class="inline-flex h-14 items-center justify-center rounded-2xl bg-primary px-6 text-sm font-bold tracking-wide text-white transition-opacity hover:opacity-90">
                            Показать
                        </button>

                        <a href="{{ route('doctors.index') }}" class="inline-flex h-14 items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 text-sm font-semibold tracking-wide text-slate-700 no-underline transition-colors hover:bg-slate-50">
                            Сбросить
                        </a>
                    </form>

                    <div class="mt-6 flex gap-3 overflow-x-auto pb-1">
                        <a href="{{ route('doctors.index', ['specialty' => 'all', 'search' => $searchQuery]) }}" class="inline-flex h-11 shrink-0 items-center justify-center rounded-full px-5 text-sm font-semibold no-underline {{ $selectedSpecialty == 'all' ? 'bg-slate-900 text-white' : 'border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                            Все направления
                        </a>
                        @foreach($specialties as $specialty)
                            <a href="{{ route('doctors.index', ['specialty' => $specialty->id, 'search' => $searchQuery]) }}" class="inline-flex h-11 shrink-0 items-center justify-center rounded-full px-5 text-sm font-semibold no-underline {{ $selectedSpecialty == $specialty->id ? 'bg-slate-900 text-white' : 'border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                                {{ $specialty->name }}
                            </a>
                        @endforeach
                    </div>
                </section>

                <section id="doctor-list" class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Каталог врачей</p>
                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Доступные специалисты</h2>
                    </div>
                    <div class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm">
                        Найдено: {{ $doctors->count() }}
                    </div>
                </section>

                @if($doctors->isEmpty())
                    <section class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                        @if($selectedSpecialty != 'all' || $searchQuery)
                            <h3 class="text-2xl font-bold text-slate-900">По вашему запросу пока ничего не найдено</h3>
                            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">
                                Попробуйте сбросить фильтры или выбрать другое направление. Мы покажем всех доступных специалистов клиники.
                            </p>
                            <a href="{{ route('doctors.index') }}" class="mt-6 inline-flex h-12 items-center justify-center rounded-xl bg-primary px-5 text-sm font-bold tracking-wide text-white no-underline transition-opacity hover:opacity-90">
                                Показать всех врачей
                            </a>
                        @else
                            <h3 class="text-2xl font-bold text-slate-900">Список врачей скоро появится</h3>
                            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">
                                Сейчас специалисты ещё не добавлены в систему. Загляните позже или свяжитесь с регистратурой.
                            </p>
                        @endif
                    </section>
                @else
                    <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                        @foreach($doctors as $doctor)
                            <article class="group overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                                <div class="relative overflow-hidden">
                                    <div class="absolute inset-x-0 top-0 z-10 flex items-center justify-between px-5 pt-5">
                                        <span class="inline-flex items-center rounded-full bg-white/90 px-3 py-2 text-xs font-bold uppercase tracking-[0.22em] text-slate-700 shadow-sm">
                                            {{ $doctor->specialty->name ?? 'Специалист' }}
                                        </span>
                                        <span class="inline-flex items-center rounded-full bg-slate-900/85 px-3 py-2 text-sm font-semibold text-white shadow-sm">
                                            <span class="material-symbols-outlined mr-1 !text-[18px]">verified</span>
                                            Приём открыт
                                        </span>
                                    </div>
                                    <div class="h-72 w-full bg-[linear-gradient(180deg,_rgba(15,23,42,0.02)_0%,_rgba(15,23,42,0.18)_100%)]">
                                        <div
                                            class="h-full w-full bg-cover bg-center transition-transform duration-500 group-hover:scale-105"
                                            style="background-image: url('{{ $doctor->photo_url ?? 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=900&q=80' }}');"
                                        ></div>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-5 p-6">
                                    <div>
                                        <h3 class="text-2xl font-bold tracking-tight text-slate-900">{{ $doctor->name }}</h3>
                                        <p class="mt-2 text-sm leading-6 text-slate-600">
                                            Консультации, диагностика и план лечения в рамках направления {{ mb_strtolower($doctor->specialty->name ?? 'врача') }}.
                                        </p>
                                    </div>

                                    <div class="grid gap-3 sm:grid-cols-2">
                                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Кабинет</p>
                                            <p class="mt-2 text-base font-bold text-slate-900">{{ $doctor->cabinet_number ?: 'Уточняется' }}</p>
                                        </div>
                                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Запись</p>
                                            <p class="mt-2 text-base font-bold text-slate-900">Онлайн за 1 минуту</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Статус</p>
                                            <p class="mt-1 text-sm font-semibold text-slate-900">Готов к приёму пациентов</p>
                                        </div>
                                        <span class="rounded-full bg-emerald-100 px-3 py-2 text-xs font-bold uppercase tracking-[0.16em] text-emerald-700">
                                            Онлайн
                                        </span>
                                    </div>

                                    <a href="{{ route('doctor.show', $doctor->id) }}" class="inline-flex h-12 w-full items-center justify-center rounded-xl bg-primary px-5 text-sm font-bold tracking-wide text-white no-underline transition-opacity hover:opacity-90">
                                        Записаться
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </section>
                @endif
                @include('partials.public-footer')
            </main>
        </div>
    </div>
</div>
@endsection
