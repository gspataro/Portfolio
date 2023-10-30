<?php

namespace GSpataro\Contractor\Builder;

final class PostBuilder extends BaseBuilder
{
    /**
     * Compile post
     *
     * @param array $item
     * @return void
     */

    public function compile(array $item): void
    {
        foreach ($item['contents'] as $group => $contents) {
            foreach ($contents as $content) {
                $outputPath = $this->getOutputPath(
                    $item['tag'] . '.' . $content['meta']['slug'],
                    pathJoin($item['output'], $content['meta']['slug'] . '.html')
                );

                $compiledTemplate = $this->twig->render("{$item['template']}.html", [
                    $group => $content
                ]);
                file_put_contents(pathJoin(DIR_OUTPUT, $outputPath), $compiledTemplate);
            }
        }
    }
}
