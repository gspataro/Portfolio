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

        if (isset($this->sitemap[$tag])) {
            $tag = $this->generateUniqueTag($tag);
        }

        $this->sitemap[$tag] = $path;
        return $path;
    }

    /**
     * Generate a unique tag
     *
     * @param string $tag
     * @return string
     */

    public function generateUniqueTag(string $tag): string
    {
        if (!isset($this->sitemap[$tag])) {
            return $tag;
        }

        while (isset($this->sitemap[$tag])) {
            $tag .= '-copy';
        }

        return $tag;
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
            $path = addSuffixToFilename($path, '-copy');
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
