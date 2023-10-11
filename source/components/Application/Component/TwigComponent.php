<?php

namespace GSpataro\Application\Component;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extra\String\StringExtension;
use GSpataro\DependencyInjection\Component;

final class TwigComponent extends Component
{
    public function register(): void
    {
        $this->container->variable('twig.viewsPath', DIR_VIEW);

        $this->container->add('twig.loader', function ($container, $args): object {
            return new FilesystemLoader(
                $container->variable('twig.viewsPath')
            );
        });

        $this->container->add('twig', function ($container, $args): object {
            return new Environment(
                $container->get('twig.loader')
            );
        });
    }

    public function boot(): void
    {
        $twig = $this->container->get('twig');
        $twig->addExtension(new StringExtension());
    }
}
