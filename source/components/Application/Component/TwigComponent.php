<?php

namespace GSpataro\Application\Component;

use Twig\Environment;
use GSpataro\View\TwigSitemap;
use GSpataro\View\TwigBlueprint;
use Twig\Loader\FilesystemLoader;
use Twig\Extra\String\StringExtension;
use GSpataro\DependencyInjection\Component;
use Twig\Extension\StringLoaderExtension;

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
        $twig->addExtension(new StringLoaderExtension());
        $twig->addExtension(new TwigBlueprint(
            $this->container->get('project.blueprint')
        ));
        $twig->addExtension(new TwigSitemap(
            $this->container->get('project.blueprint'),
            $this->container->get('project.sitemap')
        ));
    }
}
