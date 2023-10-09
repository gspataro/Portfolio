<?php

namespace GSpataro\Application;

use GSpataro\Builder\Data;
use GSpataro\Builder\PageBuilder;
use GSpataro\DependencyInjection\Component;

final class BuilderComponent extends Component
{
    public function register(): void
    {
        $this->container->variable('builder.dataDir', DIR_DATA);

        $this->container->add('builder.data', function ($container, $args): object {
            return new Data(
                $container->variable('builder.dataDir')
            );
        });

        $this->container->add('builder.page', function ($container, $args): object {
            return new PageBuilder(
                $container->get('twig')
            );
        });
    }

    public function boot(): void
    {
        $blueprint = $this->container->get('blueprint');
        $dataBuilder = $this->container->get('builder.data');

        foreach ($blueprint->get('data') as $dataFile) {
            $dataBuilder->load($dataFile);
        }
    }
}
