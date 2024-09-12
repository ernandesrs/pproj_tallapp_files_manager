<?php

namespace Ernandesrs\TallAppFilesManager\Livewire;
use Ernandesrs\TallAppFilesManager\Models\TallFile;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
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
     * @var null|TallFile
     */
    #[Locked]
    public null|TallFile $tallFile = null;

    /**
     * Original name
     * @var string
     */
    public string $original_name = "";

    /**
     * Tags
     * @var string
     */
    public string $tags = "";

    /**
     * Mount
     * @return void
     */
    function mount()
    {
        $this->tallFile = TallFile::findOrFail($this->id);
        $this->fill($this->tallFile->only(['original_name', 'tags']));
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
            'tags' => ['required', 'string']
        ]);

        $this->tallFile->update($validated);

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
        \Storage::delete($this->tallFile->path);

        // delete model
        $this->tallFile->delete();

        $this->toast()
            ->success('Excluído!', 'O arquivo foi excluído com sucesso.')
            ->send();

        $this->dispatch('tallapp_files_manager_deleted_file');
    }
}
