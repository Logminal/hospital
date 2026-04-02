@php
    $active = $active ?? 'main';

    $navItems = [
        ['key' => 'main', 'label' => 'Главная', 'route' => route('main')],
        ['key' => 'services', 'label' => 'Услуги', 'route' => route('services')],
        ['key' => 'doctors', 'label' => 'Врачи', 'route' => route('doctors.index')],
        ['key' => 'about', 'label' => 'О нас', 'route' => route('about')],
        ['key' => 'contacts', 'label' => 'Контакты', 'route' => route('contacts')],
        ['key' => 'legal', 'label' => 'Юр. информация', 'route' => route('legal')],
    ];
@endphp

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
        @foreach($navItems as $item)
            <a
                class="text-sm font-medium no-underline transition-colors {{ $active === $item['key'] ? 'text-primary' : 'text-slate-700 hover:text-primary' }}"
                href="{{ $item['route'] }}"
            >
                {{ $item['label'] }}
            </a>
        @endforeach
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
