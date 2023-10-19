<?php

namespace GSpataro\Library\Interface;

interface ReaderInterface
{
    /**
     * Compile and return the given data
     *
     * @param string $path
     * @return mixed
     */

    public function compile(string $path): mixed;
}
