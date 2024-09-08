<?php

namespace Ernandesrs\TallAppFilesManager;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class TallAppFilesManagerProvider extends ServiceProvider
{
    /**
     * Bootstrap services
     *
     * Publish all with: php artisan vendor:publish --provider="Ernandesrs\TallAppFilesManager\TallAppFilesManagerProvider"
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'tallapp-files-manager');
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'tallapp-files-manager');

        Livewire::component('files-manager', \Ernandesrs\TallAppFilesManager\Livewire\FilesManager::class);
        Livewire::component('file-item', \Ernandesrs\TallAppFilesManager\Livewire\FileItem::class);
        Livewire::component('file-upload', \Ernandesrs\TallAppFilesManager\Livewire\FileUpload::class);

        $this->publishes([
            __DIR__ . '/tallapp-files-manager.php' => config_path('tallapp-files-manager.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/lang' => $this->app->langPath('vendor/ernandesrs/tallapp-files-manager')
        ], 'lang');

        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('/views/vendor/ernandesrs/tallapp-files-manager')
        ], 'views');
    }

    /**
     * Register services
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . './tallapp-files-manager.php', 'tallapp-files-manager');
    }
}
