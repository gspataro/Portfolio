<?php

namespace GSpataro\Assets;

use GSpataro\Application\Project;

final class Handler
{
    /**
     * Initialize Handler object
     *
     * @param Project $project
     */

    public function __construct(
        private readonly Project $project
    ) {
    }

    /**
     * Copy assets to the output directory
     *
     * @return void
     */

    public function run(): void
    {
        recursiveCopy(
            $this->project->getAssetsDir(),
            $this->project->getOutputDir() . '/assets',
            $this->project->getExcludedAssets()
        );
    }
}
