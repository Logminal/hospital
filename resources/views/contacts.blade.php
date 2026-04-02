@extends('loyaut')

@section('title', 'Контакты')

@section('main')
<x-public-page active="contacts" main-class="flex flex-col gap-12 px-4 pt-8 sm:px-6 lg:gap-16 lg:px-8 lg:pt-10">
    <section class="overflow-hidden rounded-[28px] bg-slate-900 text-white shadow-2xl">
        <div class="grid gap-8 px-6 py-10 sm:px-10 lg:grid-cols-[1.2fr_0.8fr] lg:px-12 lg:py-14">
            <div class="flex flex-col gap-5">
                <span class="inline-flex w-fit items-center rounded-full bg-white/10 px-4 py-2 text-sm font-semibold tracking-wide text-sky-100">
                    Контакты и режим работы
                </span>
                <h1 class="max-w-2xl text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">
                    Мы рядом, если вам нужна помощь, консультация или запись на приём
                </h1>
                <p class="max-w-2xl text-base leading-7 text-slate-200 sm:text-lg">
                    Свяжитесь с регистратурой, уточните расписание специалистов или приезжайте в клинику. Мы собрали все основные контакты в одном месте.
                </p>
                <div class="flex flex-col gap-3 pt-2 sm:flex-row">
                    <a href="tel:+74951234567" class="inline-flex h-12 items-center justify-center rounded-xl bg-primary px-6 text-sm font-bold tracking-wide text-white no-underline transition-opacity hover:opacity-90">
                        Позвонить в регистратуру
                    </a>
                    <a href="{{ route('doctors.index') }}" class="inline-flex h-12 items-center justify-center rounded-xl border border-white/20 bg-white/5 px-6 text-sm font-bold tracking-wide text-white no-underline transition-colors hover:bg-white/10">
                        Записаться онлайн
                    </a>
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                    <p class="mb-2 text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Телефон</p>
                    <a href="tel:+74951234567" class="text-2xl font-bold text-white no-underline">+7 (495) 123-45-67</a>
                    <p class="mt-2 text-sm leading-6 text-slate-300">Регистратура отвечает ежедневно и помогает подобрать специалиста.</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                    <p class="mb-2 text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Почта</p>
                    <a href="mailto:info@poliklinika.ru" class="text-2xl font-bold text-white no-underline">info@poliklinika.ru</a>
                    <p class="mt-2 text-sm leading-6 text-slate-300">Подходит для справок, документов и обратной связи.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">Как нас найти</h2>
            <div class="mt-6 space-y-5">
                <div class="flex gap-4">
                    <div class="mt-1 text-primary">
                        <span class="material-symbols-outlined !text-[28px]">location_on</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Адрес</p>
                        <p class="mt-1 text-lg font-semibold text-slate-900">г. Москва, ул. Примерная, д. 1</p>
                        <p class="mt-1 text-sm leading-6 text-slate-600">Вход со стороны центрального бульвара, рядом есть парковка и остановка городского транспорта.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="mt-1 text-primary">
                        <span class="material-symbols-outlined !text-[28px]">schedule</span>
                    </div>
                    <div class="w-full">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Часы работы</p>
                        <div class="mt-2 grid gap-2 text-sm text-slate-700">
                            <div class="w-full flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3">
                                <span>Понедельник - Пятница</span>
                                <span class="font-semibold text-slate-900">08:00 - 20:00</span>
                            </div>
                            <div class="w-full flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3">
                                <span>Суббота</span>
                                <span class="font-semibold text-slate-900">09:00 - 18:00</span>
                            </div>
                            <div class="w-full flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3">
                                <span>Воскресенье</span>
                                <span class="font-semibold text-slate-900">Выходной</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="mt-1 text-primary">
                        <span class="material-symbols-outlined !text-[28px]">local_hospital</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Справка</p>
                        <p class="mt-1 text-sm leading-6 text-slate-600">Для срочных обращений и вопросов по действующим записям удобнее всего звонить в регистратуру. Для планового визита можно сразу перейти к онлайн-записи.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="h-full min-h-[420px] bg-[radial-gradient(circle_at_top_left,_rgba(19,127,236,0.18),_transparent_35%),linear-gradient(135deg,_#eff6ff_0%,_#ffffff_45%,_#f8fafc_100%)] p-6 sm:p-8">
                <div class="flex h-full flex-col justify-between rounded-[24px] border border-slate-200/80 bg-white/85 p-6 backdrop-blur">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Схема проезда</p>
                        <h2 class="mt-3 text-2xl font-bold tracking-tight text-slate-900">Клиника в центре города</h2>
                        <p class="mt-3 max-w-xl text-sm leading-6 text-slate-600">
                            Здесь можно разместить интерактивную карту или встроенный маршрут. Пока блок показывает ключевые ориентиры и помогает быстро понять, как добраться до клиники.
                        </p>
                    </div>
                    <div class="mt-8 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl bg-slate-900 p-5 text-white">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-100">Ближайшее метро</p>
                            <p class="mt-2 text-xl font-bold">Центральная</p>
                            <p class="mt-2 text-sm leading-6 text-slate-300">7 минут пешком от выхода №2.</p>
                        </div>
                        <div class="rounded-2xl bg-primary/10 p-5">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-primary">Парковка</p>
                            <p class="mt-2 text-xl font-bold text-slate-900">Для пациентов</p>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Есть гостевые места рядом с главным входом.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-6 md:grid-cols-3">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Регистратура</p>
            <p class="mt-3 text-2xl font-bold text-slate-900">Быстрые ответы</p>
            <p class="mt-3 text-sm leading-6 text-slate-600">Подскажем, какой специалист нужен, и подберём удобное окно для визита.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Документы</p>
            <p class="mt-3 text-2xl font-bold text-slate-900">Отправка на почту</p>
            <p class="mt-3 text-sm leading-6 text-slate-600">Справки, реквизиты и общие документы можно запросить по электронной почте.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Онлайн-запись</p>
            <p class="mt-3 text-2xl font-bold text-slate-900">Без звонка</p>
            <p class="mt-3 text-sm leading-6 text-slate-600">Если уже знаете врача, можно сразу перейти к списку специалистов и записаться онлайн.</p>
        </div>
    </section>
</x-public-page>
@endsection
