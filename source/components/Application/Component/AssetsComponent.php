<?php

namespace GSpataro\Application\Component;

use GSpataro\Assets\Handler;
use GSpataro\DependencyInjection\Component;

final class AssetsComponent extends Component
{
    public function register(): void
    {
        $this->container->add('assets.handler', function ($container, $args): object {
            return new Handler(
                $container->get('app.project')
            );
        });
    }

    public function boot(): void
    {
    }
}
