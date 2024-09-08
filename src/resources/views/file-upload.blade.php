<div>
    <x-modal id="tallapp-file-upload-modal" persistent z-index="z-40">
        <x-slot:title>
            Novo upload
        </x-slot:title>

        <form>
            <x-upload wire:model="file" delete delete-method="deleteUploadedFile"
                accept="*"
                hint="Aceita: {{ implode(', ', config('tallapp-files-manager.allowed_extensions')) }}.">
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
