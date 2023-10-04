<?php

namespace GSpataro\Application;

use GSpataro\Builder\Blueprint;
use GSpataro\DependencyInjection\Component;

final class BlueprintComponent extends Component
{
    public function register(): void
    {
        $this->container->variable('blueprintPath', DIR_ROOT . '/blueprint.json');

        $this->container->add('blueprint', function ($container, $args): object {
            return new Blueprint(
                $container->variable('blueprintPath')
            );
        });
    }

    public function boot(): void
    {
    }
}
