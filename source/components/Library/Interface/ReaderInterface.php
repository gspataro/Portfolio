<?php

namespace GSpataro\Library\Interface;

interface ReaderInterface
{
    /**
     * Compile and return the given data
     *
     * @param string $path
     * @return array
     */

    public function compile(string $path): array;
}
