<?php

namespace GSpataro\Application\Command;

use GSpataro\Project\Blueprint;
use GSpataro\Library\ReadersCollection;
use GSpataro\Contractor\BuildersCollection;
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
            $this->output->print('{bold}Processing "' . $content['type'] . '" content type');

            $this->output->print('[' . $content['type'] . '] Reading data from sources...');
            $content['data'] = $this->compileData($content['data']);

            $this->output->print('[' . $content['type'] . '] Creating sitemap...');
            $this->createSitemap($content);

            $this->output->print('[' . $content['type'] . '] Building pages...');
            $this->buildPages($content);
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

    private function createSitemap(array &$content): void
    {
        foreach ($content['data'][0] as &$item) {
            $item['permalink'] = $this->sitemap->add(
                $content['type'] . '.' . $item['meta']['slug'],
                pathJoin($content['output'], $item['meta']['slug'])
            );
        }

        if (!$content['archive']) {
            return;
        }

        $content['archive']['permalink'] = $this->sitemap->add(
            $content['type'] . '.' . $content['archive']['slug'],
            pathJoin($content['output'], $content['archive']['slug'])
        );
    }

    private function buildPages(array $content): void
    {
        $postBuilder = $this->builders->get('post');

        foreach ($content['data'][0] as $item) {
            $postBuilder->compile($item['meta']['template'] ?? $content['template'], $item);
        }

        /*if (!$content['archive']) {
            return;
        }

        $perPage = $content['archive']['per_page'];
        $totalPages = ceil(count($content['data'][0]) / $perPage);

        for ($i = 0; $i < $totalPages; $i++) {

        }*/
    }
}
