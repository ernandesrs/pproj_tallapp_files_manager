<?php

namespace Ernandesrs\TallAppFilesManager\Livewire;

use Ernandesrs\TallAppFilesManager\Models\File;
use Ernandesrs\TallAppFilesManager\Services\FileService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;
use TallStackUi\Traits\Interactions;

class FileUpload extends Component
{
    use WithFileUploads, Interactions;

    public string $original_name = "";

    public array $tags = [];

    /**
     * File
     * @var ?UploadedFile
     */
    public ?UploadedFile $file = null;

    /**
     * Render view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function render()
    {
        return view('tallapp-files-manager::file-upload');
    }

    /**
     * Save file
     * @return void
     */
    function saveFile()
    {
        $validated = $this->validate(FileService::createRules());

        $createdFile = FileService::create($validated);
        if (!$createdFile) {
            $this->toast()
                ->error('Erro!', 'Houve um erro ao salvar arquivo.')
                ->send();
            return;
        }

        $this->deleteUploadedFile(uploadedFile: $this->file);

        $this->dispatch('close_tallapp_upload_modal');

        $this->toast()
            ->success('Pronto!', 'Arquivo salvo com sucesso')
            ->send();
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
