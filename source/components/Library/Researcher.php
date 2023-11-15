<?php

namespace GSpataro\Library;

final class Researcher
{
    /**
     * Store researches
     *
     * @var array
     */

    private $researches;

    /**
     * Verify if a research exists
     *
     * @param string $label
     * @return bool
     */

    public function has(string $label): bool
    {
        return isset($this->researches[$label]);
    }

    /**
     * Start a new research
     *
     * @param string $label
     * @param array $content
     * @return Research
     */

    public function start(string $label, array $content): Research
    {
        if ($this->has($label)) {
            return $this->researches[$label];
        }

        return new Research($content);
    }
}
