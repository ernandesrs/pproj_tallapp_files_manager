@props([
    'id' => null,
    'show' => true,
    'file' => false,
    'text' => null,
    'icon' => null,
    'preview' => null,
])

@php
    $getShortName = function ($text) {
        return $text;
    };
@endphp

<div
    class="relative overflow-hidden col-span-6 sm:col-span-4 md:col-span-3 xl:col-span-2 flex flex-col gap-y-3 gap-x-2 justify-center items-center border dark:border-zinc-700 duration-200 px-5 py-3 rounded cursor-default h-[130px] {{ $file ? 'bg-zinc-50 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700' : 'bg-zinc-300 dark:bg-zinc-900 hover:bg-zinc-200 dark:hover:bg-zinc-800' }}"
    {{ $attributes }}>

    @if (!$show)
        <div
            class="absolute z-10 top-0 left-0 opacity-75 bg-zinc-300 dark:bg-zinc-900 w-full h-full flex justify-center items-center">
            <x-icon name="eye-off" class="w-8 h-6 lg:w-12 lg:h-10" />
        </div>
    @else
        <div
            class="relative {{ !$show ? 'pointer-events-none opacity-5' : '' }} z-0 w-full flex gap-y-2 {{ $file ? 'flex-col' : '' }} justify-center items-center">
            <div class="flex justify-center">
                @if ($file && $preview)
                    <div
                        class="relative overflow-hidden ring ring-offset-1 ring-zinc-200 dark:ring-zinc-700 w-8 h-6 lg:w-12 lg:h-10 rounded">
                        <img class="w-[60px] absolute top-0 left-0" src="{{ $preview }}"
                            alt="{{ $text }} Preview" />
                    </div>
                @else
                    <x-icon name="{{ $icon }}" class="w-8 h-6 lg:w-12 lg:h-10" />
                @endif
            </div>
            <div class="w-full inline-flex truncate">
                {{ $file ? $getShortName($text) : $text }}
            </div>
        </div>

        {{ $slot }}
    @endif
</div>
