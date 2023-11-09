<?php

namespace GSpataro\Application\Command;

use GSpataro\Project\Content;
use GSpataro\Project\Sitemap;
use GSpataro\Project\Prototype;
use GSpataro\Assets\Handler as Assets;
use GSpataro\Library\ReadersCollection;
use GSpataro\Contractor\BuildersCollection;

final class BuildCommand extends BaseCommand
{
    protected string $name = 'build';
    protected ?string $description = 'Run the build process';

    private readonly Assets $assets;
    private readonly Sitemap $sitemap;
    private readonly Prototype $prototype;
    private readonly ReadersCollection $readers;
    private readonly BuildersCollection $builders;

    public function main(): void
    {
        $this->output->print('{bold}Running the building process{nl}');

        $this->prototype = $this->app->get('project.prototype');
        $this->sitemap = $this->app->get('project.sitemap');
        $this->readers = $this->app->get('library.readers');
        $this->builders = $this->app->get('contractor.builders');
        $this->assets = $this->app->get('assets.handler');

        $this->processContents();
    }

    /**
     * Process contents from prototype
     *
     * @return array
     */

    private function processContents(): array
    {
        $contents = [];

        $this->output->print('{bold}Processing contents');

        foreach ($this->prototype->get('contents') as $group => $source) {
            $this->output->print("Working on content group '{$group}'");

            $reader = $this->readers->get($source['reader']);
            $contents[$group] = $reader->compile($group, $source['path']);

            if ($reader->failed()) {
                $error = $reader->getError();
                $this->output->print("{bold}{fg_red}Contents processing failed on group'{$group}'.");
                $this->output->print('{bold}Error: {clear}' . $error->getMessage());
                $this->output->print('{bold}Source: {clear}' . $reader->getFailedSource());
                exit(1);
            }
        }

        return $contents;
    }
}
