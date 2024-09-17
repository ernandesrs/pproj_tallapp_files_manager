<?php

namespace Ernandesrs\TallAppFilesManager\Livewire;

use Ernandesrs\TallAppFilesManager\Services\FileService;
use Ernandesrs\TallAppFilesManager\Traits\Authorization;
use Ernandesrs\TallAppFilesManager\Models\File;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;
use TallStackUi\Traits\Interactions;

class FileUpload extends Component
{
    use WithFileUploads, Interactions, Authorization;

    public string $original_name = "";

    public array $tags = [];

    /**
     * File
     * @var ?UploadedFile
     */
    public ?UploadedFile $file = null;

    /**
     * Render view
     * @return string|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function render()
    {
        if (!$this->checkAuthorization('create', File::class, true)) {
            return <<<'HTML'
            <div>
            </div>
            HTML;
        }

        return view('tallapp-files-manager::file-upload');
    }

    /**
     * Save file
     * @return void
     */
    function saveFile()
    {
        $this->checkAuthorization('create', File::class);

        $validated = $this->validate(FileService::createRules());

        $createdFile = FileService::create($validated);

        $this->deleteUploadedFile(uploadedFile: $this->file);
        if (!$createdFile) {
            $this->toast()
                ->error(
                    __('tallapp-files-manager::all.toast.creation_fails.title'),
                    __('tallapp-files-manager::all.toast.creation_fails.description')
                )->send();
            return;
        }

        $this->dispatch('close_tallapp_upload_modal');

        $this->toast()
            ->success(
                __('tallapp-files-manager::all.toast.creation.title'),
                __('tallapp-files-manager::all.toast.creation.description')
            )->send();
    }

    /**
     * Upload modal was closed
     * * This method is called on upload modal was closed
     * @return void
     */
    function uploadModalWasClosed()
    {
        if ($this->file) {
            $this->deleteUploadedFile(uploadedFile: $this->file);
        }

        $this->file = null;
        $this->tags = [];
        $this->original_name = "";

        $this->resetErrorBag();
    }

    /**
     * Delete uploaded file
     * The $content contains:
     * [
     *    'temporary_name',
     *    'real_name',
     *    'extension',
     *    'size',
     *    'path',
     *    'url',
     *  ]
     * @return void
     */
    function deleteUploadedFile(
        array $content = [
            'temporary_name' => null,
            'real_name' => null,
            'extension' => null,
            'size' => null,
            'path' => null,
            'url' => null,
        ],
        ?UploadedFile $uploadedFile = null
    ): void {
        if ($uploadedFile) {
            $content = [
                'temporary_name' => $uploadedFile->getFilename(),
                'real_name' => $uploadedFile->getRealPath(),
                'extension' => $uploadedFile->getExtension(),
                'size' => $uploadedFile->getSize(),
                'path' => $uploadedFile->getPath(),
                'url' => null,
            ];
        }

        if (!$this->file) {
            return;
        }

        $files = Arr::wrap($this->file);

        /** @var UploadedFile $file */
        $file = collect($files)->filter(fn(UploadedFile $item) => $item->getFilename() === $content['temporary_name'])->first();

        // 1. Here we delete the file. Even if we have a error here, we simply
        // ignore it because as long as the file is not persisted, it is
        // temporary and will be deleted at some point if there is a failure here.
        rescue(fn() => $file->delete(), report: false);

        $collect = collect($files)->filter(fn(UploadedFile $item) => $item->getFilename() !== $content['temporary_name']);

        // 2. We guarantee restore of remaining files regardless of upload
        // type, whether you are dealing with multiple or single uploads
        $this->file = is_array($this->file) ? $collect->toArray() : $collect->first();
    }
}
