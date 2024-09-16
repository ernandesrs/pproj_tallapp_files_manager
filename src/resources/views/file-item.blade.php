@php
    $uniqId = uniqid();
@endphp

<x-file-item
    x-data="{
        ...{{ json_encode([
            'wireId' => null,
            'id' => $file->id,
            'text' => $file->original_name,
        ]) }},
        videoPlayer: null,

        init() {
            this.wireId = $el.getAttribute('wire:id')

            $nextTick(() => {
                this.videoPlayer = $el.querySelector('.videoPlayer')
            });
        },

        fileDetailDialogWasClosed() {
            if (!this.videoPlayer) {
                return
            }

            this.videoPlayer.pause()
        },

        deleteConfirmation() {
            $interaction('dialog')
                .wireable(this.wireId)
                .warning('Excluir ' + this.text + '?', 'Isso não pode ser desfeito, confirme para continuar.')
                .confirm('Confirmar', 'deletionConfirmed')
                .cancel('Cancelar')
                .send();
        }
    }"
    :show="$this->checkAuthorization('view', $file, true)"
    :file="true"
    :id="$file->id ?? null"
    :text="$file->original_name ?? null"
    :icon="$file->type ?? null ? $file->type->icon() : null"
    :preview="$file->type == \Ernandesrs\TallAppFilesManager\Enums\FileTypesEnum::IMAGE
        ? \Storage::url($file->path)
        : null">

    @if ($this->checkAuthorization('view', $file, true))
        <x-modal
            x-on:close="fileDetailDialogWasClosed"
            id="tallapp-item-detail-dialog-{{ $file->id }}" z-index="z-40" persistent>
            <x-slot:title>
                Detalhes: {{ $file->original_name }}
            </x-slot:title>
            <div class="mb-5 grid grid-cols-12 gap-x-6 gap-y-3">
                <div class="col-span-6">
                    <div class="text-xs text-zinc-400 mb-1">Nome:</div>
                    <div class="w-full truncate">{{ $file->original_name }}</div>
                </div>

                <div class="col-span-3">
                    <div class="text-xs text-zinc-400 mb-1">Extensão:</div>
                    <div>{{ $file->extension }}</div>
                </div>

                <div class="col-span-3">
                    <div class="text-xs text-zinc-400 mb-1">Tamanho:</div>
                    <div>{{ number_format($file->size / (1024 * 1024), 2) }} MB</div>
                </div>

                <div class="col-span-6">
                    <div class="text-xs text-zinc-400 mb-1">Tags:</div>
                    <div class="w-full">{{ implode(', ', $file->tags) }}</div>
                </div>

                <div class="col-span-6">
                    <div class="text-xs text-zinc-400 mb-1">Data de upload:</div>
                    <div>{{ $file->created_at->format('d/m/Y H:i:s') }}</div>
                </div>

                <div class="col-span-12">
                    <div class="text-xs text-zinc-400 mb-1">Previsualização:</div>

                    <div
                        class="relative overflow-hidden flex items-center justify-center p-2 w-full h-[350px] rounded-md">
                        @switch($file->type)
                            @case(\Ernandesrs\TallAppFilesManager\Enums\FileTypesEnum::IMAGE)
                                <img class="absolute h-full" src="{{ \Storage::url($file->path) }}"
                                    alt="{{ $file->original_name }} Preview">
                            @break

                            @case(\Ernandesrs\TallAppFilesManager\Enums\FileTypesEnum::DOCUMENT)
                                <a href="{{ \Storage::url($file->path) }}" target="_blank"
                                    title="{{ $file->original_name }}">
                                    Ver arquivo
                                </a>
                            @break

                            @case(\Ernandesrs\TallAppFilesManager\Enums\FileTypesEnum::VIDEO)
                                <video class="h-full videoPlayer" src="{{ \Storage::url($file->path) }}" preload="metadata"
                                    controlslist="nodownload noremoteplayback" crossorigin="use-credentials"
                                    controls></video>
                            @break

                            @default
                        @endswitch
                    </div>
                </div>
            </div>
            <x-slot:footer>
                <x-button x-on:click="$modalClose('tallapp-item-detail-dialog-{{ $file->id }}')" icon="x"
                    text="Fechar" color="rose" />
            </x-slot:footer>
        </x-modal>

        @if ($this->checkAuthorization('update', $file, true))
            <x-modal id="tallapp-item-edit-dialog-{{ $file->id }}" z-index="z-40" persistent>
                <x-slot:title>
                    Editar: {{ $file->original_name }}
                </x-slot:title>
                <div class="mb-5 grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <x-input id="original_name_{{ $uniqId }}" wire:model="original_name"
                            label="Nome original:" />
                    </div>
                    <div class="col-span-12">
                        <x-tag id="tags_{{ $uniqId }}" wire:model="tags" label="Tags:" />
                    </div>
                </div>
                <div class="flex justify-between">
                    <x-button wire:click="update" icon="check" text="Atualizar" />
                    <x-button x-on:click="deleteConfirmation" icon="trash" text="Excluir item" color="rose" flat />
                </div>
                <x-slot:footer>
                    <x-button x-on:click="$modalClose('tallapp-item-edit-dialog-{{ $file->id }}')" icon="x"
                        text="Fechar" color="rose" />
                </x-slot:footer>
            </x-modal>
        @endif
    @endif

    <div class="flex gap-x-1">
        @if ($this->checkAuthorization('update', $file, true))
            <x-button x-on:click="$modalOpen('tallapp-item-edit-dialog-{{ $file->id }}')" icon="edit"
                color="primary"
                sm />
        @endif
        @if ($this->checkAuthorization('view', $file, true))
            <x-button x-on:click="$modalOpen('tallapp-item-detail-dialog-{{ $file->id }}')" icon="list-details"
                color="primary"
                sm />
        @endif
        @if ($this->checkAuthorization('delete', $file, true))
            <x-button x-on:click="deleteConfirmation" icon="trash" color="rose" sm />
        @endif
    </div>

</x-file-item>
