<?php

namespace GSpataro\Contractor\Interface;

interface BuilderInterface
{
    /**
     * Setup builder
     *
     * @param array $instructions
     * @return void
     */

    public function setup(array $instructions): void;

    /**
     * Execute build
     *
     * @return void
     */

    public function compile(): void;
}
