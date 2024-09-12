@props([
    'id' => null,
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
    class="col-span-6 sm:col-span-4 md:col-span-3 xl:col-span-2 flex flex-col gap-x-2 items-center border dark:border-zinc-700 duration-200 px-5 py-3 rounded cursor-pointer {{ $file ? 'bg-zinc-50 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700' : 'bg-zinc-300 dark:bg-zinc-900 hover:bg-zinc-200 dark:hover:bg-zinc-800' }}"
    {{ $attributes }}>

    <div class="w-full flex gap-y-2 {{ $file ? 'flex-col' : '' }} justify-center items-center">
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
</div>
