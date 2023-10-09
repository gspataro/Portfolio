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
        if (!$this->blueprint->has('items')) {
            return;
        }

        $this->project['outputDir'] = $outputDir;
        $this->project['builders'] = [];
        $this->project['items'] = [];

        foreach ($this->blueprint->get('items') as $item) {
            $item['type'] ??= 'simple';
            $this->project['builders'][$item['type']] ??= $this->builders->get($item['type']);
            $this->project['items'][$item['type']] ??= [];

            $this->project['items'][$item['type']][] = [
                'template' => $item['template'],
                'output' => $outputDir . $item['output'],
                'data' => []
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

        /*foreach ($project['items'] as $item) {
            $item['builder']->compile($item['template'], $project['outputDir'] . $item['output']);
        }*/

        foreach ($project['builders'] as $type => $builder) {
            $builder->setup($project['items'][$type]);
            $builder->compile();
        }
    }
}
