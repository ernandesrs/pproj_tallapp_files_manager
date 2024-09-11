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

        <form>
            <x-upload wire:model="file" delete delete-method="deleteUploadedFile"
                accept="*">
                <x-slot:footer when-uploaded>
                    <x-button class="w-full" wire:click="saveFile">
                        Salvar
                    </x-button>
                </x-slot:footer>
            </x-upload>
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
