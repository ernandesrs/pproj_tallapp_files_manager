<?php

namespace Ernandesrs\TallAppFilesManager\Livewire;

use Ernandesrs\TallAppFilesManager\Models\File;
use Ernandesrs\TallAppFilesManager\Traits\Authorization;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class FilesManager extends Component
{
    use Authorization;

    /**
     * Policy class
     * @var ?string
     */
    public ?string $policyClass = null;

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
     * Render
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    #[On('close_tallapp_upload_modal'), On('tallapp_files_manager_deleted_file')]
    public function render()
    {
        $this->checkAuthorization('viewAny', File::class);

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
        $validated = \Validator::make([
            'search' => $this->search,
            'type' => $this->type
        ], [
            'search' => ['required', 'string'],
            'type' => ['required', \Illuminate\Validation\Rule::enum(\Ernandesrs\TallAppFilesManager\Enums\FileTypesEnum::class)]
        ])->valid();

        $search = $validated['search'] ?? null;
        $type = $validated['type'] ?? null;

        return File::when($search, function (Builder $query) use ($search) {
            return $query->whereRaw('MATCH(original_name,tags) AGAINST(? IN BOOLEAN MODE)', $search);
        })->when($type, function (Builder $query) use ($type) {
            return $query->where('type', $type);
        })->orderBy('created_at', 'desc')
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
