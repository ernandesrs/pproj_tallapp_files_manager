@props([
    'id' => null,
    'file' => false,
    'text' => null,
    'icon' => null,
])

<div
    x-data="{
        ...{{ json_encode([
            'wireId' => null,
            'id' => $id,
            'text' => $text,
        ]) }},

        init() {
            this.wireId = $el.getAttribute('wire:id');
        },

        deleteConfirmation() {
            $interaction('dialog')
                .wireable(this.wireId)
                .warning('Excluir ' + this.text + '?', 'Isso não pode ser desfeito, confirme para continuar.')
                .confirm('Confirmar', 'deletionConfirmed', this.id)
                .cancel('Cancelar')
                .send();
        }
    }"

    class="col-span-6 sm:col-span-4 md:col-span-3 xl:col-span-2 flex flex-col gap-x-2 items-center border dark:border-zinc-700 duration-200 px-5 py-3 rounded cursor-pointer {{ $file ? 'bg-zinc-50 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700' : 'bg-zinc-300 dark:bg-zinc-900 hover:bg-zinc-200 dark:hover:bg-zinc-800' }}"
    {{ $attributes }}>

    <x-modal id="tallapp-item-detail-dialog-{{ $id }}" z-index="z-40" persistent>
        <x-slot:title>
            Detalhes: {{ $text }}
        </x-slot:title>
        <div class="mb-5">
            TallStackUi
        </div>
        <div class="flex justify-start">
            <x-button x-on:click="deleteConfirmation" icon="trash" text="Excluir item" color="rose" sm flat />
        </div>
        <x-slot:footer>
            <x-button x-on:click="$modalClose('tallapp-item-detail-dialog-{{ $id }}')" icon="x"
                text="Fechar" color="rose" />
        </x-slot:footer>
    </x-modal>

    <x-modal id="tallapp-item-edit-dialog-{{ $id }}" z-index="z-40" persistent>
        <x-slot:title>
            Editar: {{ $text }}
        </x-slot:title>
        <div class="mb-5">
            TallStackUi
        </div>
        <div class="flex justify-start">
            <x-button x-on:click="deleteConfirmation" icon="trash" text="Excluir item" color="rose" sm flat />
        </div>
        <x-slot:footer>
            <x-button x-on:click="$modalClose('tallapp-item-edit-dialog-{{ $id }}')" icon="x"
                text="Fechar" color="rose" />
        </x-slot:footer>
    </x-modal>

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
            <x-button x-on:click="$modalOpen('tallapp-item-edit-dialog-{{ $id }}')" icon="edit"
                color="primary"
                sm />
            <x-button x-on:click="$modalOpen('tallapp-item-detail-dialog-{{ $id }}')" icon="list-details"
                color="primary"
                sm />
            <x-button x-on:click="deleteConfirmation" icon="trash" color="rose" sm />
        </div>
    @endif
</div>
