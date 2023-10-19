<?php

namespace GSpataro\Command;

use GSpataro\Contractor\BuildersCollection;
use GSpataro\Library\Archive;
use GSpataro\Library\ReadersCollection;
use GSpataro\Project\Blueprint;

final class BuildCommand extends BaseCommand
{
    protected string $name = 'build';
    protected ?string $description = 'Run the build process';

    private readonly Blueprint $blueprint;
    private readonly ReadersCollection $readers;
    private readonly Archive $archive;
    private readonly BuildersCollection $builders;

    public function main(): void
    {
        $this->output->print('Running the building process...');

        $this->blueprint = $this->app->get('project.blueprint');
        $this->readers = $this->app->get('library.readers');
        $this->archive = $this->app->get('library.archive');
        $this->builders = $this->app->get('contractor.builders');
        $assets = $this->app->get('assets.handler');

        foreach ($this->blueprint->get('items') as $item) {
            $item['output'] = DIR_OUTPUT . '/' . $item['output'];
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
            $output[$tag] = $reader->compile(DIR_DATA . '/' . $content['source']);
        }

        return $output;
    }
}
