<?php

namespace GSpataro\Contractor\Interface;

interface BuilderInterface
{
    /**
     * Execute build
     *
     * @param string $template
     * @param array $item
     * @return void
     */

    public function compile(string $template, array $item): void;
}
