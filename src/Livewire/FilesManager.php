<?php

namespace Ernandesrs\TallAppFilesManager\Livewire;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;

class FilesManager extends Component
{
    #[Url(as: 's', except: null)]
    public string $search = '';

    #[Url(as: 'type', except: null)]
    public string $type = 'all';

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

    public function mount()
    {
    }

    /**
     * Render
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->type = empty($this->type) ? 'all' : $this->type;

        return view('tallapp-files-manager::files-manager', [
            'paths' =>
                [
                    [
                        'text' => 'Vídeos'
                    ],
                    [
                        'text' => '10-10-2024'
                    ]
                ],
            'files' => $this->getFiles(),
            'directories' => $this->getDirectories()
        ]);
    }

    /**
     * Get files
     * @return \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection
     */
    private function getFiles(): Collection
    {
        return Collection::range(0, 23)->map(function () {
            $type = fake()->randomElement(['video', 'image', 'document']);
            $extension = fake()->randomElement([
                'video' => ['mp4', 'mkv', 'mov'],
                'image' => ['jpg', 'png', 'webp'],
                'document' => ['doc', 'pdf'],
            ][$type]);

            return [
                'id' => 'file-' . fake()->unique()->randomNumber(),
                'name' => fake()->text(15) . $extension,
                'type' => $type,
                'icon' => [
                    'video' => 'movie',
                    'document' => 'file',
                    'image' => 'photo'
                ][$type],
                'href' => '#'
            ];
        });
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
