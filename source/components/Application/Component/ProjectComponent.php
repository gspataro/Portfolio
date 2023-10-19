<?php

namespace GSpataro\Application\Component;

use GSpataro\Project\Blueprint;
use GSpataro\DependencyInjection\Component;

final class ProjectComponent extends Component
{
    public function register(): void
    {
        $this->container->variable('blueprintPath', DIR_ROOT . '/blueprint.json');

        $this->container->add('project.blueprint', function ($container, $args): object {
            return new Blueprint(
                $container->variable('blueprintPath')
            );
        });
    }

    public function boot(): void
    {
    }
}
