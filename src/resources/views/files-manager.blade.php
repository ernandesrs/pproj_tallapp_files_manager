<div class="grid bg-zinc-100 dark:text-zinc-400 dark:bg-zinc-800 ring-1 ring-zinc-300 dark:ring-zinc-700 rounded-md">

    @component('tallapp-files-manager::includes.container', [
        'header' => true,
    ])
        <div class="flex-1 flex flex-col md:flex-row">
            <div class="flex-1 flex items-center mb-4">
                <div class="">
                    <div class="text-sm text-zinc-400 mb-2">Você está em:</div>
                    <nav class="flex items-center gap-x-2 px-2 text-zinc-500">
                        @php
                            $paths = [['text' => 'Home'], ...$paths];
                        @endphp
                        @foreach ($paths as $key => $path)
                            <a wire:navigate class="flex gap-x-1 items-center duration-200 hover:text-zinc-700"
                                href="{{ $path['href'] ?? null }}"
                                title="Ir para {{ $path['text'] ?? '' }}">
                                @if ($path['icon'] ?? false)
                                    <x-icon name="{{ $path['icon'] }}" />
                                @endif
                                @if ($path['text'] ?? false)
                                    <span>{{ $path['text'] }}</span>
                                @endif
                                @isset($paths[$key + 1])
                                    <span>/</span>
                                @endisset
                            </a>
                        @endforeach
                    </nav>
                </div>
            </div>
            <div class="md:ml-auto flex justify-start items-center gap-x-2">
                <form class="flex-1 flex items-center gap-x-2">

                    <div class=" md:min-w-[125px]">
                        <x-input wire:model.live.debounce.500="search" placeholder="Buscar" />
                    </div>
                    <div class=" md:min-w-[125px]">
                        <x-select.native wire:model.live.debounce.500="type" placeholder="Tipos" :options="$typeOptions"
                            select="label:label|value:value" />
                    </div>
                </form>

                <livewire:file-upload />
            </div>
        </div>
    @endcomponent

    @component('tallapp-files-manager::includes.container')
        <div class="flex-1">
            @if (count($directores ?? []))
                <div class="grid grid-cols-12 gap-2 mb-5">
                    @foreach ($directories as $key => $dir)
                        @component('tallapp-files-manager::includes.item', [
                            'text' => $dir['name'],
                            'icon' => $dir['icon'],
                        ])
                        @endcomponent
                    @endforeach
                </div>
            @endif
            <div class="grid grid-cols-12 gap-2">
                @if (count($files))
                    @foreach ($files as $key => $file)
                        <livewire:file-item wire:key="{{ $file->id }}" id="{{ $file->id }}" />
                    @endforeach
                @else
                    <div class="text-lg text-center col-span-12 text-zinc-400">
                        Nada para listar
                    </div>
                @endif
            </div>
        </div>
    @endcomponent

    @component('tallapp-files-manager::includes.container', ['footer' => true])
    @endcomponent
</div>
