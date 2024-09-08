<?php

namespace Ernandesrs\TallAppFilesManager\Livewire;
use Livewire\Component;

class FileItem extends Component
{
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

    function deletionConfirmed(int $id)
    {
        dd('delete o ' . $id);
    }
}
