<?php

namespace GSpataro\Contractor\Interface;

use GSpataro\Project\Schema;

interface BuilderInterface
{
    /**
     * Execute build
     *
     * @param array $page
     * @return void
     */

    public function compile(array $page): void;
}
