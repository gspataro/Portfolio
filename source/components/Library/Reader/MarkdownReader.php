<?php

namespace GSpataro\Library\Reader;

use League\CommonMark\ConverterInterface;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;

final class MarkdownReader extends BaseReader
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
     * Handle a single file
     *
     * @param string $source
     * @return mixed
     */

    protected function handleOne(string $source): mixed
    {
        $result = $this->markdown->convert(
            file_get_contents($this->getPath($source))
        );

        if ($result instanceof RenderedContentWithFrontMatter) {
            return [
                'meta' => $result->getFrontMatter(),
                'content' => $result->getContent()
            ];
        }

        return $result;
    }
}
