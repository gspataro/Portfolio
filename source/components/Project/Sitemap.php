<?php

namespace GSpataro\Project;

final class Sitemap
{
    /**
     * Store website sitemap
     *
     * @var array
     */

    private array $sitemap = [];

    /**
     * Verify if a path exists in the sitemap
     *
     * @param string $path
     * @return bool
     */

    public function has(string $path): bool
    {
        return in_array($path, array_values($this->sitemap));
    }

    /**
     * Add a path to the sitemap and return its unique version
     *
     * @param string $tag
     * @param string $path
     * @return string
     */

    public function add(string $tag, string $path): string
    {
        if ($this->has($path)) {
            $path = $this->generateUniquePath($path);
        }

        $this->sitemap[$tag] = $path;
        return $path;
    }

    /**
     * Generate a unique path
     *
     * @param string $path
     * @return string
     */

    public function generateUniquePath(string $path): string
    {
        if (!$this->has($path)) {
            return $path;
        }

        while ($this->has($path)) {
            $pathinfo = pathinfo($path);
            $basepath = $pathinfo['dirname'] . DIRECTORY_SEPARATOR . $pathinfo['filename'];
            $extension = $pathinfo['extension'];
            $path = $basepath . '-copy.' . $extension;
        }

        return $path;
    }

    /**
     * Get a path
     *
     * @param string $tag
     * @return string|null
     */

    public function get(string $tag): ?string
    {
        return $this->sitemap[$tag] ?? null;
    }

    /**
     * Get all the sitemap
     *
     * @return array
     */

    public function getAll(): array
    {
        return $this->sitemap;
    }
}
