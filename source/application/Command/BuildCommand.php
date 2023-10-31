<?php

namespace GSpataro\Application\Command;

use GSpataro\Project\Blueprint;
use GSpataro\Library\ReadersCollection;
use GSpataro\Contractor\BuildersCollection;
use GSpataro\Project\Content;
use GSpataro\Project\Sitemap;

final class BuildCommand extends BaseCommand
{
    protected string $name = 'build';
    protected ?string $description = 'Run the build process';

    private readonly Sitemap $sitemap;
    private readonly Blueprint $blueprint;
    private readonly ReadersCollection $readers;
    private readonly BuildersCollection $builders;

    public function main(): void
    {
        $this->output->print('{bold}Running the building process...');

        $this->blueprint = $this->app->get('project.blueprint');
        $this->sitemap = $this->app->get('project.sitemap');
        $this->readers = $this->app->get('library.readers');
        $this->builders = $this->app->get('contractor.builders');
        $assets = $this->app->get('assets.handler');

        foreach ($this->blueprint->get('contents') as $content) {
            $this->output->print('{bold}Processing "' . $content->type . '" content type');

            $this->output->print('[' . $content->type . '] Reading data from sources...');
            $data = [];
            $data = $this->compileData($content->data);

            $this->output->print('[' . $content->type . '] Creating sitemap...');
            $items = [];
            $items = $this->createSitemap($data, $content);

            $this->output->print('[' . $content->type . '] Building pages...');
            $this->buildPages($items, $content);
        }

        $this->output->print('{bold}Copying assets...');
        $assets->compile();

        $this->output->print('{bold}{fg_green}Build completed successfully!');
    }

    private function compileData(array $data): array
    {
        $output = [];

        foreach ($data as $source) {
            $reader = $this->readers->get($source['reader']);
            $output[] = $reader->compile($source['path']);
        }

        return $output;
    }

    private function createSitemap(array $data, Content $content): array
    {
        $items = [];

        foreach ($data as $source) {
            foreach ($source as $item) {
                $item['permalink'] = $this->sitemap->add(
                    $content->type . '.' . $item['meta']['slug'],
                    pathJoin($content->output, $item['meta']['slug'])
                );

                $items[] = $item;
            }
        }

        return $items;
    }

    private function buildPages(array $items, Content $content): void
    {
        $postBuilder = $this->builders->get('post');

        foreach ($items as $item) {
            $postBuilder->compile($item['meta']['template'] ?? $content->template, $item);
        }
    }
}
