@extends('loyaut')

@section('title', 'Юридическая информация')

@section('main')
<x-public-page active="legal" main-class="flex flex-col gap-10 px-4 pt-8 sm:px-6 lg:gap-12 lg:px-8 lg:pt-10">
    <section class="overflow-hidden rounded-[28px] bg-[linear-gradient(135deg,_#0f172a_0%,_#1e3a8a_45%,_#137fec_100%)] text-white shadow-2xl">
        <div class="grid gap-8 px-6 py-10 sm:px-10 lg:grid-cols-[1.1fr_0.9fr] lg:px-12 lg:py-14">
            <div class="flex flex-col gap-5">
                <span class="inline-flex w-fit items-center rounded-full bg-white/10 px-4 py-2 text-sm font-semibold tracking-wide text-sky-100">
                    Обязательные сведения
                </span>
                <h1 class="max-w-3xl text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">
                    Юридическая информация о медицинской организации
                </h1>
                <p class="max-w-2xl text-base leading-7 text-slate-200 sm:text-lg">
                    На этой странице собраны основные регистрационные, лицензирующие и контактные сведения, которые обычно требуются пациентам, проверяющим органам и партнёрам клиники.
                </p>
            </div>
            <div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-1">
                <div class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Организация</p>
                    <p class="mt-2 text-2xl font-bold">ООО «Поликлиника»</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Лицензия</p>
                    <p class="mt-2 text-2xl font-bold">ЛО41-01111-77/00000000</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Режим работы</p>
                    <p class="mt-2 text-2xl font-bold">Пн-Сб</p>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Сведения об организации</p>
            <div class="mt-5 grid gap-4">
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Полное наименование</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">Общество с ограниченной ответственностью «Поликлиника»</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Сокращённое наименование</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">ООО «Поликлиника»</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Юридический и фактический адрес</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">109000, г. Москва, ул. Примерная, д. 1</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Учредитель</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">Частный учредитель / юридическое лицо</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Перед запуском на боевом контуре здесь нужно указать фактические сведения об учредителе.</p>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Реквизиты и контакты</p>
            <div class="mt-5 grid gap-4">
                <div class="flex items-start gap-4 rounded-2xl border border-slate-200 p-5">
                    <span class="material-symbols-outlined mt-1 text-primary">badge</span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">ОГРН</p>
                        <p class="mt-2 text-lg font-bold text-slate-900">1237700000000</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 rounded-2xl border border-slate-200 p-5">
                    <span class="material-symbols-outlined mt-1 text-primary">description</span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">ИНН / КПП</p>
                        <p class="mt-2 text-lg font-bold text-slate-900">7700000000 / 770001001</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 rounded-2xl border border-slate-200 p-5">
                    <span class="material-symbols-outlined mt-1 text-primary">call</span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Телефон и email</p>
                        <p class="mt-2 text-lg font-bold text-slate-900">+7 (495) 123-45-67</p>
                        <p class="mt-1 text-sm text-slate-600">info@poliklinika.ru</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 rounded-2xl border border-slate-200 p-5">
                    <span class="material-symbols-outlined mt-1 text-primary">schedule</span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Режим работы</p>
                        <p class="mt-2 text-lg font-bold text-slate-900">Пн-Пт: 08:00 - 20:00</p>
                        <p class="mt-1 text-sm text-slate-600">Сб: 09:00 - 18:00, Вс: выходной</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Лицензия</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">Сведения о лицензии на медицинскую деятельность</h2>
                <p class="mt-4 text-sm leading-7 text-slate-600">
                    Здесь должен размещаться номер лицензии, дата выдачи, лицензирующий орган и перечень работ, составляющих медицинскую деятельность организации.
                </p>
            </div>
            <div class="grid gap-4">
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Номер лицензии</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">ЛО41-01111-77/00000000</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Дата выдачи</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">01.01.2026</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Лицензирующий орган</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">Департамент здравоохранения субъекта РФ / Росздравнадзор</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Виды медицинской помощи</p>
                    <p class="mt-2 text-sm leading-7 text-slate-700">Амбулаторно-поликлиническая помощь, терапия, кардиология, стоматология, диагностика и иные направления в соответствии с лицензией.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-6 md:grid-cols-3">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Контролирующие органы</p>
            <p class="mt-3 text-2xl font-bold text-slate-900">Росздравнадзор</p>
            <p class="mt-3 text-sm leading-6 text-slate-600">Федеральная служба по надзору в сфере здравоохранения и региональные органы контроля.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Для пациентов</p>
            <p class="mt-3 text-2xl font-bold text-slate-900">Обратная связь</p>
            <p class="mt-3 text-sm leading-6 text-slate-600">Для претензий, обращений и вопросов по документам используйте официальный email и телефон регистратуры.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Важно</p>
            <p class="mt-3 text-2xl font-bold text-slate-900">Нужна замена на реальные данные</p>
            <p class="mt-3 text-sm leading-6 text-slate-600">Сейчас страница оформлена как структура под запуск. Перед релизом обязательно подставьте фактические юридические сведения организации.</p>
        </div>
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Связанный раздел</p>
                <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">Политика обработки персональных данных</h2>
                <p class="mt-2 max-w-2xl text-sm leading-7 text-slate-600">Для сайта с регистрацией, записью на приём и личным кабинетом этот раздел обязателен наряду с юридической информацией.</p>
            </div>
            <a href="{{ route('privacy') }}" class="inline-flex h-12 items-center justify-center rounded-xl bg-primary px-6 text-sm font-bold tracking-wide text-white no-underline transition-opacity hover:opacity-90">
                Открыть раздел
            </a>
        </div>
    </section>
</x-public-page>
@endsection
