<?php

namespace GSpataro\Library\Reader;

final class TextReader extends BaseReader
{
    /**
     * Handle a single file
     *
     * @param string $source
     * @return array
     */

    protected function compiler(string $source): array
    {
        $content = file_get_contents($this->getPath($source));

        return $this->prepareOutput([], $content);
    }
}
