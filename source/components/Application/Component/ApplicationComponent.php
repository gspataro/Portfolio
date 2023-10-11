<?php

namespace GSpataro\Application\Component;

use GSpataro\Application\Project;
use GSpataro\Application\Blueprint;
use GSpataro\DependencyInjection\Component;

final class ApplicationComponent extends Component
{
    public function register(): void
    {
        $this->container->variable('blueprintPath', DIR_ROOT . '/blueprint.json');

        $this->container->add('app.blueprint', function ($container, $args): object {
            return new Blueprint(
                $container->variable('blueprintPath')
            );
        });

        $this->container->add('app.project', function ($container, $args): object {
            return new Project(
                $container->get('app.blueprint')
            );
        });
    }

    public function boot(): void
    {
    }
}
