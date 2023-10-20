<?php

namespace GSpataro\Application\Component;

use GSpataro\Contractor\BuildersCollection;
use GSpataro\DependencyInjection\Component;
use GSpataro\Contractor\Builder\SimpleBuilder;
use GSpataro\Contractor\Builder\ProjectsBuilder;

final class ContractorComponent extends Component
{
    public function register(): void
    {
        $this->container->add('contractor.builders', function ($container, $args): object {
            return new BuildersCollection();
        });
    }

    public function boot(): void
    {
        $buildersCollection = $this->container->get('contractor.builders');

        $buildersCollection->add('simple', new SimpleBuilder(
            $this->container->get('project.sitemap'),
            $this->container->get('twig')
        ));

        $buildersCollection->add('projects', new ProjectsBuilder(
            $this->container->get('project.sitemap'),
            $this->container->get('twig')
        ));
    }
}
