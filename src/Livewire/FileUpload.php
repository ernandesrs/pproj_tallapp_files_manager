<?php

namespace Ernandesrs\TallAppFilesManager\Livewire;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;
use TallStackUi\Traits\Interactions;

class FileUpload extends Component
{
    use WithFileUploads, Interactions;

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

    function saveFile()
    {
        $this->toast()
            ->success('Pronto!', 'Arquivo salvo com sucesso')
            ->send();
    }

    /**
     * Delete uploaded file
     * @return void
     */
    function deleteUploadedFile(array $content): void
    {
        /*
         the $content contains:
         [
             'temporary_name',
             'real_name',
             'extension',
             'size',
             'path',
             'url',
         ]
         */

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
