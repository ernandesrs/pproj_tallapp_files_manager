@php
    $uniqId = uniqid();
@endphp

<x-file-item
    x-data="{
        ...{{ json_encode([
            'wireId' => null,
            'id' => $tallFile->id,
            'text' => $tallFile->original_name,
        ]) }},

        init() {
            this.wireId = $el.getAttribute('wire:id')
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
    :file="true" :id="$tallFile->id" :text="$tallFile->original_name" :icon="$tallFile->type->icon()"
    :preview="$tallFile->type == \Ernandesrs\TallAppFilesManager\Enums\FileTypesEnum::IMAGE
        ? \Storage::url($tallFile->path)
        : null">

    <x-modal id="tallapp-item-detail-dialog-{{ $tallFile->id }}" z-index="z-40" persistent>
        <x-slot:title>
            Detalhes: {{ $tallFile->original_name }}
        </x-slot:title>
        <div class="mb-5">
            TallStackUi
        </div>
        <div class="flex justify-start">
            <x-button x-on:click="deleteConfirmation" icon="trash" text="Excluir item" color="rose" sm flat />
        </div>
        <x-slot:footer>
            <x-button x-on:click="$modalClose('tallapp-item-detail-dialog-{{ $tallFile->id }}')" icon="x"
                text="Fechar" color="rose" />
        </x-slot:footer>
    </x-modal>

    <x-modal id="tallapp-item-edit-dialog-{{ $tallFile->id }}" z-index="z-40" persistent>
        <x-slot:title>
            Editar: {{ $tallFile->original_name }}
        </x-slot:title>
        <div class="mb-5 grid grid-cols-12 gap-6">
            <div class="col-span-12">
                <x-input id="original_name_{{ $uniqId }}" wire:model="original_name" label="Nome original:" />
            </div>
            <div class="col-span-12">
                <x-input id="tags_{{ $uniqId }}" wire:model="tags" label="Tags:" />
            </div>
        </div>
        <div class="flex justify-between">
            <x-button wire:click="update" icon="check" text="Atualizar" />
            <x-button x-on:click="deleteConfirmation" icon="trash" text="Excluir item" color="rose" flat />
        </div>
        <x-slot:footer>
            <x-button x-on:click="$modalClose('tallapp-item-edit-dialog-{{ $tallFile->id }}')" icon="x"
                text="Fechar" color="rose" />
        </x-slot:footer>
    </x-modal>

    <div class="mt-3 flex gap-x-1">
        <x-button x-on:click="$modalOpen('tallapp-item-edit-dialog-{{ $tallFile->id }}')" icon="edit"
            color="primary"
            sm />
        <x-button x-on:click="$modalOpen('tallapp-item-detail-dialog-{{ $tallFile->id }}')" icon="list-details"
            color="primary"
            sm />
        <x-button x-on:click="deleteConfirmation" icon="trash" color="rose" sm />
    </div>

</x-file-item>
