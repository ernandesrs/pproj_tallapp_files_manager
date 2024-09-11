<?php

namespace Ernandesrs\TallAppFilesManager\Livewire;
use Ernandesrs\TallAppFilesManager\Models\TallFile;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class FileItem extends Component
{
    use Interactions;

    public bool $detailModalShow = false;

    public string $id = '';

    public ?string $preview = null;

    public string $icon = 'file';

    public string $text = 'Lorem dolor';

    function mount()
    {
    }

    function render()
    {
        return view('tallapp-files-manager::file-item');
    }

    function showItem(int $id)
    {
        $this->detailModalShow = true;
        // dd('show o ' . $id);
    }

    /**
     * Deletion confirmed
     * @param int $id
     * @return void
     */
    function deletionConfirmed(int $id)
    {
        $file = TallFile::findOrFail($id);

        // check authorization

        // delete file
        \Storage::delete($file->path);

        // delete model
        $file->delete();

        $this->toast()
            ->success('Excluído!', 'O arquivo foi excluído com sucesso.')
            ->send();

        $this->dispatch('tallapp_files_manager_deleted_file');
    }
}
