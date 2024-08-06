<?php

namespace GSpataro\Assets;

use GSpataro\Project\Blueprint;

final class Handler
{
    /**
     * Initialize Handler object
     *
     * @param Blueprint $blueprint
     */

    public function __construct(
        private readonly Blueprint $blueprint
    ) {
    }

    /**
     * Copy assets to the output directory
     *
     * @return void
     */

    public function compile(): void
    {
        recursiveCopy(
            DIR_ASSETS,
            DIR_OUTPUT . '/assets',
            $this->blueprint->get('exclude_assets') ?? []
        );
    }
}
