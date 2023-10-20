<?php

namespace GSpataro\Contractor\Builder;

final class SimpleBuilder extends BaseBuilder
{
    /**
     * Compile a page
     *
     * @param array $item
     * @return void
     */

    public function compile(array $item): void
    {
        $outputPath = $this->getOutputPath($item['output'], $item['group'] ?? null);

        $compiledTemplate = $this->twig->render("{$item['template']}.html", $item['contents']);
        file_put_contents($outputPath, $compiledTemplate);
    }
}
