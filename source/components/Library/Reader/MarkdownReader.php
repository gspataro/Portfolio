<?php

namespace GSpataro\Library\Reader;

use League\CommonMark\ConverterInterface;
use GSpataro\Library\Interface\ReaderInterface;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;

final class MarkdownReader implements ReaderInterface
{
    /**
     * Initialize Markdown reader
     *
     * @param ConverterInterface $markdown
     */

    public function __construct(
        private readonly ConverterInterface $markdown
    ) {
    }

    /**
     * Compile and return the given data
     *
     * @param string $path
     * @return mixed
     */

    public function compile(string $path): mixed
    {
        if (is_file($path)) {
            $content = $this->markdown->convert(
                file_get_contents($path)
            );

            return $content;
        }

        $data = [];

        foreach (glob($path) as $file) {
            if (!is_file($file)) {
                continue;
            }

            //$data = array_merge($data, $this->compile($file));
            $data[] = $this->compile($file);
        }

        return $data;
    }
}
