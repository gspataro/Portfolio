<?php

namespace GSpataro\Application\Command;

use GSpataro\Pages\Pages;
use GSpataro\Project\Prototype;
use GSpataro\Finder\Researcher;
use GSpataro\CLI\Helper\Stopwatch;
use GSpataro\Assets\Media;
use GSpataro\Library\ReadersCollection;
use GSpataro\Pages\GeneratorsCollection;
use GSpataro\Contractor\BuildersCollection;
use GSpataro\Project\Sitemap;
use SimpleXMLElement;
use DirectoryIterator;

final class BuildCommand extends BaseCommand
{
    protected string $name = 'build';
    protected ?string $description = 'Run the build process';

    private readonly Pages $pages;
    private readonly Media $media;
    private readonly Sitemap $sitemap;
    private readonly Stopwatch $stopwatch;
    private readonly Prototype $prototype;
    private readonly Researcher $researcher;
    private readonly ReadersCollection $readers;
    private readonly BuildersCollection $builders;
    private readonly GeneratorsCollection $generators;

    public function options(): array
    {
        $options = [];

        $options['view-only'] = [
            'type' => 'toggle'
        ];

        $options['cleanup-only'] = [
            'type' => 'toggle'
        ];

        return $options;
    }

    public function main(): void
    {
        $this->output->print('{bold}Running the building process{nl}');

        $this->prototype = $this->app->get('project.prototype');
        $this->generators = $this->app->get('pages.generators');
        $this->readers = $this->app->get('library.readers');
        $this->builders = $this->app->get('contractor.builders');
        $this->pages = $this->app->get('pages.collection');
        $this->media = $this->app->get('assets.media');
        $this->stopwatch = $this->app->get('cli.stopwatch');
        $this->researcher = $this->app->get('finder.researcher');
        $this->sitemap = $this->app->get('project.sitemap');

        $this->stopwatch->start();

        $this->processContents();
        $this->processSchemas();

        if ($this->argument('cleanup-only') !== false) {
            $this->buildPages();
        }

        if ($this->argument('view-only') !== false && $this->argument('cleanup-only') !== false) {
            $this->generateMedia();
            $this->buildSitemapXml();
        }

        $this->cleanup();

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
                $this->output->print("{bold}{fg_red}Contents processing failed on group '{$group}'.");
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

            $schema['contents'] = $this->processSchemaContents($schema['contents']);

            $generator = $this->generators->get($schema['generator']);
            $generator->generate($schema);
        }
    }

    /**
     * Process schema contents
     *
     * @param array $contents
     * @return array
     */

    public function processSchemaContents(array $contents): array
    {
        $output = [];

        if (empty($contents)) {
            return $output;
        }

        foreach ($contents as $label => $query) {
            $research = $this->researcher->start($label, $query['group']);

            if (isset($query['select'])) {
                $research->select($query['select']);
            }

            if (!empty($query['where'])) {
                $field = array_key_first($query['where']);
                $value = $query['where'][$field];
                $research->where($field, $value);
            }

            if (isset($query['skip'])) {
                $research->select($query['skip']);
            }

            if (isset($query['limit'])) {
                $research->limit($query['limit']);
            }

            if (isset($query['orderBy'])) {
                $research->orderBy(
                    $query['orderBy'],
                    $query['order'] ?? 'asc'
                );
            }

            $output[$label] = $research->fetch();
        }

        return $output;
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
     * Generate media
     *
     * @return void
     */

    private function generateMedia(): void
    {
        $this->output->print('{bold}Generating media');

        $mediaFiles = glob(DIR_MEDIA . '/*.{jpg,jpeg,png}', GLOB_BRACE);

        foreach ($mediaFiles as $mediaFile) {
            $this->media->resizeMedia($mediaFile);
        }
    }

    /**
     * Build sitemap.xml file
     *
     * @return void
     */

    private function buildSitemapXml(): void
    {
        $this->output->print('{bold}Generating sitemap.xml');

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset></urlset>');
        $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($this->sitemap->getAll() as $url) {
            if (str_ends_with($url, '/index')) {
                $url = substr($url, 0, strlen('index') * -1);
            }

            if ($url === '/404') {
                continue;
            }

            $urlElement = $xml->addChild('url');
            $urlElement->addChild('loc', 'https://giuseppespataro.it' . $url);
            $urlElement->addChild('lastmod', date('c'));
        }

        $xml->asXml(DIR_OUTPUT . '/sitemap.xml');
    }

    /**
     * Delete files that are no more present in the project
     *
     * @param string $directory
     * @return void
     */

    private function cleanup($directory = DIR_OUTPUT): void
    {
        if ($directory === DIR_OUTPUT) {
            $this->output->print('{bold}Cleaning up');
        }

        $sitemap = array_values($this->sitemap->getAll());
        $outputDirectory = new DirectoryIterator($directory);
        $excluded = ['.vite', 'assets', '.htaccess', 'sitemap.xml', 'favicon.png', 'media'];

        foreach ($outputDirectory as $item) {
            if ($item->isDot()) {
                continue;
            }

            if (in_array($item->getBasename(), $excluded)) {
                continue;
            }

            $itemPath = $item->isFile()
                ? substr($item->getPathname(), strlen(DIR_OUTPUT), strlen('.html') * -1)
                : substr($item->getPathname(), strlen(DIR_OUTPUT));

            if ($item->isFile() && !in_array($itemPath, $sitemap)) {
                unlink($item->getPathname());
                continue;
            }

            if ($item->isDir()) {
                $this->cleanup($item->getPathname());
            }
        }
    }
}
