<?php

namespace GSpataro\Application\Command;

use GSpataro\Project\Blueprint;
use GSpataro\Library\ReadersCollection;
use GSpataro\Contractor\BuildersCollection;

final class BuildCommand extends BaseCommand
{
    protected string $name = 'build';
    protected ?string $description = 'Run the build process';

    private readonly Blueprint $blueprint;
    private readonly ReadersCollection $readers;
    private readonly BuildersCollection $builders;

    public function main(): void
    {
        $this->output->print('Running the building process...');

        $this->blueprint = $this->app->get('project.blueprint');
        $this->readers = $this->app->get('library.readers');
        $this->builders = $this->app->get('contractor.builders');
        $assets = $this->app->get('assets.handler');

        foreach ($this->blueprint->get('items') as $item) {
            $item['contents'] = $this->compileContents($item['contents']);
            $builder = $this->builders->get($item['builder']);

            $builder->compile($item);
        }

        $assets->compile();

        $this->output->print('Build completed!');
    }

    private function compileContents(array $contents): array
    {
        $output = [];

        foreach ($contents as $tag => $content) {
            $reader = $this->readers->get($content['reader']);
            $output[$tag] = $reader->compile($content['source']);
        }

        return $output;
    }
}