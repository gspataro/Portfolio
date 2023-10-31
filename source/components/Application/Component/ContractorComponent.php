<?php

namespace GSpataro\Application\Component;

use GSpataro\Contractor\Builder\ArchiveBuilder;
use GSpataro\Contractor\BuildersCollection;
use GSpataro\DependencyInjection\Component;
use GSpataro\Contractor\Builder\PostBuilder;
use GSpataro\Contractor\Builder\SimpleBuilder;

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

        $buildersCollection->add('post', new PostBuilder(
            $this->container->get('project.sitemap'),
            $this->container->get('twig')
        ));
    }
}
