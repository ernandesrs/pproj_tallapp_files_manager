<div class="grid bg-zinc-100 dark:text-zinc-400 dark:bg-zinc-800 ring-1 ring-zinc-300 dark:ring-zinc-700 rounded-md">

    @component('tallapp-files-manager::includes.container', [
        'header' => true,
    ])
        <div class="flex-1"></div>
        <div class="ml-auto">
            <x-button class="lg:hidden" icon="arrow-up" />
            <x-button class="hidden lg:flex" icon="arrow-up" text="Upload" />
        </div>
    @endcomponent

    @component('tallapp-files-manager::includes.container')
        <div class="flex-1">
            <div class="grid grid-cols-12 gap-2 mb-5">
                @foreach (\Illuminate\Support\Collection::range(0, 10) as $key => $dir)
                    @component('tallapp-files-manager::includes.item', [
                        'text' => 'Dirname',
                        'icon' => 'folder',
                    ])
                    @endcomponent
                @endforeach
            </div>
            <div class="grid grid-cols-12 gap-2">
                @foreach (\Illuminate\Support\Collection::range(0, 11) as $key => $dir)
                    @php
                        $id = $key + 1;
                    @endphp
                    <livewire:file-item wire:id="{{ $id }}" id="{{ $id }}" icon="file"
                        text="#{{ $key + 1 }} Filena...jpg" />
                @endforeach
            </div>
        </div>
    @endcomponent
</div>
