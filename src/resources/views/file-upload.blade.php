<div>
    <x-modal
        x-on:close_tallapp_upload_modal.window="$modalClose('tallapp-file-upload-modal')"
        x-on:close="$wire.call('uploadModalWasClosed')"

        id="tallapp-file-upload-modal"
        z-index="z-40"
        persistent>
        <x-slot:title>
            Novo upload
        </x-slot:title>

        <form class="grid grid-cols-12 gap-6">
            <div class="col-span-12">
                <x-input wire:model="original_name" id="original_name" label="Nome:" hint="Opcional" />
            </div>
            <div class="col-span-12">
                <x-tag wire:model="tags" id="tags" label="Tags:" hint="Palavras chaves que o ajuda encontrar este arquivo separados por vírgulas." />
            </div>
            <div class="col-span-12">
                <x-upload wire:model="file" id="file" delete delete-method="deleteUploadedFile"
                    accept="*" hint="Aceita {{ implode(', ', \Ernandesrs\TallAppFilesManager\Models\File::allowedExtensions(merged: true)) }}.">
                    <x-slot:footer when-uploaded>
                        <x-button class="w-full" wire:click="saveFile">
                            Salvar
                        </x-button>
                    </x-slot:footer>
                </x-upload>
            </div>
        </form>

        <x-slot:footer>
            <x-button x-on:click="$modalClose('tallapp-file-upload-modal')" text="Fechar" icon="x" color="rose"
                sm />
        </x-slot:footer>
    </x-modal>

    <x-button x-on:click="$modalOpen('tallapp-file-upload-modal')" class="lg:hidden" icon="arrow-up" />
    <x-button x-on:click="$modalOpen('tallapp-file-upload-modal')" class="hidden lg:flex" icon="arrow-up"
        text="Upload" />
</div>
