@props([
    'file' => false,
    'text' => null,
    'icon' => null,
])

<div
    class="col-span-6 sm:col-span-4 md:col-span-3 xl:col-span-2 flex flex-col gap-x-2 items-center border dark:border-zinc-700 duration-200 px-5 py-3 rounded cursor-pointer {{ $file ? 'bg-zinc-50 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700' : 'bg-zinc-300 dark:bg-zinc-900 hover:bg-zinc-200 dark:hover:bg-zinc-800' }}">
    <div class="w-full flex items-center">
        <div class="">
            <x-icon name="{{ $icon }}" class="w-5 sm:w-8" />
        </div>
        <div class="flex-1 inline-flex truncate">
            {{ $text }}
        </div>
    </div>
    @if ($file)
        <div class="mt-3 flex gap-x-1">
            <x-button icon="list-details" color="primary" sm />
            <x-button icon="trash" color="rose" sm />
        </div>
    @endif
</div>
