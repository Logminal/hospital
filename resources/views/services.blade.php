@extends('loyaut')

@section('title', 'Услуги')

@section('main')
<x-public-page active="services" main-class="flex flex-col gap-10 px-4 pt-8 sm:px-6 lg:gap-12 lg:px-8 lg:pt-10">
    <section class="overflow-hidden rounded-[28px] bg-[linear-gradient(135deg,_#0f172a_0%,_#0f3b73_45%,_#137fec_100%)] text-white shadow-2xl">
        <div class="grid gap-8 px-6 py-10 sm:px-10 lg:grid-cols-[1.1fr_0.9fr] lg:px-12 lg:py-14">
            <div class="flex flex-col gap-5">
                <span class="inline-flex w-fit items-center rounded-full bg-white/10 px-4 py-2 text-sm font-semibold tracking-wide text-sky-100">
                    Медицинские направления
                </span>
                <h1 class="max-w-3xl text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">
                    Услуги клиники: от первичной консультации до диагностики и сопровождения лечения
                </h1>
                <p class="max-w-2xl text-base leading-7 text-slate-200 sm:text-lg">
                    Мы собрали ключевые медицинские направления в одной клинике, чтобы пациент мог быстро понять, куда обратиться и как записаться на приём.
                </p>
                <div class="flex flex-wrap gap-3 pt-2">
                    <a href="{{ route('doctors.index') }}" class="inline-flex h-12 items-center justify-center rounded-xl bg-white px-6 text-sm font-bold tracking-wide text-slate-900 no-underline transition-colors hover:bg-slate-100">
                        Выбрать врача
                    </a>
                    <a href="{{ route('contacts') }}" class="inline-flex h-12 items-center justify-center rounded-xl border border-white/25 bg-white/5 px-6 text-sm font-bold tracking-wide text-white no-underline transition-colors hover:bg-white/10">
                        Уточнить услугу
                    </a>
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-1">
                <div class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Консультации</p>
                    <p class="mt-2 text-2xl font-bold">По записи</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Диагностика</p>
                    <p class="mt-2 text-2xl font-bold">Современный подход</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Запись</p>
                    <p class="mt-2 text-2xl font-bold">Онлайн 24/7</p>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <article class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
            <img class="h-56 w-full object-cover" src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=900&q=80" alt="Терапия">
            <div class="p-6">
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Терапия</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">Первичный приём, оценка состояния, маршрутизация пациента и сопровождение лечения при распространённых заболеваниях.</p>
            </div>
        </article>

        <article class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
            <img class="h-56 w-full object-cover" src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=900&q=80" alt="Кардиология">
            <div class="p-6">
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Кардиология</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">Консультации по вопросам сердечно-сосудистой системы, профилактика, контроль состояния и рекомендации по терапии.</p>
            </div>
        </article>

        <article class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
            <img class="h-56 w-full object-cover" src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=900&q=80" alt="Стоматология">
            <div class="p-6">
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Стоматология</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">Плановые осмотры, диагностика, лечение и поддержание здоровья полости рта для взрослых и детей.</p>
            </div>
        </article>

        <article class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
            <img class="h-56 w-full object-cover" src="https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=900&q=80" alt="Диагностика">
            <div class="p-6">
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Диагностика</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">Современные методы обследования, которые помогают врачу быстрее уточнить диагноз и подобрать тактику лечения.</p>
            </div>
        </article>
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Как выбрать направление</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">Если не уверены, к какому специалисту идти</h2>
            </div>
            <div class="grid gap-4">
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-lg font-bold text-slate-900">Начните с терапевта</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Терапевт поможет оценить жалобы, назначить базовую диагностику и при необходимости направит к узкому специалисту.</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-lg font-bold text-slate-900">Уточните у регистратуры</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Если вопрос неочевидный, можно связаться с клиникой и получить помощь в выборе нужного направления.</p>
                </div>
            </div>
        </div>
    </section>
</x-public-page>
@endsection
