<section id="contacts" class="px-4 sm:px-6 lg:px-8">
    <footer class="mt-8 border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-2">
                        <div class="text-primary">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" fill="currentColor"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-slate-900">Поликлиника</h2>
                    </div>
                    <p class="text-sm text-slate-600">Ваше здоровье, понятный сервис и внимательное отношение в одной клинике.</p>
                </div>
                <div>
                    <h3 class="mb-4 text-base font-bold text-slate-900">Навигация</h3>
                    <ul class="space-y-2">
                        <li><a class="text-sm text-slate-600 transition-colors hover:text-primary no-underline" href="{{ route('main') }}">Главная</a></li>
                        <li><a class="text-sm text-slate-600 transition-colors hover:text-primary no-underline" href="{{ route('doctors.index') }}">Врачи</a></li>
                        <li><a class="text-sm text-slate-600 transition-colors hover:text-primary no-underline" href="{{ route('about') }}">О нас</a></li>
                        <li><a class="text-sm text-slate-600 transition-colors hover:text-primary no-underline" href="{{ route('contacts') }}">Контакты</a></li>
                        <li><a class="text-sm text-slate-600 transition-colors hover:text-primary no-underline" href="{{ route('legal') }}">Юридическая информация</a></li>
                        <li><a class="text-sm text-slate-600 transition-colors hover:text-primary no-underline" href="{{ route('privacy') }}">Персональные данные</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-4 text-base font-bold text-slate-900">Контакты</h3>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-base">location_on</span><span>г. Москва, ул. Примерная, д. 1</span></li>
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-base">call</span><span>+7 (495) 123-45-67</span></li>
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-base">mail</span><span>info@poliklinika.ru</span></li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-4 text-base font-bold text-slate-900">Часы работы</h3>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li>Пн-Пт: 08:00 - 20:00</li>
                        <li>Сб: 09:00 - 18:00</li>
                        <li>Вс: Выходной</li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 border-t border-slate-200 pt-8 text-center text-sm text-slate-500">
                <p>© 2026 Поликлиника. Все права защищены.</p>
            </div>
        </div>
    </footer>
</section>
