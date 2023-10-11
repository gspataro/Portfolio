<?php

namespace GSpataro\Application\Component;

use GSpataro\Contractor\Data;
use GSpataro\Contractor\Architect;
use GSpataro\Contractor\BuildersCollection;
use GSpataro\DependencyInjection\Component;
use GSpataro\Contractor\Builder\SimpleBuilder;

final class ContractorComponent extends Component
{
    public function register(): void
    {
        $this->container->variable('builder.dataDir', DIR_DATA);

        $this->container->add('builder.data', function ($container, $args): object {
            return new Data(
                $container->variable('builder.dataDir')
            );
        });

        $this->container->add('builder.collection', function ($container, $args): object {
            return new BuildersCollection();
        });

        $this->container->add('builder.architect', function ($container, $args): object {
            return new Architect(
                $container->get('app.project'),
                $container->get('builder.collection')
            );
        });
    }

    public function boot(): void
    {
        $buildersCollection = $this->container->get('builder.collection');

        $buildersCollection->add('simple', new SimpleBuilder(
            $this->container->get('twig')
        ));

        $blueprint = $this->container->get('app.blueprint');
        $dataBuilder = $this->container->get('builder.data');

        foreach ($blueprint->get('data') as $dataFile) {
            $dataBuilder->load($dataFile);
        }
    }
}
