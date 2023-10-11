<?php

namespace GSpataro\Contractor;

use GSpataro\Application\Project;

final class Architect
{
    /**
     * Initialize the Architect object
     *
     * @param Blueprint $blueprint
     * @param BuildersCollection $builders
     * @param string $outputDir
     */

    public function __construct(
        private readonly Project $project,
        private readonly BuildersCollection $builders
    ) {
    }

    /**
     * Execute the project building process
     *
     * @return void
     */

    public function run(): void
    {
        foreach ($this->project->getItems() as $item) {
            $builder = $this->builders->get($item['builder']);
            $builder->compile($item);
        }
    }
}
