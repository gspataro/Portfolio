<?php

namespace GSpataro\Library\Reader;

use GSpataro\Library\Archive;
use GSpataro\Library\Interface\ReaderInterface;

abstract class BaseReader implements ReaderInterface
{
    /**
     * Initialize reader
     *
     * @param Archive $archive
     */

    public function __construct(
        protected readonly Archive $archive
    ) {
    }

    /**
     * Get complete path to source
     *
     * @param string $source
     * @return string
     */

    protected function getPath(string $source): string
    {
        if (str_starts_with($source, DIR_DATA)) {
            return $source;
        }

        if (str_starts_with('/', $source)) {
            $source = substr($source, 1);
        }

        return DIR_DATA . DIRECTORY_SEPARATOR . $source;
    }

    /**
     * Content compiler
     *
     * @param string $source
     * @return mixed
     */

    abstract protected function compiler(string $source): mixed;

    /**
     * Handle a single file
     *
     * @param string $source
     * @return mixed
     */

    protected function handleOne(string $source): mixed
    {
        if ($this->archive->has($source)) {
            return $this->archive->get($source);
        }

        $result = $this->compiler($source);
        $this->archive->add($source, $result);

        return $result;
    }

    /**
     * Handle multiple files
     *
     * @param array $sources
     * @return array
     */

    protected function handleMultiple(array $sources): array
    {
        $results = [];

        foreach ($sources as $source) {
            $results[] = $this->handleOne($source);
        }

        return $results;
    }

    /**
     * Handle pattern
     *
     * @param string $pattern
     * @return array
     */

    protected function handlePattern(string $pattern): array
    {
        $results = [];

        foreach (glob($this->getPath($pattern)) as $file) {
            if (!is_file($file)) {
                continue;
            }

            $results[] = $this->handleOne($file);
        }

        return $results;
    }

    /**
     * Compile and return the given data
     *
     * @param string $source
     * @return mixed
     */

    public function compile(string $source): mixed
    {
        if (is_file($this->getPath($source))) {
            return $this->handleOne($source);
        }

        if (str_contains($source, ';')) {
            $sources = explode(';', $source);
            return $this->handleMultiple($sources);
        }

        return $this->handlePattern($source);
    }
}