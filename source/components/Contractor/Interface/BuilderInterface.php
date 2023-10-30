<?php

namespace GSpataro\Contractor\Interface;

interface BuilderInterface
{
    /**
     * Setup builder
     *
     * @param array $item
     * @return void
     */

    public function setup(array $item): void;

    /**
     * Execute build
     *
     * @return void
     */

    public function compile(): void;
}
