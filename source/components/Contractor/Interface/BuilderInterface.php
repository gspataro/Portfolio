<?php

namespace GSpataro\Contractor\Interface;

interface BuilderInterface
{
    /**
     * Execute build
     *
     * @param array $item
     * @return void
     */

    public function compile(array $item): void;
}
