<?php

namespace GSpataro\Library\Reader;

use GSpataro\Library\Interface\ReaderInterface;

final class TextReader implements ReaderInterface
{
    /**
     * Compile and return the given data
     *
     * @param string $path
     * @return array
     */

    public function compile(string $path): array
    {
        if (is_file($path)) {
            return [
                pathinfo($path, PATHINFO_FILENAME) => file_get_contents($path)
            ];
        }

        $data = [];

        foreach (glob($path) as $file) {
            if (!is_file($file)) {
                continue;
            }

            $data = array_merge($data, $this->compile($file));
        }

        return $data;
    }
}
