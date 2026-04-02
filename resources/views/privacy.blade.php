@extends('loyaut')

@section('title', 'Персональные данные')

@section('main')
<x-public-page active="legal" main-class="flex flex-col gap-10 px-4 pt-8 sm:px-6 lg:gap-12 lg:px-8 lg:pt-10">
    <section class="overflow-hidden rounded-[28px] bg-[linear-gradient(135deg,_#0f172a_0%,_#0f3b73_45%,_#137fec_100%)] text-white shadow-2xl">
        <div class="grid gap-8 px-6 py-10 sm:px-10 lg:grid-cols-[1.1fr_0.9fr] lg:px-12 lg:py-14">
            <div class="flex flex-col gap-5">
                <span class="inline-flex w-fit items-center rounded-full bg-white/10 px-4 py-2 text-sm font-semibold tracking-wide text-sky-100">
                    Политика обработки данных
                </span>
                <h1 class="max-w-3xl text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">
                    Персональные данные пациентов и посетителей сайта
                </h1>
                <p class="max-w-2xl text-base leading-7 text-slate-200 sm:text-lg">
                    Здесь размещены базовые положения политики обработки персональных данных, информация о целях сбора данных и правах субъекта персональных данных.
                </p>
            </div>
            <div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-1">
                <div class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Основание</p>
                    <p class="mt-2 text-2xl font-bold">152-ФЗ</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Оператор</p>
                    <p class="mt-2 text-2xl font-bold">ООО «Поликлиника»</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-100">Контакт</p>
                    <p class="mt-2 text-2xl font-bold">info@poliklinika.ru</p>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Общие положения</p>
            <div class="mt-5 space-y-4 text-sm leading-7 text-slate-700">
                <p>Оператором персональных данных является медицинская организация, размещающая настоящий сайт и осуществляющая обработку персональных данных в целях записи на приём, обратной связи, ведения учёта обращений и исполнения требований законодательства.</p>
                <p>Настоящая страница является публичной частью политики обработки персональных данных и должна быть дополнена внутренним полным документом оператора с указанием ответственного лица, перечня процессов обработки и мер защиты информации.</p>
                <p>Использование форм на сайте означает, что пользователь ознакомлен с порядком обработки его данных в объёме, необходимом для оказания медицинских и информационных услуг.</p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Какие данные могут собираться</p>
            <div class="mt-5 grid gap-4">
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-lg font-bold text-slate-900">Контактные данные</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">ФИО, номер телефона, email, дата рождения и иные сведения, которые пользователь указывает при регистрации или записи на приём.</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-lg font-bold text-slate-900">Данные обращений</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Сведения о выбранном враче, времени приёма, комментариях к визиту и истории взаимодействия с клиникой через сайт.</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-lg font-bold text-slate-900">Технические данные</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Сведения о сессии, cookie, действиях пользователя на сайте и иных технических параметрах, необходимых для корректной работы сервиса.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Цели обработки</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">Зачем клиника обрабатывает персональные данные</h2>
            </div>
            <div class="grid gap-4">
                <div class="rounded-2xl border border-slate-200 p-5">
                    <p class="text-lg font-bold text-slate-900">Запись на приём и сопровождение пациента</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Чтобы пользователь мог выбрать врача, дату, время визита и получать подтверждение записи.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 p-5">
                    <p class="text-lg font-bold text-slate-900">Обратная связь и ответы на обращения</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Для связи с пациентом по вопросам записи, документов, жалоб и запросов.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 p-5">
                    <p class="text-lg font-bold text-slate-900">Исполнение требований законодательства</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Для соблюдения обязательных требований в сфере здравоохранения и защиты персональных данных.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-6 md:grid-cols-3">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Права субъекта</p>
            <p class="mt-3 text-2xl font-bold text-slate-900">Запрос, уточнение, отзыв</p>
            <p class="mt-3 text-sm leading-6 text-slate-600">Пользователь вправе запросить сведения об обработке данных, уточнить их или отозвать согласие в случаях, предусмотренных законом.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Меры защиты</p>
            <p class="mt-3 text-2xl font-bold text-slate-900">Организационные и технические</p>
            <p class="mt-3 text-sm leading-6 text-slate-600">Оператор обязан применять меры защиты данных от неправомерного доступа, изменения, распространения и утраты.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Важно</p>
            <p class="mt-3 text-2xl font-bold text-slate-900">Требуются реальные документы</p>
            <p class="mt-3 text-sm leading-6 text-slate-600">Перед запуском нужно подготовить полную утверждённую политику ПДн, согласия на обработку и тексты для форм сайта.</p>
        </div>
    </section>
</x-public-page>
@endsection
