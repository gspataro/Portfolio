<?php

namespace GSpataro\Library;

final class Archive
{
    /**
     * Store compiled data
     *
     * @var array
     */

    private array $data = [];

    /**
     * Verify if a data file was archived
     *
     * @param string $path
     * @return bool
     */

    public function has(string $path): bool
    {
        return isset($this->data[$path]);
    }

    /**
     * Add a compiled data file
     *
     * @param string $path
     * @param mixed $content
     * @return void
     */

    public function add(string $path, mixed $content): void
    {
        $this->data[$path] = $content;
    }

    /**
     * Get a compiled data file
     *
     * @param string $path
     * @return mixed
     */

    public function get(string $path): mixed
    {
        return $this->data[$path] ?? '';
    }
}
