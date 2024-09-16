<?php

namespace Ernandesrs\TallAppFilesManager\Traits;

use Ernandesrs\TallAppFilesManager\Models\File;

trait Authorization
{
    /**
     * Check authorization
     * @param string $ability
     * @param mixed $arguments
     * @return void
     */
    function checkAuthorization(string $ability, mixed $arguments = [])
    {
        if ($policyClass = config("tallapp-files-manager.policy")) {
            \Illuminate\Support\Facades\Gate::policy(
                File::class,
                $policyClass
            )->authorize(
                    $ability,
                    $arguments
                );
        }
    }
}
