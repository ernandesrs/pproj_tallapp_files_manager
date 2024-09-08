<?php

namespace Ernandesrs\TallAppFilesManager;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class TallAppFilesManagerProvider extends ServiceProvider
{
    /**
     * Bootstrap services
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/tallapp-files-manager.php' => config_path('tallapp-files-manager.php')
        ], 'config');

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'tallapp-files-manager');
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'tallapp-files-manager');

        Livewire::component('files-manager', \Ernandesrs\TallAppFilesManager\Livewire\FilesManager::class);
        Livewire::component('file-item', \Ernandesrs\TallAppFilesManager\Livewire\FileItem::class);
    }

    /**
     * Register services
     * @return void
     */
    public function register()
    {

    }
}
