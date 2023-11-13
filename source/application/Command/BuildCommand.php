<?php

namespace GSpataro\Application\Command;

use GSpataro\Pages\Pages;
use GSpataro\Project\Prototype;
use GSpataro\CLI\Helper\Stopwatch;
use GSpataro\Assets\Handler as Assets;
use GSpataro\Library\ReadersCollection;
use GSpataro\Pages\GeneratorsCollection;
use GSpataro\Contractor\BuildersCollection;

final class BuildCommand extends BaseCommand
{
    protected string $name = 'build';
    protected ?string $description = 'Run the build process';

    private readonly Pages $pages;
    private readonly Assets $assets;
    private readonly Stopwatch $stopwatch;
    private readonly Prototype $prototype;
    private readonly ReadersCollection $readers;
    private readonly BuildersCollection $builders;
    private readonly GeneratorsCollection $generators;

    public function main(): void
    {
        $this->output->print('{bold}Running the building process{nl}');

        $this->prototype = $this->app->get('project.prototype');
        $this->generators = $this->app->get('pages.generators');
        $this->readers = $this->app->get('library.readers');
        $this->builders = $this->app->get('contractor.builders');
        $this->pages = $this->app->get('pages.collection');
        $this->assets = $this->app->get('assets.handler');
        $this->stopwatch = $this->app->get('cli.stopwatch');

        $this->stopwatch->start();
        $this->processContents();
        $this->processSchemas();
        $this->buildPages();
        $this->copyAssets();

        $this->output->print('{bold}{fg_green}Build completed in ' . $this->stopwatch->stop() . ' seconds!');
    }

    /**
     * Process contents from prototype
     *
     * @return void
     */

    private function processContents(): void
    {
        $this->output->print('{bold}Processing contents');

        foreach ($this->prototype->get('contents') as $group => $source) {
            $this->output->print("Working on content group '{$group}'");

            $reader = $this->readers->get($source['reader']);
            $contents[$group] = $reader->compile($group, $source['path']);

            if ($reader->failed()) {
                $error = $reader->getError();
                $this->output->print("{bold}{fg_red}Contents processing failed on group'{$group}'.");
                $this->output->print('{bold}Error: {clear}' . $error->value);
                $this->output->print('{bold}Source: {clear}' . $reader->getFailedSource());
                exit(1);
            }
        }
    }

    /**
     * Process schemas from prototype
     *
     * @return void
     */

    private function processSchemas(): void
    {
        $this->output->print('{bold}Processing schemas');

        foreach ($this->prototype->get('schemas') as $tag => $schema) {
            $this->output->print("Working on schema '{$tag}'");

            $generator = $this->generators->get($schema['generator']);
            $generator->generate($schema);
        }
    }

    /**
     * Build pages
     *
     * @return void
     */

    private function buildPages(): void
    {
        $this->output->print('{bold}Building pages');

        foreach ($this->pages->getAll() as $page) {
            $builder = $this->builders->get($page['builder']);
            $builder->compile($page);
        }
    }

    /**
     * Copy assets
     *
     * @return void
     */

    private function copyAssets(): void
    {
        $this->output->print('{bold}Copying assets');

        $this->assets->compile();
    }
}
