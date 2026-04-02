@extends('loyaut')

@section('title', 'О нас')

@section('main')
<x-public-page active="about" main-class="flex flex-col gap-12 px-4 pt-8 sm:px-6 lg:gap-16 lg:px-8 lg:pt-10">
    <section class="overflow-hidden rounded-[28px] bg-[linear-gradient(135deg,_#0f172a_0%,_#0f3b73_45%,_#137fec_100%)] text-white shadow-2xl">
        <div class="grid gap-8 px-6 py-10 sm:px-10 lg:grid-cols-[1.1fr_0.9fr] lg:px-12 lg:py-14">
            <div class="flex flex-col gap-5">
                <span class="inline-flex w-fit items-center rounded-full bg-white/10 px-4 py-2 text-sm font-semibold tracking-wide text-sky-100">
                    О клинике
                </span>
                <h1 class="max-w-2xl text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">
                    Современная поликлиника, где медицинская помощь строится вокруг человека
                </h1>
                <p class="max-w-2xl text-base leading-7 text-slate-200 sm:text-lg">
                    Мы объединяем удобный сервис, опытных специалистов и понятные цифровые процессы, чтобы пациенту было спокойно на каждом этапе: от записи до завершения лечения.
                </p>
                <div class="flex flex-col gap-3 pt-2 sm:flex-row">
                    <a href="{{ route('doctors.index') }}" class="inline-flex h-12 items-center justify-center rounded-xl bg-white px-6 text-sm font-bold tracking-wide text-slate-900 no-underline transition-colors hover:bg-slate-100">
                        Выбрать врача
                    </a>
                    <a href="{{ route('contacts') }}" class="inline-flex h-12 items-center justify-center rounded-xl border border-white/25 bg-white/5 px-6 text-sm font-bold tracking-wide text-white no-underline transition-colors hover:bg-white/10">
                        Связаться с нами
                    </a>
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-1">
                <div class="rounded-2xl border border-white/10 bg-white/8 p-5">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">10+ лет</p>
                    <p class="mt-2 text-2xl font-bold">Заботы о пациентах</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/8 p-5">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">20+ врачей</p>
                    <p class="mt-2 text-2xl font-bold">Разных направлений</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/8 p-5">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Онлайн-запись</p>
                    <p class="mt-2 text-2xl font-bold">Без лишних звонков</p>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Наша миссия</p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">Делать медицинскую помощь понятной, своевременной и уважительной</h2>
            <p class="mt-4 text-sm leading-7 text-slate-600">
                Мы строим клинику так, чтобы пациенту не приходилось разбираться в сложных процессах. Запись, навигация по услугам, работа с расписанием и общение с врачом должны быть простыми и прозрачными.
            </p>
            <p class="mt-4 text-sm leading-7 text-slate-600">
                Для нас важно не только качество лечения, но и то, как человек чувствует себя во время взаимодействия с клиникой: от первого звонка до итоговых рекомендаций после приёма.
            </p>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Что для нас важно</p>
            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-lg font-bold text-slate-900">Точность</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Работаем по понятным маршрутам лечения и опираемся на современные диагностические подходы.</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-lg font-bold text-slate-900">Доступность</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Помогаем быстро записаться, уточнить детали визита и получить информацию без лишних шагов.</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-lg font-bold text-slate-900">Командная работа</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Терапевты, узкие специалисты и администраторы работают как единая система вокруг пациента.</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-lg font-bold text-slate-900">Комфорт</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Поддерживаем спокойную среду в клинике и аккуратную коммуникацию на каждом этапе визита.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="grid gap-6 lg:grid-cols-[1fr_1fr_1fr]">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">История</p>
                <h2 class="mt-3 text-2xl font-bold tracking-tight text-slate-900">Клиника, которая выросла из потребности в понятной медицине</h2>
            </div>
            <div class="text-sm leading-7 text-slate-600">
                Мы начинали как небольшая амбулаторная команда, которая хотела сократить дистанцию между пациентом и врачом. Постепенно вокруг этого подхода сформировалась полноценная поликлиника с несколькими направлениями помощи.
            </div>
            <div class="text-sm leading-7 text-slate-600">
                Сегодня мы продолжаем развивать сервис: улучшаем запись, наводим порядок в расписании, делаем личные кабинеты удобнее и сохраняем фокус на уважительном отношении к каждому человеку.
            </div>
        </div>
    </section>

    <section class="grid gap-6 md:grid-cols-3">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Пациентам</p>
            <p class="mt-3 text-2xl font-bold text-slate-900">Понятный маршрут</p>
            <p class="mt-3 text-sm leading-6 text-slate-600">Вы легко находите врача, записываетесь онлайн и видите историю своих визитов в одном месте.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Врачам</p>
            <p class="mt-3 text-2xl font-bold text-slate-900">Организованная работа</p>
            <p class="mt-3 text-sm leading-6 text-slate-600">Расписание, статусы приёмов и заключения собраны в цифровом кабинете без лишней рутины.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Команде</p>
            <p class="mt-3 text-2xl font-bold text-slate-900">Единая система</p>
            <p class="mt-3 text-sm leading-6 text-slate-600">Администраторы, врачи и пациенты работают в общей логике, где процессы не мешают оказанию помощи.</p>
        </div>
    </section>
</x-public-page>
@endsection
