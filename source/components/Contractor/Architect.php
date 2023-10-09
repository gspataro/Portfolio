<?php

namespace GSpataro\Contractor;

final class Architect
{
    /**
     * Store the current project
     *
     * @var array
     */

    private array $project = [];

    /**
     * Initialize the Architect object
     *
     * @param Blueprint $blueprint
     * @param BuildersCollection $builders
     * @param string $outputDir
     */

    public function __construct(
        private readonly Blueprint $blueprint,
        private readonly BuildersCollection $builders
    ) {
    }

    /**
     * Setup a project based on blueprint data
     *
     * @param string $outputDir
     * @return void
     */

    public function setupProject(string $outputDir = DIR_OUTPUT): void
    {
        if (!$this->blueprint->has('pages')) {
            return;
        }

        $this->project['outputDir'] = $outputDir;
        $this->project['items'] = [];

        foreach ($this->blueprint->get('pages') as $page) {
            $page['type'] ??= 'simple';

            $this->project['items'][] = [
                'template' => $page['template'],
                'output' => $page['output'],
                'builder' => $this->builders->get($page['type'])
            ];
        }
    }

    /**
     * Get the project
     *
     * @return array
     */

    public function getProject(): array
    {
        return $this->project;
    }

    /**
     * Execute the project building process
     *
     * @return void
     */

    public function executeBuild(): void
    {
        $project = $this->getProject();

        foreach ($project['items'] as $item) {
            $item['builder']->compile($item['template'], $project['outputDir'] . $item['output']);
        }
    }
}
