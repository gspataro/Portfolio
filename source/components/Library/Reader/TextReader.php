<?php

namespace GSpataro\Library\Reader;

use GSpataro\Library\Interface\ReaderInterface;

final class TextReader implements ReaderInterface
{
    /**
     * Compile and return the given data
     *
     * @param string $path
     * @return mixed
     */

    public function compile(string $path): mixed
    {
        if (is_file($path)) {
            return file_get_contents($path);
        }

        $data = [];

        foreach (glob($path) as $file) {
            if (!is_file($file)) {
                continue;
            }

            $data[] = $this->compile($file);
        }

        return $data;
    }
}
