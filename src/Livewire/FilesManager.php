<?php

namespace Ernandesrs\TallAppFilesManager\Livewire;
use Ernandesrs\TallAppFilesManager\Enums\FileTypesEnum;
use Ernandesrs\TallAppFilesManager\Models\TallFile;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class FilesManager extends Component
{
    /**
     * Filter: search
     *
     * @var string
     */
    #[Url(as: 's', except: null)]
    public string $search = '';

    /**
     * Filter: type
     *
     * @var string
     */
    #[Url(as: 'type', except: null)]
    public string $type = 'all';

    /**
     * Type options
     * @var array
     */
    public array $typeOptions =
        [
            [
                'label' => 'Todos',
                'value' => 'all',
            ],
            [
                'label' => 'Vídeos',
                'value' => 'video',
            ],
            [
                'label' => 'Imagens',
                'value' => 'image',
            ],
            [
                'label' => 'Documentos',
                'value' => 'document',
            ]
        ];

    /**
     * Mount
     * @return void
     */
    public function mount()
    {
    }

    /**
     * Render
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    #[On('close_tallapp_upload_modal'), On('tallapp_files_manager_deleted_file')]
    public function render()
    {
        $this->type = empty($this->type) ? 'all' : $this->type;

        return view('tallapp-files-manager::files-manager', [
            'paths' => [],
            'files' => $this->getFiles(),
            'directories' => null
        ]);
    }

    /**
     * Get files
     * @return \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection
     */
    private function getFiles(): Collection
    {
        return TallFile::orderBy('created_at', 'desc')
            ->limit(15)
            ->get();
    }

    /**
     * Get directories
     * @return \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection
     */
    private function getDirectories(): Collection
    {
        return Collection::range(0, 11)->map(fn() => [
            'id' => 'directory-' . fake()->unique()->randomNumber(),
            'name' => fake()->text(15),
            'icon' => 'folder',
            'href' => '#'
        ]);
    }
}
