<?php

namespace GSpataro\Contractor\Interface;

interface BuilderInterface
{
    /**
     * Execute build
     *
     * @param array $schema
     * @param array $contents
     * @return mixed
     */

    public function compile(array $schema, array $contents = []): mixed;
}
