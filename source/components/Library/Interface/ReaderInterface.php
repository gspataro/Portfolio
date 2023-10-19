<?php

namespace GSpataro\Library\Interface;

interface ReaderInterface
{
    /**
     * Compile and return the given data
     *
     * @param string $source
     * @return mixed
     */

    public function compile(string $source): mixed;
}
