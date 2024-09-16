<?php

namespace Ernandesrs\TallAppFilesManager\Traits;

use Ernandesrs\TallAppFilesManager\Models\File;

trait Authorization
{
    /**
     * Check authorization
     * @param string $ability
     * @param mixed $arguments
     * @return bool
     */
    function checkAuthorization(string $ability, mixed $arguments = [], bool $resposeAsBool = false)
    {
        if ($policyClass = config("tallapp-files-manager.policy")) {
            $gate = \Illuminate\Support\Facades\Gate::policy(
                File::class,
                $policyClass
            );

            if (!$resposeAsBool) {
                $gate->authorize(
                    $ability,
                    $arguments
                );
            } else {
                return $gate->check(
                    $ability,
                    $arguments
                );
            }
        }

        return true;
    }
}
