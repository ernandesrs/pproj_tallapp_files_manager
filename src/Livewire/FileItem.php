<?php

namespace Ernandesrs\TallAppFilesManager\Livewire;

use Ernandesrs\TallAppFilesManager\Models\File;
use Livewire\Attributes\Locked;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class FileItem extends Component
{
    use Interactions;

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
        $this->file = File::findOrFail($this->id);
        $this->fill($this->file->only(['original_name', 'tags']));
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
        $validated = $this->validate([
            'original_name' => ['required', 'string'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['required', 'string'],
        ]);

        $this->file->update($validated);

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
        // check authorization

        // delete file
        \Storage::delete($this->file->path);

        // delete model
        $this->file->delete();

        $this->toast()
            ->success('Excluído!', 'O arquivo foi excluído com sucesso.')
            ->send();

        $this->dispatch('tallapp_files_manager_deleted_file');
    }
}
