@props([
    'active' => 'main',
    'mainClass' => 'flex flex-col gap-10 px-4 pt-8 sm:px-6 lg:gap-12 lg:px-8 lg:pt-10',
])

<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
    <div class="flex flex-1 justify-center">
        <div class="flex w-full max-w-6xl flex-col">
            @include('partials.public-header', ['active' => $active])

            <main class="{{ $mainClass }}">
                {{ $slot }}
                @include('partials.public-footer')
            </main>
        </div>
    </div>
</div>
