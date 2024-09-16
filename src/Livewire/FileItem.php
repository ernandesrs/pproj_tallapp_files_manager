<?php

namespace Ernandesrs\TallAppFilesManager\Livewire;

use Ernandesrs\TallAppFilesManager\Models\File;
use Ernandesrs\TallAppFilesManager\Services\FileService;
use Ernandesrs\TallAppFilesManager\Traits\Authorization;
use Livewire\Attributes\Locked;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class FileItem extends Component
{
    use Interactions, Authorization;

    /**
     * Icon
     * @var string
     */
    public string $icon = "file";

    /**
     * Id
     * @var string
     */
    #[Locked]
    public string $id = '';

    /**
     * File
     * @var null|File
     */
    #[Locked]
    public null|File $file = null;

    /**
     * Original name
     * @var string
     */
    public string $original_name = "";

    /**
     * Tags
     * @var array
     */
    public array $tags = [];

    /**
     * Mount
     * @return void
     */
    function mount()
    {
        $this->file = File::findOrFail($this->id, ['*']);

        $canView = $this->checkAuthorization(
            'view',
            $this->file,
            true
        );

        if ($canView) {
            $this->fill($this->file
                ->only(['original_name', 'tags']));
        } else {
            $this->file = $this->file
                ->makeHidden(['name', 'tags', 'original_name', 'size', 'path', 'extension', 'created_at', 'updated_at']);
        }
    }

    /**
     * Render
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function render()
    {
        return view('tallapp-files-manager::file-item');
    }

    /**
     * Update
     * @return void
     */
    function update()
    {
        $this->checkAuthorization('update', $this->file);

        FileService::update(
            $this->validate(FileService::updateRules()),
            $this->file
        );

        $this->toast()
            ->success('Atualizado!', 'Os dados foram atualizados com sucesso')
            ->send();

        $this->dispatch('tallapp_files_manager_updated_file');
    }

    /**
     * Deletion confirmed
     * @return void
     */
    function deletionConfirmed()
    {
        $this->checkAuthorization('delete', $this->file);

        FileService::delete($this->file);

        $this->toast()
            ->success('Excluído!', 'O arquivo foi excluído com sucesso.')
            ->send();

        $this->dispatch('tallapp_files_manager_deleted_file');
    }
}
