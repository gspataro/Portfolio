<?php

namespace GSpataro\Application;

final class Project
{
    /**
     * Store project items
     *
     * @var array
     */

    private array $items = [];

    /**
     * Store excluded assets
     *
     * @var array
     */

    private array $excludedAssets = [];

    /**
     * Initialize Project object
     *
     * @param Blueprint $blueprint
     * @param string $outputDir
     * @param string $dataDir
     * @param string $assetsDir
     */

    public function __construct(
        private readonly Blueprint $blueprint,
        private string $outputDir = DIR_OUTPUT,
        private string $dataDir = DIR_DATA,
        private string $assetsDir = DIR_ASSETS
    ) {
        $this->setup();
    }

    /**
     * Setup project
     *
     * @param string $outputDir
     * @return void
     */

    public function setup(): void
    {
        $this->excludedAssets = $this->blueprint->get('exclude_assets') ?? [];

        if ($this->blueprint->has('items')) {
            foreach ($this->blueprint->get('items') as $i => $item) {
                $this->items[$i] = [
                    'template' => $item['template'],
                    'builder' => $item['type'] ?? 'simple',
                    'output' => $this->getOutputDir() . $item['output']
                ];

                if (!isset($item['data'])) {
                    $this->items[$i]['data'] = [];
                    continue;
                }

                $data = is_array($item['data']) ? $item['data'] : [$item['data']];

                foreach ($data as $query) {
                    if (str_contains($query, ':')) {
                        [$type, $path] = explode(':', $query, 2);
                    } else {
                        $type = 'text';
                        $path = $query;
                    }

                    $this->items[$i]['data'][] = [
                        'type' => $type,
                        'path' => $this->getDataDir() . '/' . $path
                    ];
                }
            }
        }
    }

    /**
     * Get project output dir
     *
     * @return string
     */

    public function getOutputDir(): string
    {
        return $this->outputDir;
    }

    /**
     * Get project data dir
     *
     * @return string
     */

    public function getDataDir(): string
    {
        return $this->dataDir;
    }

    /**
     * Get assets dir
     *
     * @return string
     */

    public function getAssetsDir(): string
    {
        return $this->assetsDir;
    }

    /**
     * Get project items
     *
     * @return array
     */

    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Update an item
     *
     * @param int $id
     * @param array $item
     * @return void
     */

    public function setItem(int $id, array $item): void
    {
        $this->items[$id] = $item;
    }

    /**
     * Get excluded assets
     *
     * @return array
     */

    public function getExcludedAssets(): array
    {
        return $this->excludedAssets;
    }
}
