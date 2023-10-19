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
        $outputDirName = pathinfo($item['output'], PATHINFO_DIRNAME);

        if (!is_dir($outputDirName)) {
            mkdir($outputDirName, true);
        }

        $compiledTemplate = $this->twig->render("{$item['template']}.html", $item['contents']);
        file_put_contents($item['output'], $compiledTemplate);
    }
}
