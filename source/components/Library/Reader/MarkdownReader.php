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
            $result = $this->markdown->convert(
                file_get_contents($path)
            );

            if ($result instanceof RenderedContentWithFrontMatter) {
                return [
                    'meta' => $result->getFrontMatter(),
                    'content' => $result->getContent()
                ];
            }

            return $result;
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
