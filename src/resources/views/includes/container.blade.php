@props([
    'header' => false,
    'footer' => false,
])

<div class="flex col-span-12 border-zinc-200 dark:border-zinc-700 px-5 py-3 {{ $header ? 'border-b' : ($footer ? 'border-t' : 'bg-zinc-50 dark:bg-zinc-800 py-5') }}">
    {{ $slot }}
</div>
