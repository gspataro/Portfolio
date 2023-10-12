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
     * @return array
     */

    public function compile(string $path): array
    {
        if (is_file($path)) {
            $content = $this->markdown->convert(
                file_get_contents($path)
            );

            if ($content instanceof RenderedContentWithFrontMatter) {
                $frontMatter = $content->getFrontMatter();

                return [
                    pathinfo($path, PATHINFO_FILENAME) => array_merge($frontMatter, ['content' => $content])
                ];
            }

            return [
                pathinfo($path, PATHINFO_FILENAME) => $content
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
