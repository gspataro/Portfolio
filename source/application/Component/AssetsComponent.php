<?php

namespace GSpataro\Application\Component;

use GSpataro\Assets\Handler;
use GSpataro\Assets\Media;
use GSpataro\DependencyInjection\Component;

final class AssetsComponent extends Component
{
    public function register(): void
    {
        $this->container->add('assets.handler', function ($container, $args): object {
            return new Handler(
                $container->get('project.blueprint')
            );
        });

        $this->container->add('assets.media', function ($container, $args): object {
            return new Media();
        });
    }

    public function boot(): void
    {
        $media = $this->container->get('assets.media');

        $media->addSize('thumbnail', 400, null, 90);
        $media->addSize('medium', 600, null, 90);
        $media->addSize('large', 900, null, 90);
        $media->addSize('full', 1920, null, 90);
        $media->addSize('original', 0, 0, 90);
    }
}
