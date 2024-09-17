<div>
    <x-modal
        x-on:close_tallapp_upload_modal.window="$modalClose('tallapp-file-upload-modal')"
        x-on:close="$wire.call('uploadModalWasClosed')"

        id="tallapp-file-upload-modal"
        z-index="z-40"
        persistent>
        <x-slot:title>
            {{ __('tallapp-files-manager::all.new_upload') }}
        </x-slot:title>

        <form class="grid grid-cols-12 gap-6">
            <div class="col-span-12">
                <x-input wire:model="original_name" id="original_name" label="{{ __('tallapp-files-manager::all.name') }}:"
                    hint="{{ __('tallapp-files-manager::all.optional') }}" />
            </div>
            <div class="col-span-12">
                <x-tag wire:model="tags" id="tags" label="{{ __('tallapp-files-manager::all.tags') }}:"
                    hint="{{ __('tallapp-files-manager::all.tags_hint') }}" />
            </div>
            <div class="col-span-12">
                <x-upload wire:model="file" id="file" delete delete-method="deleteUploadedFile"
                    accept="*"
                    hint="{{ __('tallapp-files-manager::all.allows') }} {{ implode(', ', \Ernandesrs\TallAppFilesManager\Models\File::allowedExtensions(merged: true)) }}.">
                    <x-slot:footer when-uploaded>
                        <x-button class="w-full" wire:click="saveFile">
                            {{ __('tallapp-files-manager::all.save') }}
                        </x-button>
                    </x-slot:footer>
                </x-upload>
            </div>
        </form>

        <x-slot:footer>
            <x-button x-on:click="$modalClose('tallapp-file-upload-modal')"
                text="{{ __('tallapp-files-manager::all.close') }}" icon="x" color="rose"
                sm />
        </x-slot:footer>
    </x-modal>

    <x-button x-on:click="$modalOpen('tallapp-file-upload-modal')" class="lg:hidden" icon="arrow-up" />
    <x-button x-on:click="$modalOpen('tallapp-file-upload-modal')" class="hidden lg:flex" icon="arrow-up"
        text="{{ __('tallapp-files-manager::all.upload') }}" />
</div>
