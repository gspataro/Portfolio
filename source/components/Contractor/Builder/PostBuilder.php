<?php

namespace GSpataro\Contractor\Builder;

final class PostBuilder extends BaseBuilder
{
    /**
     * Compile post
     *
     * @param string $template
     * @param array $item
     * @return void
     */

    public function compile(string $template, array $item): void
    {
        /*foreach ($this->contents as $group => $contents) {
            foreach ($contents as $content) {
                $outputPath = $this->getOutputPath(
                    $this->tag . '.' . $content['meta']['slug'],
                    pathJoin($this->output, $content['meta']['slug'] . '.html')
                );

                $compiledTemplate = $this->twig->render($this->template . '.html', [
                    $group => $content
                ]);
                file_put_contents(pathJoin(DIR_OUTPUT, $outputPath), $compiledTemplate);
            }
        }*/
        $outputPath = $this->getOutputPath($item['permalink']);
        $compiledTemplate = $this->twig->render($template . '.html', [
            'post' => $item
        ]);

        file_put_contents($outputPath, $compiledTemplate);
    }
}
